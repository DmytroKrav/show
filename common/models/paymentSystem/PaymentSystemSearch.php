<?php

namespace common\models\paymentSystem;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BidSearch represents the model behind the search form of `common\models\bid\BidEntity`.
 */
class PaymentSystemSearch extends PaymentSystem
{
    public $dateRange;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['id', 'visible', 'created_at', 'updated_at',], 'integer'],
            [['name', 'currency',], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios(): array
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
        $query = PaymentSystem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => $params['pageSize'] ?? Yii::$app->params['pageSize'],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'visible'  => $this->visible,
            'currency' => $this->currency,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        if (!empty($this->dateRange) && strpos($this->dateRange, '-') !== false) {
            list($fromDate, $toDate) = explode(' - ', $this->dateRange);
            $query->andFilterWhere(['between', 'created_at', strtotime($fromDate), strtotime($toDate)]);
        }

        return $dataProvider;
    }
}

