<?php 

namespace MailingCampaign\Src\Controllers;

use MailingCampaign\Src\Interfaces\ServiceInterface;
use MailingCampaign\Src\Models\CampaignDTO;
use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;
use MailingCampaign\Src\Requests\CreateCampaignRequest;
use MailingCampaign\Src\Requests\IDRequest;
use MailingCampaign\Src\Requests\IndexRequest;
use MailingCampaign\Src\Requests\UpdateCampaignRequest;
use Symfony\Component\HttpFoundation\Response;

final class CampaignController 
{

    public function __construct(
        private ServiceInterface $campaignService
    ) {
    }

    public function index(IndexRequest $request): void {
        $campaigns = $this->campaignService->index(
            offset: $request->offset, 
            limit: $request->limit,
        );
        ResponseMacroServiceProvider::api(
            status: count($campaigns) > 0 ? Response::HTTP_OK : Response::HTTP_NOT_FOUND,
            result: $campaigns,
        );
    }

    public function show(IDRequest $request): void {
        $campaign = $this->campaignService->show(
            id: $request->id
        );
        ResponseMacroServiceProvider::api(
            status: $campaign instanceof CampaignDTO ? Response::HTTP_OK : Response::HTTP_NOT_FOUND, 
            result: $campaign
        );
    }

    public function store(CreateCampaignRequest $request): void {
        $createdCampaign = $this->campaignService->store(
            name: $request->name,
            mailing_list: $request->mailing_list,
        );
        ResponseMacroServiceProvider::api(
            status: $createdCampaign instanceof CampaignDTO ? Response::HTTP_CREATED : Response::HTTP_NOT_FOUND, 
            result: $createdCampaign
        );
    }

    public function update(UpdateCampaignRequest $request): void {
        $updatedCampaign = $this->campaignService->update(
            id: $request->id,
            name: $request->name,
            mailing_list: $request->mailing_list,
        );
        ResponseMacroServiceProvider::api(
            status: $updatedCampaign instanceof CampaignDTO ? Response::HTTP_OK : Response::HTTP_NOT_FOUND, 
            result: $updatedCampaign
        );
    }

    public function delete(IDRequest $request): void {
        $deleted = $this->campaignService->delete(
            id: $request->id
        );
        ResponseMacroServiceProvider::api(
            status: $deleted ? Response::HTTP_OK : Response::HTTP_NOT_FOUND, 
            result: null
        );
    }
}