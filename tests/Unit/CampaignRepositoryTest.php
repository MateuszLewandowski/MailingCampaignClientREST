<?php 

namespace MailingCampaign\Tests\Unit;

use MailingCampaign\Src\Repositories\CampaignRepository;
use PDOException;
use PHPUnit\Framework\TestCase;

final class CampaignRepositoryTest extends TestCase
{
    public function testListCampaignsExpectSuccess(): void
    {
        $campaignRepository = new CampaignRepository;
        $result = $campaignRepository->list(offset: 0, limit: 10);
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function testFindCampaignExpectSuccess(): void
    {
        $campaignRepository = new CampaignRepository;
        $result = $campaignRepository->find(id: 1);
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('mailing_list', $result);
        $this->assertCount(2, $result['mailing_list']);
    }

    public function testFindCampaignExpectFailure(): void
    {
        $campaignRepository = new CampaignRepository;
        $result = $campaignRepository->find(id: 0);
        $this->assertIsArray($result);
        $this->assertEmpty($result);
        $this->assertArrayNotHasKey('id', $result);
        $this->assertArrayNotHasKey('mailing_list', $result);
    }

    public function testCreateCampaignExpectSuccess(): void
    {
        $campaignRepository = new CampaignRepository;
        $result = $campaignRepository->create(
            mailing_list: [
                'test1@test.pl'
            ],
            name: 'Campaing 7',
        );
        $this->assertEquals(
            expected: 1,
            actual: $result
        );
    }

    public function testUpdateCampaignExpectSuccess(): void
    {
        $campaignRepository = new CampaignRepository;
        $result = $campaignRepository->update(
            id: 1,
            mailing_list: [
                'test1@test.pl'
            ],
            name: 'Campaing 7',
        );
        $this->assertTrue($result);
    }

    public function testUpdateCampaignExpectFailure(): void
    {
        $campaignRepository = new CampaignRepository;
        $result = $campaignRepository->update(
            id: 0,
            mailing_list: [
                'test1@test.pl'
            ],
            name: 'Campaing 7',
        );
        $this->assertFalse($result);
    }

    public function testUpdateCampaignExpectException(): void
    {
        $this->expectException(PDOException::class);
        $campaignRepository = new CampaignRepository;
        $campaignRepository->update(
            id: 2,
            mailing_list: [
                'test1@test.pl'
            ],
            name: 'Campaing 7',
        );
    }
}