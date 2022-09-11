<?php 

namespace MailingCampaign\Src\Requests;

use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;
use MailingCampaign\Src\Validators\Requests\IsNotNull;
use MailingCampaign\Src\Validators\Requests\IsZeroOrGreater;
use Symfony\Component\HttpFoundation\Response;

final class IDRequest extends AbstractRequest
{
    public int $id;

    public function __construct() {
        $this->id = $this->getRawParams()['id'];
        if ($this->id < 1) {
            exit(
                ResponseMacroServiceProvider::api(
                    status: Response::HTTP_BAD_REQUEST,
                    result: [
                        'error' => 'ID must be greater than 0.',
                    ]
                )
            );
        }
        return (new IsNotNull)
            ->setMiddleware(new IsZeroOrGreater)
            ->verify([
                $this->id
            ]) === null;
    }

    public function validated(): array {
        return [
            'id' => $this->id
        ];
    }

    public function getRawParams(): array {
        return [
            'id' => isset($GLOBALS['params']['id']) ? $GLOBALS['params']['id'] : 0,
        ];
    }
}