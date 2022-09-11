<?php 

namespace MailingCampaign\Src;

use MailingCampaign\Src\Controllers\ReflectionControllerResolver;
use MailingCampaign\Src\Helpers\DuplicateArgumentsHandler;
use MailingCampaign\Src\Helpers\URIParamsBinder;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Exception;

final class Router 
{
    public static function get(string $route, array $action) 
    {
        $match = URIParamsBinder::match($route, $GLOBALS['request_uri']);
        if ($match === false) {
            return null;
        }
        if ($GLOBALS['method'] === 'GET') 
        {
            return self::runMethod(
                action: $action,
                args: array_merge(
                    $match, $_GET
                ),
            );
        }
    }

    public static function post(string $route, array $action) 
    {
        $match = URIParamsBinder::match($route, $GLOBALS['request_uri']);
        if ($match === false) {
            return null;
        }
        if ($GLOBALS['method'] === 'POST') 
        {
            return self::runMethod(
                action: $action,
                args: $_POST,
            );
        }
        return null;
    }

    public static function put(string $route, array $action) 
    {
        if (!$match = URIParamsBinder::match($route, $GLOBALS['request_uri'])) {
            return null;
        }
        if ($GLOBALS['method'] === 'PUT') 
        {
            return self::runMethod(
                action: $action,
                args: array_merge($match, $_POST),
            );
        }
    }

    public static function patch(string $route, array $action) 
    {
        if (!$match = URIParamsBinder::match($route, $GLOBALS['request_uri'])) {
            return null;
        }
        if ($GLOBALS['method'] === 'PATCH') 
        {
            return self::runMethod(
                action: $action,
                args: array_merge($match, $_POST),
            );
        }
    }

    public static function delete(string $route, array $action) 
    {
        if (!$match = URIParamsBinder::match($route, $GLOBALS['request_uri'])) {
            return null;
        }
        if ($GLOBALS['method'] === 'DELETE') 
        {
            return self::runMethod(
                action: $action,
                args: array_merge($match, $_POST),
            );
        }
    }

    private static function runMethod(array $action, array $args = []) 
    {
        try {
            [$class, $method] = $action; 

            if (!class_exists($class) or !method_exists($class, $method)) {
                throw new Exception('Controller or method does not exists.', Response::HTTP_NOT_IMPLEMENTED);
            }

            $resolver = new ReflectionControllerResolver();
            $controller = $resolver->resolveAutomaticDependencyInjection($class);
            $properties = $resolver->getMethodDependencies($class, $method);
            $args = DuplicateArgumentsHandler::cleanup(array_merge($properties, $args));

            exit(
                $args
                    ? $controller->{$method}(...$args)
                    : $controller->{$method}()
            );
        } catch (Throwable $e) {
            //
        }
    }

    public static function fallback() {
        exit(
            new Response(
                content: 'Endpoint not found.',
                status: Response::HTTP_NOT_FOUND,
                headers: array_merge(
                    ['content-type' => 'application/json'],
                    //
                ),
            )
        );
    }
}