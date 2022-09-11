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
            api: 'http://localhost/ZadanieRekrutacyjneMerce/'
            // api: 'https://merce-task.herokuapp.com/'
        );
    }

    public function getMailingCampaignsList(array $headers = []): Response
    {
        return $this->sendRequest('GET', 'campaigns', [], [], $headers);
    }

    public function getMailingCampaign(int $id, array $headers = []): Response
    {
        return $this->sendRequest('GET', "campaigns/{$id}", [], [], $headers);
    }

    public function createMailingCampaign(array $post, array $headers = []): Response
    {
        return $this->sendRequest('POST', "campaigns", [], $post, $headers);
    }
    
    public function sendRequest(string $method = "GET", string $uri = '/', array $args = [], array $post = [], array $headers = []): Response
    {
        try {
            return parent::request($method, $uri, $args, $post, $headers);
        } catch (Throwable $e) {
            echo $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine(); die;
        }
    }
}