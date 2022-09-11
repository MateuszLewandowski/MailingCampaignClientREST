<?php 

namespace MailingCampaign\Src\Models;

use InvalidArgumentException;
use MailingCampaign\Src\Abstracts\DTO;
use Symfony\Component\HttpFoundation\Response;

final class CampaignDTO extends DTO
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $name = null,
        public readonly array $mailing_list,
    ) {
        if (empty($this->mailing_list)) {
            throw new InvalidArgumentException('The mailing list must not be empty.', Response::HTTP_BAD_REQUEST);
        }
        parent::__construct();
    }
}