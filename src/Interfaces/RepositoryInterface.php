<?php 

namespace MailingCampaign\Src\Interfaces;

interface RepositoryInterface 
{
    public function list(int $offset, int $limit): array;
    public function find(int $id): array;
    public function create(array $mailing_list, ?string $name): int;
    public function update(int $id, array $mailing_list, ?string $name): bool;
    public function delete(int $id): bool;
}