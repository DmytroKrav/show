<?php

namespace common\models\userNotifications;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\userNotifications\UserNotificationsEntity;

/**
 * UserNotificationsSearch represents the model behind the search form of `common\models\userNotifications\UserNotificationsEntity`.
 */
class UserNotificationsSearch extends UserNotificationsEntity
{
    public $dateRange;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['id', 'recipient_id', 'created_at', 'updated_at'], 'integer'],
            [['status', 'text', 'dateRange',], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserNotificationsEntity::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'recipient_id' => $this->recipient_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'text', $this->text]);

        if (!empty($this->dateRange) && strpos($this->dateRange, '-') !== false) {
            list($fromDate, $toDate) = explode(' - ', $this->dateRange);
            $query->andFilterWhere(['between', 'created_at', strtotime($fromDate), strtotime($toDate)]);
        }

        return $dataProvider;
    }
}
