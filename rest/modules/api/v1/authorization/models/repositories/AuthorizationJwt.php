<?php

namespace rest\modules\api\v1\authorization\models\repositories;

use rest\modules\api\v1\authorization\models\RestUserEntity;
use Yii;
use Firebase\JWT\JWT;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UnauthorizedHttpException;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class AuthorizationJwt
 * @package rest\modules\api\v1\authorization\models\repositories
 */
trait AuthorizationJwt
{
    /**
     * Getter for secret key that's used for generation of JWT
     *
     * @return string secret key used to generate JWT
     */
    protected static function getSecretKey()
    {
        return Yii::$app->params['secretJWT'];
    }

    /**
     * Getter for "header" array that's used for generation of JWT
     *
     * @return array JWT Header Token param, see http://jwt.io/ for details
     */
    protected static function getHeaderToken()
    {
        return [
            'typ' => 'JWT',
            'alg' => self::getAlgorithm()
        ];
    }

    /**
     * Logins user by given JWT encoded string. If string is correctly decoded
     * - array (token) must contain 'jti' param - the id of existing user
     *
     * @param string $token access token to decode
     * @param null|string $type
     * @return mixed|null UserEntity model or null if there's no user
     * @throws UnauthorizedHttpException if anything went wrong
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if ($type == HttpBearerAuth::class) {
            if (RestUserEntity::isAlreadyBlocked($token)) {
                throw new UnauthorizedHttpException('Unauthorized');
            }
                $decodedArray = static::decodeJWT($token);
            if (!isset($decodedArray['jti'])) {
                throw new UnauthorizedHttpException('Unauthorized');
            }
            $id = $decodedArray['jti'];
            return self::findByJTI($id);
        }

        return null;
    }

    /**
     * Decode JWT token
     *
     * @param string $token access token to decode
     * @return array decoded token
     * @throws UnauthorizedHttpException
     */
    public static function decodeJWT($token)
    {
        $secret = static::getSecretKey();
        $errorText = 'Incorrect token';

        try {
            $decoded = JWT::decode($token, $secret, [static::getAlgorithm()]);
        } catch (\Exception $e) {
            if ($e->getMessage() == 'Expired token') {
                $errorText = 'Expired token';
            }
            throw new UnauthorizedHttpException($errorText);
        }

        return (array) $decoded;
    }

    /**
     * Finds UserEntity model using static method findOne
     * Override this method in model if you need to complicate id-management
     *
     * @param integer $id if of user to search
     * @return mixed UserEntity model
     * @throws UnauthorizedHttpException if model is not found
     */
    public static function findByJTI($id)
    {
        $model = RestUserEntity::findOne($id);
        if (empty($model)) {
            throw new UnauthorizedHttpException('Incorrect token');
        }
        return $model;
    }

    /**
     * Getter for encryption algorithm used in JWT generation and decoding
     * Override this method to set up other algorithm.
     *
     * @return string needed algorithm
     */
    public static function getAlgorithm()
    {
        return Yii::$app->params['algorithmJWT'];
    }

    /**
     * Returns some 'id' to encode to token. By default is current model id.
     *
     * If you override this method, be sure that findByJTI is updated too
     * @return integer any unique integer identifier of user
     */
    public function getJTI()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Encodes model data to create custom JWT with model.id set in it
     *
     * @param  array $payloads payloads data to set, default value is empty array.
     * See registered claim names for payloads at https://tools.ietf.org/html/rfc7519#section-4.1
     * @return string encoded JWT
     */
    public function getJWT($payloads = [])
    {
        $secret = static::getSecretKey();
        $token = array_merge($payloads, static::getHeaderToken());

        $token['jti'] = $this->getJTI();

        if (!isset($token['exp'])) {
            $token['exp'] = time() + $this->getTokenExpire();
        }
        return JWT::encode($token, $secret, static::getAlgorithm());
    }

    /**
     * Returns token expire period
     *
     * @return int
     */
    public function getTokenExpire()
    {
        return 3600 * 24 * Yii::$app->params['tokenExpireDays'];
    }

    /**
     * Get payload data in a JWT string
     *
     * @param string $token
     * @param string|null $payloadId Payload ID that want to return,
     * the default value is NULL. If NULL it will return all the payloads data
     * @return mixed payload data
     */
    public static function getPayload($token, $payloadId = null)
    {
        $decodedArray = static::decodeJWT($token);
        if ($payloadId != null) {
            return isset($decodedArray[$payloadId]) ? $decodedArray[$payloadId] : null;
        }

        return $decodedArray;
    }

    /**
     * Returns AuthKey user
     *
     * @return mixed
     */
    public function getAuthKey()
    {
        $headerAuthorizationKey = Yii::$app->getRequest()->getHeaders()->get('Authorization');
        if (
            $headerAuthorizationKey !== null
            && preg_match("/^Bearer\\s+(.*?)$/", $headerAuthorizationKey, $matches)
            && isset($matches[1])
        ) {
            return $matches[1];
        }

        return false;
    }

    /**
     * Validates user token
     *
     * @param string $token
     * @return bool
     */
    public function validateAuthKey($token)
    {
        return (bool) JWT::decode($token, self::getSecretKey(), [static::getAlgorithm()]);
    }

    /**
     * Check token expire status
     *
     * @param int $createdRefreshToken  date of token creation
     * @return bool
     */
    public static function isRefreshTokenExpired($createdRefreshToken): bool
    {
        if (($createdRefreshToken + Yii::$app->params['refreshTokenExpireDays'] * 3600 * 24) < time()) {
           return true;
        }

        return false;
    }


    /**
     * Returns token expire period
     *
     * @return int
     */
    protected static function getRefreshTokenExpire()
    {
        return 3600 * 24 * Yii::$app->params['refreshTokenExpireDays'];
    }

    /**
     * Method creates refresh_token
     *
     * @param array $payload
     * @return string
     */
    public function getRefreshToken(array $payload): string
    {
        // todo а где secret как для access_token?
        if (!isset($payload['exp'])) {
            $payload['exp'] = time() + self::getRefreshTokenExpire();
        }
        return base64_encode(json_encode($payload));
    }

    /**
     * Method returns user id
     *
     * @param $refreshToken
     * @return mixed
     * @throws UnprocessableEntityHttpException
     */
    public static function getRefreshTokenId($refreshToken): int
    {
        $token = json_decode(base64_decode($refreshToken));
        if (isset($token->id)) {
            return ($token->id);
        }
        throw new UnprocessableEntityHttpException('Invalid refresh token');
    }
}