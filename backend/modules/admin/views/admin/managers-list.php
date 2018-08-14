<?php
use backend\models\BackendUser;
use backend\modules\authorization\models\RegistrationForm;
use common\models\user\User;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<?= Html::a('Invite new manager',['/invite-manager'], ['class' => 'btn btn-primary'])?>
<div class="site-index">
<?php Pjax::begin(); ?>
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns' => [
                [
                    'attribute' => 'full_name',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model['last_name'] . ' ' . $model['name'];
                    },
                ],
                'email',
                'phone_number',
                [
                    'attribute' => 'status',
                    'filter'    => BackendUser::getStatusLabels(),
                ],
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'template' => '{delete} {reInvite}',
                    'buttons' => [
                        'delete' => function($url, $model) {
                            $customUrl = \Yii::$app->urlManager->createUrl([
                                'admin/admin/delete-manager',
                                'user_id' => $model['user_id']
                            ]);
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $customUrl, [
                                'title' => Yii::t('app', 'lead-delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure?'),
                                ]);
                        },
                        'reInvite' => function($url, $model) {
                            $reInviteUrl = \Yii::$app->urlManager->createUrl([
                                '/admin/admin/re-invite',
                                'user_id' => $model['user_id'],
                            ]);
                            return Html::a('<span class="glyphicon glyphicon-envelope"></span>', false, [
                                'reInviteUrl' => $reInviteUrl,
                                'title' => Yii::t('app', 'reInvite'),
                                'class' => 'ajaxReInviteMessage',
                                'method' => 'post'
                            ]);
                        }
                    ]
                ]

            ]

        ])
    ?>
<?php Pjax::end(); ?>
    <div id="loader">
    </div>
</div>
