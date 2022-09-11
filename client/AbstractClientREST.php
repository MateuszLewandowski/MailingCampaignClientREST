<?php 

namespace MailingCampaign\Client;

use CurlHandle;
use MailingCampaign\Src\Providers\ResponseMacroServiceProvider;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractClientREST
{
    private CurlHandle $curl;

    private const POST_METHODS = [
        'POST', 'PUT', 'PATCH'
    ];

    protected function __construct(
        protected readonly string $api,
    ) {
        $this->curl = curl_init();
    }

    abstract public function sendRequest(string $method, string $uri = '/', array $args = [], array $post = [], array $headers = []): Response;

    protected function request(string $method, string $uri, array $args = [], array $post = [], array $headers = []): Response
    {
        $request_headers = [
            'api-token: ' . include 'mock/jwt.php',
            'Accept: */*',
            ...$headers
        ];
        curl_setopt($this->curl, CURLOPT_URL, $this->buildURL($uri, $args + $post));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 0); 
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 200);
        if (in_array($method, self::POST_METHODS)) {
            curl_setopt($this->curl, CURLOPT_POSTREDIR, 3);
            curl_setopt($this->curl, CURLOPT_POST, true);
            $encoded = json_encode($post);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $encoded);
            $request_headers[] = 'Content-Type: application/json; charset=UTF-8';
            $request_headers[] = 'Content-Length: ' . strlen($encoded);
        } else {
            $request_headers[] = 'Content-type: application/json; charset=UTF-8';
        }
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $request_headers);
        $response = curl_exec($this->curl);
        $status = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        if ($response === false) {
            exit(
                ResponseMacroServiceProvider::api(
                    status: $status,
                    result: curl_error($this->curl)
                )
            );
        }
        curl_close($this->curl);
        $response = json_decode($response, true);
        return ResponseMacroServiceProvider::api(
            status: $status, 
            result: is_null($response) ? null : $response['data']
        );
    }

    protected function buildURL(string $uri, array $args) 
    {
        return $this->api . $uri . http_build_query($args);
    }
}