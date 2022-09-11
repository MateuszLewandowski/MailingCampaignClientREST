<?php 

namespace MailingCampaign\Src\Interfaces;

use MailingCampaign\Src\Abstracts\DTO;

interface FactoryInterface 
{
    public static function create(array $args = []): DTO;
    public static function createCollection(array $args = []): array;
}