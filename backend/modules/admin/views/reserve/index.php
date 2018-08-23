<?php

use common\models\review\ReviewEntity;
use yiister\gentelella\widgets\grid\GridView;
use yiister\gentelella\widgets\Panel;
use yii\widgets\Pjax;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use backend\models\BackendUser;
use common\models\reserve\ReserveEntity;

/** @var \yii\web\View $this */
/** @var \common\models\reserve\ReserveEntitySearch $searchModel */
/** @var \yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Reserves');
$this->params['breadcrumbs']['title'] = $this->title;
?>

<div class="reserve-index">
    <?php Panel::begin([
        'header' => Yii::t('app', 'Reserves'),
        'collapsable' => true,
        'removable' => true,
    ]) ?>
        <?php Pjax::begin() ?>
            <?= GridView::widget([
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'payment_system',
                        'filter' => ReserveEntity::paymentSystemLabels(),
                        'value' => function (ReserveEntity $reserve) {
                            return ReserveEntity::getPaymentSystemValue($reserve->payment_system);
                        }
                    ],
                    [
                        'attribute' => 'currency',
                        'filter' => ReserveEntity::currencyLabels(),
                        'value' => function (ReserveEntity $reserve) {
                            return ReserveEntity::getCurrencyValue($reserve->currency);
                        }
                    ],
                    [
                        'attribute' => 'sum',
                        'value' => function (ReserveEntity $reserve) {
                            return round($reserve->sum, 2);
                        }
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'date',
                        'value' => 'created_at',
                        'filter' => DateRangePicker::widget([
                            'model'          => $searchModel,
                            'attribute'      => 'createdDateRange',
                            'convertFormat'  => true,
                            'pluginOptions'  => [
                                'timePicker' => true,
                                'locale' => [
                                    'format' => 'Y-m-d',
                                ]
                            ]
                        ]),
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'date',
                        'value' => 'created_at',
                        'filter' => DateRangePicker::widget([
                            'model'          => $searchModel,
                            'attribute'      => 'updatedDateRange',
                            'convertFormat'  => true,
                            'pluginOptions'  => [
                                'timePicker' => true,
                                'locale' => [
                                    'format' => 'Y-m-d',
                                ]
                            ]
                        ]),
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{view} {update}',
                        'buttons' => [
                            'view' => function ($url, ReserveEntity $reserve) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open"></span>',
                                    Url::to(['/reserve/view/' . $reserve->id]),
                                    ['title' => Yii::t('app', 'View')]
                                );
                            },
                            'update' => function ($url, ReserveEntity $reserve) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                    Url::to(['/reserve/update/' . $reserve->id]),
                                    ['title' => Yii::t('app', 'Edit')]
                                );
                            }
                        ],
                    ],
                ],
            ]) ?>
        <?php Pjax::end() ?>
    <?php Panel::end() ?>
</div>
