<?php 

namespace MailingCampaign\Src\Factories;

use MailingCampaign\Src\Abstracts\DTO;
use MailingCampaign\Src\Interfaces\FactoryInterface;
use MailingCampaign\Src\Models\CampaignDTO;

final class CampaignDTOFactory implements FactoryInterface
{
    public static function create(array $args = []): DTO 
    {
        return new CampaignDTO(...$args);
    }

    public static function createCollection(array $args = []): array 
    {
        $dtos = [];
        foreach($args as $arg) {
            $dtos[] = new CampaignDTO(...$arg);
        }
        return $dtos;
    }
}