<?php 

namespace MailingCampaign\Src\Validators;

interface MiddlewareInterface
{
    public function setMiddleware(MiddlewareInterface $middleware): MiddlewareInterface;
    public function verify(array $args): ?array;
}