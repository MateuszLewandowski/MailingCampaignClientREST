<?php 

namespace MailingCampaign\Src\Requests;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;

class CreateCampaignRequest extends AbstractRequest
{
    public ?string $name;
    public array $mailing_list;

    public function __construct()
    {
        $params = $this->getRawParams();
        foreach ($params as $key => $value) {
            if (property_exists($this, $key) and $value !== null) {
                $this->{$key} = $value;
            }
        }
        if (empty($this->mailing_list)) {
            exit(
                ResponseMacroServiceProvider::api(
                    status: Response::HTTP_BAD_REQUEST,
                    result: [
                        'error' => 'Mailing list can not be empty.',
                    ]
                )
            );
        }
        foreach ($this->mailing_list as $email) {
            if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)) {
                ResponseMacroServiceProvider::api(
                    status: Response::HTTP_BAD_REQUEST,
                    result: [
                        'error' => 'Mailing list can not be empty.',
                    ]
                    );
            }
        }
    }

    public function validated(): array 
    {
        return [
            'name' => $this->name,
            'mailing_list' => $this->mailing_list,
        ];
    }

    public function getRawParams(): array
    {
        return [
            'name' => isset($_POST['name']) ? $_POST['name'] : null,
            'mailing_list' => isset($_POST['mailing_list']) ? $_POST['mailing_list'] : null,
        ];
    }
}