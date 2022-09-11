<?php 

namespace MailingCampaign\Src\Interfaces;

interface AuthInterface 
{
    public function auth(string $login, string $password): string;
}