<?php

namespace MailingCampaign\Src\Repositories;

use Apix\Log\Logger\File as FileLogger;
use MailingCampaign\Src\Interfaces\RepositoryInterface;
use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;
use PDOException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CampaignRepository implements RepositoryInterface
{
    private FileLogger $fileLogger; 

    public function __construct(
    ) {
        $file = __DIR__ . '/../../logs/logs.log';
        if (!file_exists($file)) {
            throw new RuntimeException('Log file does not exists!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if (!is_writable($file)) {
            if (shell_exec('chmod 0777') === null) {
                throw new RuntimeException('Log file can not be writable.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        $this->fileLogger = new FileLogger($file);
    }
    /**
     * Query and cache results.
     */
    public function list(int $offset, int $limit): array {
        try {
            return include 'mock/campaigns.php' ?: [];
        } catch (Throwable $e) {
            // Various exceptions can be handled in a multiple ways, eg. Logs, return message/value not an exception, etc.
            $this->fileLogger->error($e);

            return match (true) {
                //
                $e instanceof PDOException => exit(
                    ResponseMacroServiceProvider::api(
                        status: Response::HTTP_INTERNAL_SERVER_ERROR,
                        result: [
                            'error' => $e->getMessage(),
                        ]
                    )
                ),
                default => [],
            };
        }
    }

    /**
     * Query and cache result with cache id tag (prefix).
     */
    public function find(int $id): array {
        try {
            if ($id === 1) {
                $campaigns = include 'mock/campaigns.php' ?: [];
                return end($campaigns); // for example purposes.
            }
            return [];
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Query and: 
     * 1. Cache single record for find method purposes.
     * 2. Rebuild cache list.
     */
    public function create(array $mailing_list, ?string $name): int {
        try {
            $id = 1; // Create query and return the new id.
            return $id;
        } catch (Throwable $e) {
            throw $e;
        }
    }

     /**
     * Query and: 
     * 1. Update single record cache for find method purposes.
     * 2. Rebuild cache list.
     */
    public function update(int $id, array $mailing_list, ?string $name): bool {
        try {
            /**
             * Find by id, update if exists, return bool flag.
             */
            if ($id === 2) throw new PDOException('err', 500);
            return $id === 1;
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Query and: 
     * 1. Find if single record is cached - delete
     * 2. Find if record exists in list cache - delete or rebuild.
     */
    public function delete(int $id): bool {
        try {
            return $id === 1;
        } catch (Throwable $e) {
            //
        }
    }
}