<?php

namespace MailingCampaign\Src\Services;

use MailingCampaign\Src\Interfaces\AuthInterface;
use MailingCampaign\Src\Interfaces\UserRepositoryInterface;

final class AuthService implements AuthInterface
{
    public function __construct(
        private UserRepositoryInterface $authRepository,
    ) {
    }

    public function auth(string $login, string $password): string 
    {
        if (!$user = $this->authRepository->findWithLogin(login: $login = 'login')) {
            return 'User not found';
        }
        // if password match grant jwt.
        return include 'mock/jwt.php';
    }

    public static function verify(): bool {
        return isset(apache_request_headers()['api-token']);
    }
}