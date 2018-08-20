<?php

namespace common\models\userNotifications;

use common\models\userNotifications\repositories\RestUserNotificationsRepository;
use common\models\userProfile\UserProfileEntity;
use rest\behaviors\ValidationExceptionFirstMessage;
use rest\modules\api\v1\authorization\models\RestUserEntity;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use Yii;
use common\models\user\User;

/**
 * Class UserNotificationsEntity
 * @package common\models\userNotifications
 *
 * @mixin ValidationExceptionFirstMessage
 *
 * @property integer $id
 * @property integer $recipient_id
 * @property string $text
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $recipient
 */
class UserNotificationsEntity extends ActiveRecord
{
    use RestUserNotificationsRepository;

    const STATUS_READ   = 'read';
    const STATUS_UNREAD = 'unread';

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user_notifications}}';
    }

    /**
     * @return array
     */
    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_READ => Yii::t('app', 'Read'),
            self::STATUS_UNREAD => Yii::t('app', 'Unread'),
        ];
    }

    /**
     * @param string $status
     * @return string
     */
    public static function getStatusValue($status): string
    {
        $statuses = static::getStatusLabels();
        return $statuses[$status];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id'           => '#',
            'recipient_id' => Yii::t('app', 'Recipient'),
            'text'         => Yii::t('app', 'Text'),
            'status'       => Yii::t('app', 'Status'),
            'created_at'   => Yii::t('app', 'Created At'),
            'updated_at'   => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['recipient_id', 'integer'],
            ['text', 'string'],
            ['status', 'in', 'range' => [self::STATUS_READ, self::STATUS_UNREAD]],
            [
                'recipient_id',
                'exist',
                'skipOnError'     => false,
                'targetClass'     => RestUserEntity::class,
                'targetAttribute' => ['recipient_id' => 'id'],
            ],
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'TimestampBehavior'               => TimestampBehavior::class,
            'ValidationExceptionFirstMessage' => ValidationExceptionFirstMessage::class,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::class, ['id' => 'recipient_id']);
    }

    /**
     * @return int
     */
    public static function getCountUnreadNotificationsByRecipient(): int
    {
       return (int) static::find()->where(['status' => self::STATUS_UNREAD, 'recipient_id' => Yii::$app->user->id])->count();
    }

    /**
     * Generates a message for a new user notification
     *
     * @param $params array
     *
     * @return string
     */
    public static function getMessageForNewUser(array $params)
    {
        $phone_number = $params['phone_number'];
        $message = Yii::t('app', 'A new user has been registered. Registration was conducted with a phone number') . ' ';
        $message .= $phone_number;

        return $message;
    }

    /**
     * Generates a message for a newly created bid. Status accepted is default
     *
     * @param $params array
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public static function getMessageForNewBid(array $params)
    {
        $sum = $params['to_sum'];
        $currency = $params['to_currency'];
        $to_wallet = $params['to_wallet'];

        $message = <<<EOT
Ваша заявка приянта. Перевод на карту {$sum} {$currency} через приложение Wallet. Получатель:
Карта/счет {$to_wallet}
EOT;

        return $message;
    }

    /**
     * Returns a list of users unread notifications
     * @return static[]
     */
    public static function getUnreadUserNotifications($limit)
    {
        return self::find()
            ->where(['status' => self::STATUS_UNREAD, 'recipient_id' => Yii::$app->user->id])
            ->with('userProfile')
            ->limit($limit)
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }

    /**
     * Relates UserNotificationsEntity model with UserProfile model
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfileEntity::class, ['user_id' => 'recipient_id']);
    }

}
