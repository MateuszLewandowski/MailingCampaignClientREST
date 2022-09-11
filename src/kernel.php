<?php

namespace MailingCampaign\Src;

use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$GLOBALS['method'] = $request->getMethod();
$GLOBALS['request_uri'] = str_replace('/ZadanieRekrutacyjneMerce/', '', $request->getRequestUri());