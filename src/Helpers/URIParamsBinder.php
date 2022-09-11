<?php 

namespace MailingCampaign\Src\Helpers;

abstract class URIParamsBinder 
{
    public static function match(string $route, string $uri): array|bool
    {
        $uri = explode('?', $uri)[0];
        $route_parts = explode('/', $route);
        $uri_parts = explode('/', $uri);
        $route_parts_count = count($route_parts);
        $uri_parts_count = count($uri_parts);
        $params = [];

        if ($route_parts_count !== $uri_parts_count or ($uri_parts_count === 1 and $route_parts[0] !== $uri_parts[0])) {
            return false;
        } else {
            if ($route_parts_count > 1 and $route_parts[0] !== $uri_parts[0]) {
                return false;
            } 
        }
        
        foreach ($route_parts as $i => $route_part) {
            if ($route_part === $uri_parts[$i]) {
                continue;
            }
            if (preg_match("/{/i", $route_part)) {
                $params[substr($route_part, 1, -1)] = $uri_parts[$i];
            }
        }
        $GLOBALS['params'] = $params; 
        return $params;
    }
}