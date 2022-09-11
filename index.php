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
} catch (Throwable $e) {
    exit(
        $e->getCode() . ': ' . $e->getMessage()
    );
}


