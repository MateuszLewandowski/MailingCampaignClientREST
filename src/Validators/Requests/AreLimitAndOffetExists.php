<?php 

namespace MailingCampaign\Src\Validators\Requests;

use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;
use MailingCampaign\Src\Validators\AbstractValidator;
use Symfony\Component\HttpFoundation\Response;

final class AreLimitAndOffetExists extends AbstractValidator
{
    public function verify(array $args): ?array 
    {
        return (isset($args['limit']) and isset($args['offset']))
            ? parent::verify($args)
            : exit(
                ResponseMacroServiceProvider::api(
                    status: Response::HTTP_BAD_REQUEST,
                    result: [
                        'error' => 'Limit and offset are required.',
                    ]
                )
            );
    }
}