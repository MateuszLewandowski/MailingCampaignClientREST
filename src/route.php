<?php

namespace MailingCampaign\Src;

use MailingCampaign\Src\Controllers\CampaignController;
use MailingCampaign\Src\Router;
use Symfony\Component\HttpFoundation\Response;

Router::get('campaigns', [CampaignController::class, 'index']);
Router::get('campaigns/{id}', [CampaignController::class, 'show']);
Router::post('campaigns', [CampaignController::class, 'store']);
Router::put('campaigns/{id}', [CampaignController::class, 'update']);
Router::patch('campaigns/{id}', [CampaignController::class, 'update']);
Router::delete('campaigns', [CampaignController::class, 'delete']);
Router::fallback();
