<?php 

namespace MailingCampaign\Tests\Unit;

use MailingCampaign\Src\Models\CampaignDTO;
use PHPUnit\Framework\TestCase;

final class CampaignDtoTest extends TestCase
{
    public function testObjectCompositionExpectSuccess() 
    {
        $this->assertClassHasAttribute('id', CampaignDTO::class);
        $this->assertClassHasAttribute('mailing_list', CampaignDTO::class);
        $this->assertClassHasAttribute('name', CampaignDTO::class);
    }
}