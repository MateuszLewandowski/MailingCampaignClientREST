<?php 

namespace MailingCampaign\Src\Providers;

use Symfony\Component\HttpFoundation\Response;

final class ResponseMacroServiceProvider
{
    private const CONTENT_TYPE = ['content-type' => 'application/json'];

    public static function api(string $status = Response::HTTP_INTERNAL_SERVER_ERROR, mixed $result = null, array $headers = []): Response {
        $response = new Response(
            content: json_encode([
                'data' => $result,
                'timestamp' => date('Y-m-d H:i:s'),
                //
            ]),
            status: $status,
            headers: array_merge(
                self::CONTENT_TYPE,
                $headers,
                //
            ),
        );
        $response->send();

        return $response;
    }
}