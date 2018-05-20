<?php

namespace backend\modules\authorization\controllers\actions\authorization;

use backend\modules\authorization\models\LoginForm;
use backend\modules\authorization\models\RegistrationForm;
use yii\base\Action;

class LoginAction extends Action
{
    public $view = '@backend/modules/authorization/views/authorization/login';
    public $layout = false;

    public function run()
    {
        $modelLogin = new LoginForm();
        if ($invitedCode = \Yii::$app->request->get('invite_code')) {
            $result = $modelLogin->loginByInvite(\Yii::$app->request->get('invite_code'));
            return $this->controller->redirect(['/index', 'inviteCode' => $invitedCode]);
        }
        if ($modelLogin->load(\Yii::$app->request->post()) && $modelLogin->login()) {
            if (\Yii::$app->user->can('admin') || \Yii::$app->user->can('manager')) {
                return $this->controller->redirect(['/index']);
            } else {
                \Yii::$app->getSession()->setFlash('Enter_failed', "You haven't permission to enter to protected area. Please check your credentials. ");
                return $this->controller->redirect(\Yii::$app->homeUrl);
            }
        }

        return $this->controller->render($this->view, [
            'modelLogin'        => $modelLogin,
        ]);
    }
}