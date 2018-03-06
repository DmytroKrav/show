<?php

namespace rest\modules\api\v1\user\controllers\actions\profile;

use common\models\userProfile\UserProfileEntity;
use yii\rest\Action;

/**
 * Class GetProfileAction
 * @package rest\modules\api\v1\user\controllers\actions\profile
 */
class GetProfileAction extends Action
{
    /**
     * Returns a user profile
     * 
     * @SWG\Get(path="/user/user-profile",
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
     *      @SWG\Response(
     *         response = 200,
     *         description = "success",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="status", type="integer", description="Status code"),
     *              @SWG\Property(property="message", type="string", description="Status message"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="id", type="integer", description="User Profile id"),
     *                  @SWG\Property(property="name", type="string", description="User name"),
     *                  @SWG\Property(property="last_name", type="string", description="User last name"),
     *                  @SWG\Property(property="avatar", type="string", description="User avatar"),
     *                  @SWG\Property(property="email", type="string", description="User email"),
     *                  @SWG\Property(property="phone_number", type="string", description="User phone number")
     *              ),
     *         ),
     *         examples = {
     *              "status": 200,
     *              "message": "",
     *              "data": {
     *                  "id": 6,
     *                  "name": "John",
     *                  "last_name": "Smith",
     *                  "avatar": null,
     *                  "email": "smith@gmail.com",
     *                  "phone_number": null
     *              }
     *         }
     *     ),
     *     @SWG\Response (
     *         response = 401,
     *         description = "Invalid credentials or Expired token"
     *     )
     * )
     *
     * @return array
     */
    public function run(): array
    {
        /** @var UserProfileEntity $model */
        $model = new $this->modelClass;
        return $model->getProfile();
    }
}