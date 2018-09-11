<?php

use common\models\userNotifications\NotificationsEntity;
use common\models\userNotifications\UserNotificationsEntity;
use yiister\gentelella\widgets\Panel;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\userNotifications\UserNotificationsEntity as Notification;
use kartik\daterange\DateRangePicker;
use yii\helpers\{ StringHelper, Html };
use common\helpers\{ UrlHelper, Toolbar };
use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var \common\models\userNotifications\NotificationsSearch $searchModel */

$this->title = Yii::t('app', 'Notifications');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="notifications-index">
    <?php Panel::begin([
        'header' => Yii::t('app', 'Notifications'),
        'collapsable' => true,
    ]) ?>
        <?php Pjax::begin() ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'filterUrl' => UrlHelper::getFilterUrl(),
                'hover' => true,
                'toolbar' =>  [
                    ['content' =>
                        Toolbar::deleteButton('/notifications/delete-all', Yii::t('app', 'Delete all')) .
                        Toolbar::readAllButton('/notifications/read-all') .
                        Toolbar::resetButton()
                    ],
                    '{export}',
                    '{toggleData}',
                ],
                'export' => [
                    'fontAwesome' => true
                ],
                'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                    'heading' => '<i class="glyphicon glyphicon-list"></i>&nbsp;' . Yii::t('app', 'List')
                ],
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '36px',
                        'header' => '',
                        'headerOptions' => ['class' => 'kartik-sheet-style']
                    ],
                    [
                        'attribute' => 'full_name',
                        'label' => Yii::t('app', 'Full name'),
                        'value' => function (UserNotificationsEntity $userNotification) {
                            return $userNotification->userProfile->UserFullName ?? null;
                        }
                    ],
                    [
                        'attribute' => 'is_read',
                        'label' => 'Status',
                        'filter' =>  (new UserNotificationsEntity)->getIsReadStatuses(),
                        'value' => function (UserNotificationsEntity $userNotification) {
                            return UserNotificationsEntity::getIsReadLabel($userNotification->is_read);
                        }
                    ],
                    [
                        'attribute' => 'text',
                        'value' => function (UserNotificationsEntity $userNotification) {
                            if ($userNotification->notification->type = NotificationsEntity::TYPE_NEW_USER) {
                                return StringHelper::truncate(Yii::t('app', $userNotification->notification->text, [
                                    'phone_number' => $userNotification->notification->custom_data->phone_number ?? null
                                ]), 40);
                            }
                            return StringHelper::truncate(Html::encode($userNotification->notification->text), 180);
                        }
                    ],
                    [
                        'attribute' => 'dateRange',
                        'format' => 'date',
                        'value' => 'notification.created_at',
                        'filter' => DateRangePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'dateRange',
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'timePicker' => true,
                                'locale' => [
                                    'format' => 'Y-m-d',
                                ]
                            ]
                        ]),
                    ],
                    [
                        'class' => \yii\grid\ActionColumn::class,
                        'template' => '{view}&nbsp{delete}',
                        'buttons' => [
                            'delete' => function($url, Notification $notification) {
                                $url = Url::to(['/notifications/delete', 'id' => $notification->id]);
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('app', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                ]);
                            },
                        ]
                    ],
                ],
            ]) ?>
        <?php Pjax::end() ?>
    <?php Panel::end() ?>
</div>

