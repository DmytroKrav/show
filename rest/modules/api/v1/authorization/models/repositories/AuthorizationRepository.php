<?php

namespace rest\modules\api\v1\authorization\models\repositories;

 // todo
use rest\modules\api\v1\authorization\models\BlockToken;
use rest\modules\api\v1\authorization\models\RestUserEntity;
use yii\base\ErrorHandler;
use yii\base\Exception;
use yii\web\{
    HttpException, NotFoundHttpException, ServerErrorHttpException, UnauthorizedHttpException, UnprocessableEntityHttpException
};
use yii\db\Exception as ExceptionDb;

/**
 * Class AuthorizationRepository
 * @package rest\modules\api\v1\authorization\models\repositories
 */
trait AuthorizationRepository
{
    /**
     * Add new user to db with the set of income data
     *
     * @param $params array of POST data
     *
     * @return RestUserEntity whether the attributes are valid and the record is inserted successfully.
     *
     * @throws ServerErrorHttpException
     * @throws UnprocessableEntityHttpException
     */
    public function register(array $params)
    {
        $transaction = \Yii::$app->db->beginTransaction();

         // todo описывал раньше про refresh_token https://gist.github.com/zmts/802dc9c3510d79fd40f9dc38a12bccfc

        try {
            $user = new RestUserEntity();
            $user->setScenario(self::SCENARIO_REGISTER);
            $user->setAttributes([
                'source'                => self::NATIVE,
                'phone_number'          => $params['phone_number'], // todo зачем тут null? у нас может пользователь без номера телефона или пароля?
                'terms_condition'       => $params['terms_condition'], // todo зачем тут 0
                'password'              => $params['password'], // todo зачем тут null
                'confirm_password'      => $params['confirm_password'], // todo зачем тут null
                'verification_code'     => rand(1000, 9999),
            ]);

            if (!$user->validate()) {
                return $this->throwModelException($user->errors);
            }

            if (!$user->save()) {
                return $this->throwModelException($user->errors);
            }

            \Yii::$app->sendSms->run('Ваш код верификации', $user->phone_number);

            $transaction->commit();

            return $user;
        } catch (UnprocessableEntityHttpException $e) {
            $transaction->rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        } catch (ServerErrorHttpException $e) {
            $transaction->rollBack();
            \Yii::error($e->getMessage());
            throw new ServerErrorHttpException('Произошла ошибка при регистрации.');
        }
    }

    // todo что это за комментрий "Request user profile and return user model" ?
    /**
     * Login user in a system
     *
     * @param $params array of the POST data
     *
     * @return null|AuthorizationRepository|RestUserEntity
     *
     * @throws NotFoundHttpException
     * @throws UnprocessableEntityHttpException
     */
    public function login(array $params)
    {
        $user = new self();
        $user->setScenario(self::SCENARIO_LOGIN);
        $user->setAttributes($params);
        if (!$user->validate()) {
            $this->throwModelException($user->errors);
        }

        /** @var RestUserEntity $user */
        $user = $this->getUserByPhoneNumber($params); // todo  для чего это если у нас при логине остался только телефон?
        if ($user->validatePassword($params['password'])) {
            return $user;
        }

        return null;
    }

    /**
     * Get user's data from db
     *
     * @param $params array of the POST data
     *
     * @return RestUserEntity
     *
     * @throws NotFoundHttpException if there is no such user
     */
    protected function getUserByParams(array $params)
    {
        if (isset($params['email']) && !empty($user = self::findOne(['email' => $params['email']]))) {
            return $user;
        } elseif (
            isset($params['phone_number'])
            && !empty($user = self::findOne(['phone_number' => $params['phone_number']]))
        ) { // todo 120 символов не больше в одну строку. Вот такую линию можно настроить в phpstorm http://joxi.ru/gmvR63DHxkowQm
            return $user;
        }

        throw new NotFoundHttpException('Пользователь не найден, пройдите этап регистрации.');
    }

    /**
     * @param string $phoneNumber
     *
     * @return RestUserEntity
     *
     * @throws NotFoundHttpException
     */
    protected function getUserByPhoneNumber(string $phoneNumber): RestUserEntity
    {
        $user = self::findOne(['phoneNumber' => $phoneNumber]);
        if ($user) {
            return $user;
        }
        throw new NotFoundHttpException('No such user');
    }

    /**
     * Notes new users password in db
     *
     * @param $params array of the POST data
     *
     * @return bool the user's record was updated with a new password successfully
     *
     * @throws NotFoundHttpException
     * @throws UnprocessableEntityHttpException
     */
    public function updatePassword(array $params)
    {
        $userModel = RestUserEntity::findOne(\Yii::$app->user->id);
        $userModel->setScenario(RestUserEntity::SCENARIO_UPDATE_PASSWORD);
        $userModel->setAttributes($params);

        if (!$userModel->validate()) {
            return $this->throwModelException($userModel->errors);
        }

        $userModel->password = $params['new_password'];

        if ($userModel->save(false)) {
            return true;
        }
        
        $this->throwModelException($userModel->errors);
    }

