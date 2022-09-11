<?php

namespace MailingCampaign\Src\Services;

use MailingCampaign\Src\Factories\CampaignDTOFactory;
use MailingCampaign\Src\Interfaces\RepositoryInterface;
use MailingCampaign\Src\Interfaces\ServiceInterface;
use MailingCampaign\Src\Models\CampaignDTO;

final class CampaignService implements ServiceInterface
{
    public function __construct(
        private RepositoryInterface $campaignRepository,
    ) {
    }

    /**
     * Cases:
     *
     * HTTP === 200 - Return status and array of campaign dtos.
     * HTTP <> 200 - Return status and error message.
     */
    public function index(int $offset, int $limit): array 
    {
        $campaigns = $this->campaignRepository->list($offset, $limit);
        if (empty($campaigns)) {
            return [];
        }
        return CampaignDTOFactory::createCollection(
            args: $campaigns
        );
    }

    public function show(int $id): CampaignDTO|null {
        $campaign = $this->campaignRepository->find($id);
        return $campaign
            ? CampaignDTOFactory::create($campaign)
            : null;
    }

    public function store(?string $name, array $mailing_list): CampaignDTO|false {
        $id = $this->campaignRepository->create(
            name: $name,
            mailing_list: $mailing_list
        );
        return $id > 0
            ? CampaignDTOFactory::create([
                $id, $name, $mailing_list
            ])
            : false;
    }

    /**
     * The mailing list should be implemented as a 1:n relationship in transaction.
     */
    public function update(int $id, ?string $name, array $mailing_list): CampaignDTO|false {
        $updated = $this->campaignRepository->update(
            id: $id,
            name: $name,
            mailing_list: $mailing_list
        );
        return $updated
            ? CampaignDTOFactory::create([
                $id, $name, $mailing_list
            ])
            : false;
    }

    public function delete(int $id): bool {
        return $this->campaignRepository->delete($id);
    }
}