<?php 

namespace MailingCampaign\Src\Interfaces;

use MailingCampaign\Src\Abstracts\DTO;

interface ServiceInterface 
{
    public function index(int $offset, int $limit): array;
    public function show(int $id): DTO|null;
    public function store(?string $name, array $mailing_list): DTO|false;
    public function update(int $id, ?string $name, array $mailing_list): DTO|false;
    public function delete(int $id): bool; 
}