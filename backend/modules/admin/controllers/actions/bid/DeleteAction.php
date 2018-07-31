<?php

namespace backend\modules\admin\controllers\actions\bid;

use common\models\bid\BidEntity;
use yii\base\Action;

/**
 * Class DeleteAction
 * @package backend\modules\admin\controllers\actions\bid
 */
class DeleteAction extends Action
{
    /**
     * Delete's a bid
     * @param $id integer the id of a bid
     * @return string|\yii\web\Response
     */
    public function run($id)
    {
        $bid = BidEntity::findOne(['id' => $id]);
        if ($bid && $bid->delete()) {
            \Yii::$app->session->setFlash('delete-success', 'bid was successfully deleted');
            return $this->controller->redirect('/admin/bids');
        }
        \Yii::$app->session->setFlash('delete-fail', 'Something wrong, please try again later');
        return false;
    }

}