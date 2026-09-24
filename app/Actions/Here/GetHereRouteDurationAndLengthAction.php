<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Here;

use Illuminate\Support\Facades\Http;
use Spatie\QueueableAction\QueueableAction;

class GetHereRouteDurationAndLengthAction
{
    use QueueableAction;

    private const BASE_URL = 'https://router.hereapi.com/v8/routes';

    /**
     * @return array<string, mixed>|null
     */
    public function execute(float $lat1, float $lon1, float $lat2, float $lon2): ?array
    {
        $apiKey = app(\Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction::class)->execute('services.here.api_key');

        $response = Http::get(self::BASE_URL, [
            'transportMode' => 'car',
            'origin' => $lat1.','.$lon1,
            'destination' => $lat2.','.$lon2,
            'return' => 'summary',
            'apiKey' => $apiKey,
        ]);

        if (! method_exists($response, 'json')) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        $json = $response->json();
        if (! \is_array($json)) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        if (! isset($json['routes'])) {
            dddx($json);

            return null;
        }
        if (! is_array($json['routes'])) {
            return null;
        }
        if (! isset($json['routes'][0]) || ! is_array($json['routes'][0])) {
            return null;
        }

        $sections = $json['routes'][0]['sections'] ?? null;
        if (! is_array($sections) || ! isset($sections[0]) || ! is_array($sections[0])) {
            return null;
        }

        $summary = $sections[0]['summary'] ?? null;
        if (! is_array($summary)) {
            return null;
        }

        $res = [];
        foreach ($summary as $key => $value) {
            if (\is_string($key)) {
                $res[$key] = $value;
            }
        }

        return $res;
    }
}
