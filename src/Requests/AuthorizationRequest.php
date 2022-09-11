<?php 

namespace MailingCampaign\Src\Requests;

use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationRequest extends AbstractRequest
{
    public string $login;
    public string $password;

    public function __construct()
    {
        $params = $this->getRawParams();
        foreach ($params as $key => $value) {
            if (property_exists($this, $key) and $value !== null) {
                $this->{$key} = $value;
            }
        }
        if (!isset($this->login) or !isset($this->password)) {
            exit(
                ResponseMacroServiceProvider::api(
                    status: Response::HTTP_UNPROCESSABLE_ENTITY,
                    result: [
                        'error' => 'Wrong credentials.',
                    ]
                )
            );
        }
        // validation for login and password.
    }

    public function validated(): array 
    {
        return [
            'login' => $this->login,
            'password' => $this->password,
        ];
    }

    public function getRawParams(): array
    {
        return [
            'login' => isset($_POST['login']) ? $_POST['login'] : null,
            'password' => isset($_POST['password']) ? $_POST['password'] : null,
        ];
    }
}