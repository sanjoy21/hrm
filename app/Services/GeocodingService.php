<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeocodingService
{
    protected $apiKey;
    protected $baseUrl = 'https://maps.googleapis.com/maps/api/geocode/json';

    public function __construct()
    {
        $this->apiKey = config('services.google.maps_api_key');
    }

    public function getAddressFromCoordinates($lat, $lng)
    {
        if (!$lat || !$lng) {
            return null;
        }

        $cacheKey = "address_{$lat}_{$lng}";

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($lat, $lng) {
            try {
                $response = Http::get($this->baseUrl, [
                    'latlng' => "{$lat},{$lng}",
                    'key' => $this->apiKey,
                    'language' => 'en'
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    if ($data['status'] === 'OK' && !empty($data['results'])) {
                        // Attempt custom formatting
                        $customFormat = $this->formatBangladeshAddress($data['results'][0]);

                        // FALLBACK: If custom formatting is too simple (e.g., just "Dhaka"),
                        // return Google's standard formatted_address.
                        if (empty($customFormat) || !str_contains($customFormat, ',')) {
                            return $data['results'][0]['formatted_address'];
                        }

                        return $customFormat;
                    }
                }

                Log::warning('Geocoding failed', ['lat' => $lat, 'lng' => $lng, 'response' => $data ?? null]);
                return null;
            } catch (\Exception $e) {
                Log::error('Geocoding exception: ' . $e->getMessage());
                return null;
            }
        });
    }

    private function formatBangladeshAddress($result)
    {
        $addressComponents = $result['address_components'];
        $formatted = [
            'house' => null,
            'road' => null,
            'area' => null,
            'city' => null,
        ];

        foreach ($addressComponents as $component) {
            $types = $component['types'];
            $name = $component['long_name'];

            if (in_array('street_number', $types)) $formatted['house'] = "House#{$name}";
            if (in_array('route', $types)) $formatted['road'] = "Road#{$name}";
            if (in_array('sublocality', $types) || in_array('neighborhood', $types)) $formatted['area'] = $name;
            if (in_array('locality', $types)) $formatted['city'] = $name;
        }

        $addressParts = array_filter([
            $formatted['house'],
            $formatted['road'],
            $formatted['area'],
            $formatted['city'],
        ]);

        return !empty($addressParts) ? implode(', ', $addressParts) : null;
    }
}
