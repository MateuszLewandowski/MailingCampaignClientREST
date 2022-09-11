<?php 

namespace MailingCampaign\Tests\Unit;

use MailingCampaign\Src\Models\CampaignDTO;
use MailingCampaign\Src\Repositories\CampaignRepository;
use MailingCampaign\Src\Services\CampaignService;
use PDOException;
use PHPUnit\Framework\TestCase;

final class CampaignServiceTest extends TestCase
{
    private function getCampaignService(): CampaignService {
        return new CampaignService(
            new CampaignRepository
        );
    }

    public function testListMethodExpectSuccess()
    {
        $campaignService = $this->getCampaignService();
        $result = $campaignService->index(offset: 0, limit: 10);
        $this->assertIsArray($result);
        $this->assertContainsOnlyInstancesOf(CampaignDTO::class, $result);
    }

    public function testShowMethodExpectSuccess()
    {
        $campaignService = $this->getCampaignService();
        $result = $campaignService->show(id: 1);
        $this->assertInstanceOf(CampaignDTO::class, $result);
        $this->assertObjectHasAttribute('id', $result);
        $this->assertObjectHasAttribute('name', $result);
        $this->assertObjectHasAttribute('mailing_list', $result);
        $this->assertIsArray($result->mailing_list);
        $this->assertNotEmpty($result->mailing_list);
    }

    public function testShowMethodExpectFailure()
    {
        $campaignService = $this->getCampaignService();
        $result = $campaignService->show(id: 0);
        $this->assertIsNotObject($result);
        $this->assertNull($result);
    }

    public function testCreateMethodExpectSuccess()
    {
        $campaignService = $this->getCampaignService();
        $result = $campaignService->store(
            name: 'campaign 7',
            mailing_list: [
                'test@test.pl'
            ]
        );
        $this->assertInstanceOf(CampaignDTO::class, $result);
        $this->assertObjectHasAttribute('id', $result);
        $this->assertObjectHasAttribute('name', $result);
        $this->assertObjectHasAttribute('mailing_list', $result);
        $this->assertIsArray($result->mailing_list);
        $this->assertNotEmpty($result->mailing_list);
    }

    public function testUpdateMethodExpectSuccess()
    {
        $campaignService = $this->getCampaignService();
        $result = $campaignService->update(
            id: 1,
            name: "Campaign 7",
            mailing_list: [
                'test@test.pl'
            ]
        );
        $this->assertInstanceOf(CampaignDTO::class, $result);
        $this->assertObjectHasAttribute('id', $result);
        $this->assertObjectHasAttribute('name', $result);
        $this->assertObjectHasAttribute('mailing_list', $result);
        $this->assertIsArray($result->mailing_list);
        $this->assertNotEmpty($result->mailing_list);
    }

    public function testUpdateMethodExpectFailure()
    {
        $campaignService = $this->getCampaignService();
        $result = $campaignService->update(
            id: 0,
            name: "Campaign 7",
            mailing_list: [
                'test@test.pl'
            ]
        );
        $this->assertFalse($result);
    }

    public function testUpdateMethodExpectPdoException()
    {
        $this->expectException(PDOException::class);
        $campaignService = $this->getCampaignService();
        $campaignService->update(
            id: 2,
            name: "Campaign 7",
            mailing_list: [
                'test@test.pl'
            ]
        );
    }
}