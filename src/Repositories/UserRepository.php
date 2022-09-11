<?php

namespace MailingCampaign\Src\Repositories;

use MailingCampaign\Src\Interfaces\RepositoryInterface;
use MailingCampaign\Src\Interfaces\UserRepositoryInterface;
use Throwable;

final class UserRepository implements RepositoryInterface, UserRepositoryInterface
{
    public function __construct(
    ) {
        //
    }
  
    public function list(int $offset, int $limit): array {
        $user = include 'mock/user.php';
        return [$user];
    }

    public function find(int $id): array {
        try {
            if ($id === 1) {
                return include 'mock/user.php' ?: [];
            }
            return [];
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function findWithLogin(string $login): array {
        return $this->find(id: 1);
    }

    public function create(array $mailing_list, ?string $name): int {
        return 1;
    }

    public function update(int $id, array $mailing_list, ?string $name): bool {
        return true;
    }

    public function delete(int $id): bool {
        return true;
    }
}