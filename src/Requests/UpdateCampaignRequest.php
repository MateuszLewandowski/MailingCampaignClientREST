<?php 

namespace MailingCampaign\Src\Requests;

use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class UpdateCampaignRequest extends CreateCampaignRequest
{
    public int $id;

    public function __construct() 
    {
        $this->id = $this->getRawParams()['id'];
        parent::__construct();
        if ($this->id < 1) {
            exit(
                ResponseMacroServiceProvider::api(
                    status: Response::HTTP_BAD_REQUEST,
                    result: [
                        'error' => 'ID can not be less than 1.',
                    ]
                )
            );
        }
    }

    public function validated(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mailing_list' => $this->mailing_list
        ];
    }

    public function getRawParams(): array
    {
        return [
            'id' => isset($_GET['id']) ? $_GET['id'] : null,
        ];
    }
}