<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Illuminate\Support\Facades\Http;
use Modules\Tenant\Services\TenantService;

class HereService
{
    public string $base_url = 'https://router.hereapi.com/v8/routes';

    // https://router.hereapi.com/v8/routes?transportMode=car&origin=52.5308,13.3847&destination=52.5323,13.3789&return=summary

    /**
     * @return array<string, mixed>|null
     */
    public static function getDurationAndLength(float $lat1, float $lon1, float $lat2, float $lon2): ?array
    {
        $api_key = TenantService::config('services.here.api_key');

        $data = [
            'transportMode' => 'car',
            'origin' => $lat1.','.$lon1,
            'destination' => $lat2.','.$lon2,
            'return' => 'summary',
            'apiKey' => $api_key,
        ];

        // dddx(TenantService::config('services.here'));

        $base_url = 'https://router.hereapi.com/v8/routes';
        $response = Http::get($base_url, $data);
        $json = $response->json();
        if (! \is_array($json)) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        if (! isset($json['routes'])) {
            dddx($json);

            return null;
        }

        $routes = $json['routes'];
        if (! \is_array($routes) || ! isset($routes[0]) || ! \is_array($routes[0])) {
            return null;
        }

        $route = $routes[0];
        if (! isset($route['sections']) || ! \is_array($route['sections'])) {
            return null;
        }

        $sections = $route['sections'];
        if (! isset($sections['0']) || ! \is_array($sections['0'])) {
            return null;
        }

        $section = $sections['0'];
        if (! isset($section['summary']) || ! \is_array($section['summary'])) {
            return null;
        }

        $summary = [];
        foreach ($section['summary'] as $key => $value) {
            if (! \is_string($key)) {
                continue;
            }

            $summary[$key] = $value;
        }

        return $summary;
    }
}
