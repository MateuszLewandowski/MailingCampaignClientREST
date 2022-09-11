<?php

use Symfony\Component\HttpFoundation\Response;

/**
 * @see Disclaimer
 * 
 * For internal operations, the object id is used.
 * DTO objects returned from the API should contain, instead of IDs, UUIDs.
 */

try {
    require_once './vendor/autoload.php';
    require_once './src/kernel.php';
    require_once './src/route.php';

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

} catch (Throwable $e) {
    exit(
        new Response(
            content: $e->getMessage(),
            status: $e->getCode(),
            headers: array_merge(
                ['content-type' => 'application/json'],
                //
            ),
        )
    );
}


