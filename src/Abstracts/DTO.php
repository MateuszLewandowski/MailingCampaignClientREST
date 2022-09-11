<?php 

namespace MailingCampaign\Src\Abstracts;

abstract class DTO
{
    private const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

    public readonly string $created_at;

    protected function __construct(
    ) {
        $this->created_at = date(self::TIMESTAMP_FORMAT);
    }
}