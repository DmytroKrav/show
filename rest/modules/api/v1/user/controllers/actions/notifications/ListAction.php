<?php

namespace rest\modules\api\v1\user\controllers\actions\notifications;

use common\models\userNotifications\UserNotificationsEntity;
use yii\data\ArrayDataProvider;
use yii\rest\Action;

/**
 * Class ListAction
 * @package rest\modules\api\v1\user\controllers\actions\notifications
 */
class ListAction extends Action
{
    /**
     * Returns list of user notifications
     * 
     * @SWG\Get(path="/user/notifications/list",
     *      tags={"User module"},
     *      summary="Get user profile",
     *      description="Get user profile",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *        in = "header",
     *        name = "Authorization",
     *        description = "Authorization: Bearer &lt;token&gt;",
     *        required = true,
     *        type = "string"
     *      ),
     *      @SWG\Parameter(
     *        in = "formData",
     *        name = "per-page",
     *        description = "Amount of posts per page",
     *        required = false,
     *        type = "integer"
     *      ),
     *      @SWG\Parameter(
     *        in = "formData",
     *        name = "page",
     *        description = "next page",
     *        required = false,
     *        type = "integer"
     *      ),
     *      @SWG\Response(
     *         response = 200,
     *         description = "success",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="items", type="object",
     *                   @SWG\Property(property="text", type="string", description="notification description"),
     *                   @SWG\Property(property="created_at", type="integer", description="created at")
     *              ),
     *              @SWG\Property(property="_links", type="object",
     *                  @SWG\Property(property="self", type="object",
     *                      @SWG\Property(property="href", type="string", description="Current link"),
     *                  ),
     *                  @SWG\Property(property="first", type="object",
     *                      @SWG\Property(property="href", type="string", description="First page link"),
     *                  ),
     *                  @SWG\Property(property="prev", type="object",
     *                      @SWG\Property(property="href", type="string", description="Prev page link"),
     *                  ),
     *                  @SWG\Property(property="next", type="object",
     *                      @SWG\Property(property="href", type="string", description="Next page link"),
     *                  ),
     *                  @SWG\Property(property="last", type="object",
     *                      @SWG\Property(property="href", type="string", description="Last page link"),
     *                  ),
     *             ),
     *             @SWG\Property(property="_meta", type="object",
     *                @SWG\Property(property="self", type="object",
     *                    @SWG\Property(property="total-count", type="string", description="Total number of items"),
     *                    @SWG\Property(property="page-count", type="integer", description="Current page"),
     *                    @SWG\Property(property="current-page", type="integer", description="Current page"),
     *                    @SWG\Property(property="per-page", type="integer", description="Number of items per page"),
     *                )
     *             ),
     *         ),
     *         examples = {
     *              "items": {
     *                  {
     *                      "text": "Some text about notification",
     *                      "created_at": "1231232321"
     *                  },
     *                  {
     *                      "text": "Some text about next notification",
     *                      "created_at": "122423214"
     *                  }
     *              },
     *              "_links": {
     *                   "self": {
     *                   "href": "http://work.local/api/v1/user/notifications?per-page=2&page=2&status=unread"
     *                   },
     *                   "first": {
     *                   "href": "http://work.local/api/v1/user/notifications?per-page=2&page&status=unread=1"
     *                   },
     *                   "prev": {
     *                   "href": "http://work.local/api/v1/user/notifications?per-page=2&page&status=unread=1"
     *                   }
     *               },
     *               "_meta": {
     *                   "totalCount": 4,
     *                   "pageCount": 2,
     *                   "currentPage": 2,
     *                   "perPage": 2
     *               }
     *         }
     *
     *     ),
     *     @SWG\Response (
     *         response = 401,
     *         description = "Invalid credentials or Expired token"
     *     ),
     *     @SWG\Response(
     *        response = 500,
     *        description = "Internal Server Error"
     *     )

     * )
     *
     * @return \yii\data\ArrayDataProvider
     */
    public function run(): ArrayDataProvider
    {
        /** @var UserNotificationsEntity $userNotifications */
        $userNotifications = new $this->modelClass;
        return $userNotifications->getUserNotificationsByUser(\Yii::$app->request->get());
    }
}