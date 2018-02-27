<?php

namespace rest\modules\api\v1\reserve\controllers\actions;

use common\models\reserve\ReserveEntity;
use Yii;

/**
 * Class ListAction
 * @package rest\api\v1\reserve\controllers\actions
 */
class ListAction extends \yii\rest\Action
{
    /**
     * @return array
     */
    public function run(): array
    {
        /** @var ReserveEntity $reserve */
        $reserve = new $this->modelClass;

        return $reserve->find()->all();
    }
}