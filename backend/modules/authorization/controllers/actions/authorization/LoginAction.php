<?php

namespace backend\modules\authorization\controllers\actions\authorization;

use backend\modules\authorization\models\LoginForm;
use yii\base\Action;

class LoginAction extends Action
{
    public $view = '@backend/modules/authorization/views/authorization/login';

    public function run()
    {
        if (!\Yii::$app->user->isGuest && \Yii::$app->user->can('admin')) {
            return $this->controller->redirect('@backend/modules/admin/admin/index');
        }
        $modelLogin = new LoginForm();
        if ($modelLogin->load(\Yii::$app->request->post()) && $modelLogin->login()) {
            if (\Yii::$app->user->can('admin')) {
                return $this->controller->redirect(['/index']);
            } else {
                \Yii::$app->getSession()->setFlash('Enter_failed', "You haven't permission to enter to protected area. Please check your credentials. ");
                return $this->controller->redirect(\Yii::$app->homeUrl);
            }
        }

        return $this->controller->render($this->view, [
            'modelLogin' => $modelLogin
        ]);
    }
}