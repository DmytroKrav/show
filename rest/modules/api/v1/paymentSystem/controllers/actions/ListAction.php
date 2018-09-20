<?php

namespace rest\modules\api\v1\paymentSystem\controllers\actions;

use common\models\paymentSystem\PaymentSystem;
use yii\rest\Action;
use Yii;

class ListAction extends Action
{
    /**
     * @SWG\Get(path="/payment-system",
     *      tags={"Payment System module"},
     *      summary="Payment systems list",
     *      description="Get payment systems",
     *      produces={"application/json"},
     *      @SWG\Response(
     *         response = 200,
     *         description = "success",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="items", type="object",
     *                   @SWG\Property(property="id", type="integer", description="Payment System id"),
     *                   @SWG\Property(property="name", type="string", description="Payment System name"),
     *                   @SWG\Property(property="currency", type="string", description="Payment System currency"),
     *              ),
     *         ),
     *         examples = {
     *             {
     *                 "id": 2,
     *                 "name": "Webmoney RUB",
     *                 "currency": "rub",
     *             },
     *             {
     *                 "id": 3,
     *                 "name": "ВТБ 24 RUB",
     *                 "currency": "rub",
     *             },
     *             {
     *                 "id": 4,
     *                 "name": "Приват24 UAH",
     *                 "currency": "uah",
     *             }
     *         }
     *     ),
     * )
     *
     * @return \yii\data\ArrayDataProvider
     */
    public function run()
    {
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = $this->modelClass;
        return $paymentSystem::getList();
    }
}
