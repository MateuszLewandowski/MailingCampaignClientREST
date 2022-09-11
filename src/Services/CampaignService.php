<?php

namespace MailingCampaign\Src\Services;

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
        $result = [];
        foreach ($campaigns as $campaign) {
            $result[] = new CampaignDTO(
                id: $campaign['id'],
                name: $campaign['name'],
                mailing_list: $campaign['mailing_list'],
            );
        }
        return $result;
    }

    public function show(int $id): CampaignDTO|null {
        $campaign = $this->campaignRepository->find($id);
        return $campaign
            ? new CampaignDTO(...$campaign)
            : null;
    }

    public function store(?string $name, array $mailing_list): CampaignDTO|false {
        $id = $this->campaignRepository->create(
            name: $name,
            mailing_list: $mailing_list
        );
        return $id > 0
            ? new CampaignDTO(
                id: $id,
                name: $name, 
                mailing_list: $mailing_list
            )
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
            ? new CampaignDTO(
                id: $id,
                name: $name, 
                mailing_list: $mailing_list
            )
            : false;
    }

    public function delete(int $id): bool {
        return $this->campaignRepository->delete($id);
    }
}