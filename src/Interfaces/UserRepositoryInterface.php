<?php 

namespace MailingCampaign\Src\Interfaces;

interface UserRepositoryInterface 
{
    public function findWithLogin(string $login): array;
}