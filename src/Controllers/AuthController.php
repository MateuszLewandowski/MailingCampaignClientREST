<?php 

namespace MailingCampaign\Src\Controllers;

use MailingCampaign\Src\Interfaces\AuthInterface;
use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;
use MailingCampaign\Src\Requests\AuthorizationRequest;
use Symfony\Component\HttpFoundation\Response;

final class AuthController 
{
    public function __construct(
        private AuthInterface $authService
    ) {
    }

    public function authorize(AuthorizationRequest $request)
    {
        $jwt = $this->authService->auth(
            ...$request->validated()
        );
        ResponseMacroServiceProvider::api(
            status: $jwt ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY,
            result: $jwt,
        );
    }
}