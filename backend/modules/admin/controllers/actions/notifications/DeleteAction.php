<?php

namespace backend\modules\admin\controllers\actions\notifications;

use backend\modules\admin\controllers\NotificationsController;
use yii\base\Action;
use Yii;

class DeleteAction extends Action
{
    /** @var NotificationsController */
    public $controller;

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        $notification = $this->controller->findNotification($id);
        if ($notification->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'The notification was successfully deleted.'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Something wrong, please try again later'));
        }

        return $this->controller->redirect('index');
    }
}
