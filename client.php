<?php 

require_once './vendor/autoload.php';

use MailingCampaign\Client\ClientREST;

try {
    $client = new ClientREST;

    /**
     * Return campaings list 
     * Expect HTTP/1.0 200 OK
     */

    // $client->getMailingCampaignsList();

    /**
     * Return campaings by ID
     * Expect HTTP/1.0 200 OK
     * 
     * @see If id === 1     HTTP/1.0 200 OK
     *      If id === 0     HTTP/1.0 404 Bad Request
     *      If id === 2     HTTP/1.0 404 Not Found
     */

    // $client->getMailingCampaign(id: 1);

    /**
     * Return campaings by ID
     * Expect HTTP/1.0 200 OK
     * 
     * @see If id === 1     HTTP/1.0 200 OK
     *      If id === 0     HTTP/1.0 404 Bad Request
     *      If id === 2     HTTP/1.0 404 Not Found
     */

    $client->createMailingCampaign([
        'name' => 'Campaign 9',
        'mailing_list' => [
            'test@test.pl',
        ]
    ]);

} catch (Throwable $e) {
    //
}
