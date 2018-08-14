<?php

namespace backend\modules\admin\controllers\actions\admin;

use backend\modules\admin\models\UserEntitySearch;
use yii\base\Action;
use yii\data\ActiveDataProvider;

/**
 * Class ManagersListAction
 * @package backend\modules\admin\controllers\actions\admin
 */
class ManagersListAction extends Action
{
    public $view = '@backend/modules/admin/views/admin/managers-list';

    /**
     * Renders an admin panel
     * @return string
     */
    public function run()
    {
        $searchModel = new UserEntitySearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->controller->render($this->view, [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel
        ]);
    }
}
