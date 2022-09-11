<?php 

namespace MailingCampaign\Src\Requests;

abstract class AbstractRequest
{
    public abstract function validated(): array;
    public abstract function getRawParams(): array;

}