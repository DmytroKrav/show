<?php

namespace backend\modules\admin\controllers;

use backend\models\BackendUser;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use Yii;
use backend\modules\admin\controllers\actions\user\{
    IndexAction, UpdateStatusAction, ViewAction
};

class UserController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'view', 'update-status',],
                        'roles'   => ['admin', 'manager']
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'index' => [
                'class' => IndexAction::class,
            ],
            'view' => [
                'class' => ViewAction::class,
            ],
            'update-status' => [
                'class' => UpdateStatusAction::class,
            ],
        ];
    }

    /**
     * Finds the BackendUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BackendUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($user = BackendUser::findOne($id)) !== null) {
            return $user;
        }
        throw new NotFoundHttpException(Yii::t('app', 'User not found'));
    }
}
