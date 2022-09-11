<?php

namespace MailingCampaign\Src\Services;

use MailingCampaign\Src\Interfaces\AuthInterface;
use MailingCampaign\Src\Interfaces\UserRepositoryInterface;
use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
        try {
            return isset(apache_request_headers()['api-token']);
        } catch (Throwable $e) {
            exit(
                ResponseMacroServiceProvider::api(
                    status: Response::HTTP_INTERNAL_SERVER_ERROR,
                    result: [
                        'error' => 'Missing apache request header function: ' . $e->getMessage(),
                    ]
                )
            );
        }
    }
}