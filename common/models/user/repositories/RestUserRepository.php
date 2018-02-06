<?php

namespace common\models\user\repositories;

use common\models\user\User;
use common\models\userProfile\UserProfileEntity;
use GuzzleHttp\Client;
use rest\behaviors\ResponseBehavior;
use rest\behaviors\ValidationExceptionFirstMessage;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use Yii;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class RestUserRepository
 * @package common\models\user\repositories
 */
trait RestUserRepository
{
    /**
     * @param $params
     * @return array
     * @throws ServerErrorHttpException
     * @throws UnprocessableEntityHttpException
     * @throws \yii\db\Exception
     */
    public function vkRegister($params)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $client = new Client(['headers' => ['Content-Type' => 'application/json']]);
            $result = $client->request(
                'GET',
                'https://api.vk.com/method/users.get',
                [
                    'query' => [
                        'access_token' => $params['token'],
                        'fields' => 'photo_50',
                    ]
                ]
            );

            if ($result->getStatusCode() == 200) {
                $userData = json_decode($result->getBody()->getContents());
                if (isset($userData->error)) {
                    throw new ServerErrorHttpException;
                }

                $userData = array_shift($userData->response);

                $user = new User([
                    'source'        => self::VK,
                    'source_id'     => (string) $userData->uid,
                    'auth_key'      => Yii::$app->getSecurity()->generateRandomString(32),
                    'email'         => $params['email'],
                    'password_hash' => Yii::$app->getSecurity()->generateRandomString(32)
                ]);

                if (!$user->save()) {
                    return (new ValidationExceptionFirstMessage())->throwModelException($user->errors);
                }

                $userProfile = new UserProfileEntity([
                    'scenario'  => UserProfileEntity::SCENARIO_CREATE,
                    'name'      => $userData->first_name,
                    'last_name' => $userData->last_name,
                    'user_id'   => $user->id,
                    'avatar'    => $userData->photo_50
                ]);

                if ($userProfile->save(false)) {
                    $transaction->commit();
                    return (new ResponseBehavior())->setResponse(201, 'Регистрация прошла успешно.');
                }

                $transaction->rollBack();
                throw new ServerErrorHttpException;
            }

            throw new ServerErrorHttpException;
        } catch (UnprocessableEntityHttpException $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new ServerErrorHttpException('Произошла ошибка при регистрации.');
        }
    }

    /**
     * @param $token
     * @return array
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function vkLogin($token)
    {
        try {
            $client = new Client(['headers' => ['Content-Type' => 'application/json']]);
            $result = $client->request(
                'GET',
                'https://api.vk.com/method/users.get',
                [
                    'query' => [
                        'access_token' => $token,
                        'v'            => 5.71
                    ]
                ]
            );

            if ($result->getStatusCode() == 200) {
                $userData = json_decode($result->getBody()->getContents());
                if (isset($userData->error)) {
                    throw new ServerErrorHttpException;
                }

                $uid = array_shift($userData->response)->id;

                if (empty($user = User::findOne(['source' => User::VK, 'source_id' => $uid]))) {
                    throw new NotFoundHttpException;
                }

                return (new ResponseBehavior())->setResponse(200, 'Авторизация прошла успешно.');
            }
            throw new ServerErrorHttpException;
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException('Пользователь не найден, пройдите процедуру регистрации.');
        } catch (\Exception $e) {
            throw new ServerErrorHttpException('Произошла ошибка при авторизации.');
        }
    }
}