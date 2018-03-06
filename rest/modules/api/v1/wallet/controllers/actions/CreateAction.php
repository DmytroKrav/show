<?php

namespace rest\modules\api\v1\wallet\controllers\actions;

use common\models\wallet\WalletEntity;
use rest\modules\api\v1\wallet\controllers\WalletController;
use yii\rest\Action;
use yii\web\UnprocessableEntityHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Class CreateAction
 * @package rest\modules\api\v1\wallet\controllers\actions
 */
class CreateAction extends Action
{
    /** @var  WalletController */
    public $controller;

    /**
     * Creates a new Wallet model
     *
     * @SWG\Post(path="/wallet",
     *      tags={"Wallet module"},
     *      summary="Wallet create",
     *      description="Creates a user wallet",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *        in = "header",
     *        name = "Authorization",
     *        description = "Authorization: Bearer &lt;token&gt;",
     *        required = true,
     *        type = "string"
     *      ),
     *      @SWG\Parameter(
     *          in = "formData",
     *          name = "payment_system",
     *          description = "payment system",
     *          required = true,
     *          type = "string",
     *          enum = {"yandex_money", "web_money", "tincoff", "privat24", "sberbank", "qiwi"}
     *      ),
     *      @SWG\Parameter(
     *          in = "formData",
     *          name = "number",
     *          description = "Wallet number",
     *          required = true,
     *          type = "string"
     *      ),
     *      @SWG\Parameter(
     *          in = "formData",
     *          name = "name",
     *          description = "Wallet name",
     *          required = true,
     *          type = "string"
     *      ),
     *      @SWG\Response(
     *         response = 201,
     *         description = "success",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="status", type="integer", description="Status code"),
     *              @SWG\Property(property="message", type="string", description="Status message"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="id", type="integer", description="Wallet id"),
     *                  @SWG\Property(property="number", type="integer", description="Wallet number"),
     *                  @SWG\Property(property="name", type="string", description="Wallet name"),
     *                  @SWG\Property(property="payment_system", type="string", description="Payment system"),
     *                  @SWG\Property(property="created_at", type="integer", description="created at")
     *              ),
     *         ),
     *         examples = {
     *              "status": 201,
     *              "message": "Шаблон кошелька успешно создан.",
     *              "data": {
     *                  "id": 6,
     *                  "name": "Мой первый шалон",
     *                  "number": "1234123412341234",
     *                  "payment_system": "yandex_money",
     *                  "created_at": 1520246365
     *              }
     *         }
     *     ),
     *     @SWG\Response (
     *         response = 422,
     *         description = "Validation Error"
     *     ),
     *     @SWG\Response (
     *         response = 401,
     *         description = "Invalid credentials or Expired token"
     *     ),
     *     @SWG\Response(
     *         response = 500,
     *         description = "Internal Server Error"
     *     )
     * )
     *
     * @return array
     * 
     * @throws ServerErrorHttpException
     * @throws UnprocessableEntityHttpException
     */
    public function run(): array
    {
        try {
            /** @var WalletEntity $walletModel */
            $walletModel = new $this->modelClass();
            $walletModel = $walletModel->createWallet(\Yii::$app->request->bodyParams);
            return $this->controller->setResponse(
                201,
                'Шаблон кошелька успешно создан.',
                $walletModel->getAttributes(['id', 'name', 'number', 'payment_system', 'created_at'])
            );
        } catch (UnprocessableEntityHttpException $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            throw new ServerErrorHttpException(\Yii::t('app', 'Произошла ошибка при создании шаблона кошелька.'));
        }
    }
}