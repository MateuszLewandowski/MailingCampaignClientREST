<?php 

namespace MailingCampaign\Src\Validators\Requests;

use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;
use MailingCampaign\Src\Validators\AbstractValidator;
use Symfony\Component\HttpFoundation\Response;

final class IsNotNull extends AbstractValidator
{
    public function verify(array $args): ?array 
    {
        foreach ($args as $arg) {
            if ($arg === null or $arg === '' or empty($arg)) {
                exit(
                    ResponseMacroServiceProvider::api(
                        status: Response::HTTP_BAD_REQUEST,
                        result: [
                            'error' => 'Data must not be null nor empty.',
                        ]
                    )
                );
            }
        }
        return parent::verify($args);
    }
}