<?php 

namespace MailingCampaign\Src\Validators;

use MailingCampaign\Src\Validators\MiddlewareInterface;

abstract class AbstractValidator implements MiddlewareInterface
{
    private $nextMiddleware;

    public function setMiddleware(MiddlewareInterface $middleware): MiddlewareInterface {
        $this->nextMiddleware = $middleware;
        return $middleware;
    }

    public function verify(array $args): ?array {
        return isset($this->nextMiddleware)
            ? $this->nextMiddleware->verify($args)
            : null;
    }
}