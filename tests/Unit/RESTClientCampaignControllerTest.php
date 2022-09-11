<?php 

namespace MailingCampaign\Tests\Unit;

use MailingCampaign\Client\ClientREST;
use PDOException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

final class RESTClientCampaignControllerTest extends TestCase
{
    public function testGetMailingCampaignsListExpectSuccess() 
    {
        $client = new ClientREST;
        $response = $client->getMailingCampaignsList();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $data = json_decode($response->getContent(true), true);
        $this->assertArrayHasKey('data', $data);
        $this->assertIsArray($data['data']);
        $this->assertArrayHasKey('id', $data['data'][0]);
        $this->assertArrayHasKey('name', $data['data'][0]);
        $this->assertArrayHasKey('mailing_list', $data['data'][0]);
        $this->assertIsArray($data['data'][0]['mailing_list']);

    }

    public function testGetMailingCamapignExpectSuccess() 
    {
        $client = new ClientREST;
        $response = $client->getMailingCampaign(id: 1);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $data = json_decode($response->getContent(true), true);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('id', $data['data']);
        $this->assertArrayHasKey('name', $data['data']);
        $this->assertArrayHasKey('mailing_list', $data['data']);
    }

    public function testGetMailingCamapignExpectFailure() 
    {
        $client = new ClientREST;
        $response = $client->getMailingCampaign(id: 2);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $data = json_decode($response->getContent(true), true);
        $this->assertArrayHasKey('data', $data);
        $this->assertNull($data['data']);
    }

    public function testGetMailingCamapignExpectException() 
    {
        $client = new ClientREST;
        $response = $client->getMailingCampaign(id: 0);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $data = json_decode($response->getContent(true), true);
        $this->assertNull($data['data']);
    }
}