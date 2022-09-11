<?php 

namespace MailingCampaign\Src\Requests;

use MailingCampaign\Src\Validators\Requests\AreLimitAndOffetExists;
use MailingCampaign\Src\Validators\Requests\IsLimitGreaterThanOffset;
use MailingCampaign\Src\Validators\Requests\IsNotNull;
use MailingCampaign\Src\Validators\Requests\IsZeroOrGreater;

final class IndexRequest extends AbstractRequest
{
    private const DEFUALT_OFFSET = 0;
    private const DEFAULT_LIMIT = 10;

    public int $offset;
    public int $limit;

    public function __construct() {
        $params = $this->getRawParams();
        foreach ($params as $key => $value) {
            if (property_exists($this, $key) and $value !== null) {
                $this->{$key} = $value;
            }
        }
        if (!isset($this->offset) or $this->offset === 0) {
            $this->offset = self::DEFUALT_OFFSET;
        }
        if (!isset($this->limit) or $this->limit === 0) {
            $this->limit = $this->offset + self::DEFAULT_LIMIT;
        }
        return (new AreLimitAndOffetExists)
            ->setMiddleware(new IsNotNull)
            ->setMiddleware(new IsZeroOrGreater)
            ->setMiddleware(new IsLimitGreaterThanOffset)
            ->verify($this->validated()) === null;
    }

    public function validated(): array {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    public function getRawParams(): array {
        return [
            'offset' => isset($_GET['offset']) ? $_GET['offset'] : null,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : null,
        ];
    }
}