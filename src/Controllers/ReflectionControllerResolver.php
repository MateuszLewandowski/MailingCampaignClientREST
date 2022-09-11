<?php 

namespace MailingCampaign\Src\Controllers;

use MailingCampaign\Src\Repositories\CampaignRepository;
use MailingCampaign\Src\Repositories\UserRepository;
use MailingCampaign\Src\Services\AuthService;
use MailingCampaign\Src\Services\CampaignService;
use Throwable;

final class ReflectionControllerResolver
{
    public function resolveAutomaticDependencyInjection(string $class): object|null
    {
        try {
            $reflectionClass = new \ReflectionClass($class);
            if (($constructor = $reflectionClass->getConstructor()) === null) {
                return $reflectionClass->newInstance();
            }
            if (($params = $constructor->getParameters()) === []) {
                return $reflectionClass->newInstance();
            }
            $newInstanceParams = [];
            foreach ($params as $param) {
                $newInstanceParams[] = $param->getClass() === null ? $param->getDefaultValue() : $this->resolveAutomaticDependencyInjection(
                    $this->interfacesSwapStrategy(
                        $param->getClass()->getName()
                    )
                );
            }
            return $reflectionClass->newInstanceArgs(
                $newInstanceParams
            );
        } catch (Throwable $e) {
            echo $e->getMessage(); die;
        }
        
    }

    public function getMethodDependencies(string $class, string $method) {
        $reflectionClass = new \ReflectionClass($class);
        $reflectionMethod = $reflectionClass->getMethod($method);
        $params = $reflectionMethod->getParameters();
        
        $newInstanceParams = [];
        foreach ($params as $param) {
            $class = $param->getClass()->getName();
            $newInstanceParams[] = new $class;
        }
        return $newInstanceParams;
    }

    public function interfacesSwapStrategy(string $class) {
        if (!str_contains($class, 'Interface')) {
            return $class;
        }
        switch ($class = str_replace('MailingCampaign\\Src\\Interfaces\\', '', $class)) 
        {
            case 'ServiceInterface':
                return CampaignService::class;
            case 'RepositoryInterface':
                return CampaignRepository::class;
            case 'AuthInterface':
                return AuthService::class;
            case 'UserRepositoryInterface':
                return UserRepository::class;
        }
    }
}