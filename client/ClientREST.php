<?php 

namespace MailingCampaign\Client;

use MailingCampaign\Client\AbstractClientREST;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ClientREST extends AbstractClientREST
{
    public function __construct(
    ) {
        parent::__construct(
            api: 'https://merce-task.herokuapp.com/'
        );
    }

    public function getMailingCampaignsList(): Response
    {
        return $this->sendRequest('GET', 'campaigns');
    }

    public function getMailingCampaign(int $id): Response
    {
        return $this->sendRequest('GET', "campaigns/{$id}");
    }

    public function createMailingCampaign(array $post): Response
    {
        return $this->sendRequest('POST', "campaigns", [], $post);
    }
    
    public function sendRequest(string $method = "GET", string $uri = '/', array $args = [], array $post = []): Response
    {
        try {
            return parent::request($method, $uri, $args, $post);
        } catch (Throwable $e) {
            echo $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine(); die;
        }
    }
}