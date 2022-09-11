<?php 

namespace MailingCampaign\Src\Validators\Requests;

use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;
use MailingCampaign\Src\Validators\AbstractValidator;
use Symfony\Component\HttpFoundation\Response;

final class IsZeroOrGreater extends AbstractValidator
{
    public function verify(array $args): ?array 
    {
        foreach ($args as $arg) {
            if (is_integer($arg) and $arg < 0) {
                exit(
                    ResponseMacroServiceProvider::api(
                        status: Response::HTTP_BAD_REQUEST,
                        result: [
                            'error' => 'The given numbers must be greater than or equal to zero.',
                        ]
                    )
                );
            }
        }
        return parent::verify($args);
    }
}