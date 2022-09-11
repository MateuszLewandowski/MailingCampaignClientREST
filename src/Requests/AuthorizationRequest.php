<?php 

namespace MailingCampaign\Src\Requests;

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