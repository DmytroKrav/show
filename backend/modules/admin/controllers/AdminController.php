<?php

namespace backend\modules\admin\controllers;

use backend\modules\admin\controllers\actions\admin\IndexAction;
use backend\modules\admin\controllers\actions\admin\InviteManagerAction;
use yii\web\Controller;

class AdminController extends Controller
{
    public function beforeAction($action)
    {
        if (!\Yii::$app->user->can('admin') && !\Yii::$app->user->can('manager')) {
            return $this->redirect(\Yii::$app->homeUrl);
        }
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'index'         => [
                'class' => IndexAction::class
            ],
            'invite-manager' => [
                'class' => InviteManagerAction::class
            ],
            'update-manager-password' => [
                'class' => InviteManagerAction::class
            ],
        ];
    }
}