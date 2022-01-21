<?php


namespace App\Helpers;


class UrlHelper
{
    public static function constructRestaurantUrl($subdomain, $path = '')
    {
        $protocol = 'http://';
        if (config('app.env') === 'production') {
            $protocol = 'https://';
        }
        return $protocol . $subdomain . '.' . config('app.host') . $path;
    }

    public static function getQueryParamsFromUrlString($urlString)
    {
        $parsedUrl = parse_url($urlString);
        if (!$parsedUrl) {
            return [];
        }
        $params = [];
        if (!isset($parsedUrl['query'])) {
            return [];
        }
        $query = explode('&', $parsedUrl['query']);
        foreach ($query as $queryParam) {
            $keyValue = explode('=', $queryParam);
            if (count($keyValue) === 2) {
                $params[$keyValue[0]] = $keyValue[1];
            }
        }
        return $params;
    }
}
