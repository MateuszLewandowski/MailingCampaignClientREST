<?php 

namespace MailingCampaign\Tests\Unit;

use MailingCampaign\Client\ClientREST;
use MailingCampaign\Src\Controllers\AuthController;
use MailingCampaign\Src\Models\CampaignDTO;
use MailingCampaign\Src\Repositories\UserRepository;
use MailingCampaign\Src\Services\AuthService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

final class AuthTest extends TestCase
{
    private function getAuthService() {
        return new AuthService(
            new UserRepository
        );
    }

    public function testAuthorizationExpectSuccess() 
    {
        $authService = $this->getAuthService();
        $jwt = $authService->auth(
            login: 'asdf',
            password: 'asdf'
        );
        $client = new ClientREST;
        $response = $client->getMailingCampaignsList([
            'api-key: Bearer: ' . $jwt
        ]);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}