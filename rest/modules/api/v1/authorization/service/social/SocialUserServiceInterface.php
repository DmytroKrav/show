<?php

declare(strict_types=1);

namespace rest\modules\api\v1\authorization\service\social;

use rest\modules\api\v1\authorization\model\social\{
    FbAuthorizationRequestModel, GmailAuthorizationRequestModel, SocialAuthorizationResponseModel
};

interface SocialUserServiceInterface
{
    public function fbAuthorization(FbAuthorizationRequestModel $model): SocialAuthorizationResponseModel;

    public function gmailAuthorization(GmailAuthorizationRequestModel $model): SocialAuthorizationResponseModel;
}