    /**
     * @return null|RestUserEntity
     *
     * @throws NotFoundHttpException
     */
    public function loginGuest()
    {
        /** @var RestUserEntity $userModel */
        $userModel = $this->getUserByParams(['email' => \Yii::$app->params['guest-email']]);
        if ($userModel && $userModel->validatePassword(\Yii::$app->params['guest-password'])) {
            return $userModel;
        }
        return null;
    }

    /**
     * Create new access token using refresh_token
     *
     * @return array
     *
     * @throws UnauthorizedHttpException
     * @throws UnprocessableEntityHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function generateNewAccessToken()
    {
        // todo все эти три сточки можно заменить на \Yii::$app->user->getId() но они вообще не нужны

        // todo у нас в refresh_token тоже должен быть зашит userID. Получив этот userID из refresh_token мы ищем пользователя в БД
        // todo после того как я получил пользователя из БД я сравниваю refresh_token полученный и тот что в БД
        $currentRefreshToken = \Yii::$app->getRequest()->getBodyParam('refresh_token');

        try {
            $user = RestUserEntity::findOne(RestUserEntity::getRefreshTokenId($currentRefreshToken));
            if (!$user) {
                throw new NotFoundHttpException('No such user');
            }

            if (RestUserEntity::isRefreshTokenExpired($user->created_refresh_token)) {
                throw new UnauthorizedHttpException('Expired token');
            }
            if ($user->refresh_token != $currentRefreshToken) {
                throw new UnprocessableEntityHttpException('Wrong refresh_token');
            }

            // todo не вижу проверки на срок действия refresh_token
            // Так в bb, и решил ,что такая логика работы стокенами
            // todo для чего вот это я не пойму.токен и так expired зачем еще его в БД записывать
            $newAccessToken = $user->getJWT();
            $user->refresh_token = $user->getRefreshToken(['id' => $user->id]);
            $user->created_refresh_token = time();

            if (!$user->save()) {
                return $this->throwModelException($user->errors);
            }

            return [
                'access_token' => $newAccessToken,
                'refresh_token' => $user->refresh_token,
                // а разве не в любом случает он должен обновиться?
                //todo если срок действия у refresh_token истек тоже, но нужно новый генерить
                'exp' => RestUserEntity::getPayload($newAccessToken, 'exp'),
                'user' => [
                    'id' => $user->getId(),
                    'phone_number' => $user->phone_number,
                    'role' => $user->getUserRole($user->id),
                    'created_at' => $user->created_at,
                    'status' => $user->status
                ]
            ];
            // а почему?
            // todo все эти  catch тут лишние
        } catch (UnauthorizedHttpException $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (UnprocessableEntityHttpException $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        } catch (Exception $e){
            \Yii::error(ErrorHandler::convertExceptionToString($e));
            throw new ServerErrorHttpException('Произошла ошибка при генерации нового токена.');
        }
    }

    /**
     * Changes the status of user's account
     *
     * @param $params array of the POST input data
     *
     * @return RestUserEntity
     *
     * @throws NotFoundHttpException
     * @throws UnprocessableEntityHttpException
     * @throws ServerErrorHttpException
     */
    public function verifyUser(array $params)
    {
        $user = new RestUserEntity();
        $user->setScenario(self::SCENARIO_VERIFY_PROFILE);
        try {
            $user->setAttributes([
                'verification_code' => $params['verification_code'] ?? null,
                'phone_number'      => $params['phone_number'] ?? null,
            ]);
            if (!$user->validate()) {
                return $this->throwModelException($user->errors);
            }

            $user = RestUserEntity::findOne(['phone_number' => $user->phone_number]);
            if (!$user) {
                throw new NotFoundHttpException('User not found');
            }

            if ($user->verification_code !== (int)($params['verification_code'])) {
                throw new UnprocessableEntityHttpException('Wrong verification code');
            }

            $user->status = RestUserEntity::STATUS_VERIFIED;
            $user->verification_code = null;
            $user->refresh_token = $user->getRefreshToken(['id' => $user->id]);// todo зачем?!!!!
            $user->created_refresh_token = time();  // todo зачем?!!!!


            if (!$user->save()) {
                return $this->throwModelException($user->errors);
            }
            return $user; // todo не смущает такое http://joxi.ru/krDp18Wt0pjVpr ?
        } catch (UnprocessableEntityHttpException $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (ServerErrorHttpException $e) {
            throw new ServerErrorHttpException('Internal server error');
        }
    }

    /**
     * Logout user from a system
     *
     * @return bool
     * @throws ServerErrorHttpException
     */
    public function logout()
    {
        $restUser = RestUserEntity::findOne(\Yii::$app->user->id);

        try {
            $restUser->addBlackListToken($restUser->getAuthKey());
            return true;
        } catch (ServerErrorHttpException $e) {
            throw new ServerErrorHttpException();
        }
    }

    /**
     * Check the token for the block
     *
     * @param bool
     * @return bool
     */
    public static function isAlreadyBlocked($token)
    {
        if (BlockToken::find()->where(['token' => $token])->one()) {
            return true;
        }
        return false;
    }
}