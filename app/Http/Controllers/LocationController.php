<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    public function getCountries()
    {
        // Cache the countries list for 24 hours
        return Cache::remember('countries', 86400, function () {
            $response = Http::get('https://restcountries.com/v3.1/all');
            if ($response->successful()) {
                $countries = collect($response->json())->map(function ($country) {
                    return [
                        'name' => $country['name']['common'],
                        'code' => $country['cca2']
                    ];
                })->sortBy('name')->values();
                return response()->json($countries);
            }
            return response()->json(['error' => 'Failed to fetch countries'], 500);
        });
    }

    public function getProvinces()
    {
        // Cache the provinces list for 24 hours
        return Cache::remember('provinces', 86400, function () {
            $response = Http::get('https://apis.datos.gob.ar/georef/api/provincias', [
                'campos' => 'id,nombre'
            ]);
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['provincias'])) {
                    $provinces = collect($data['provincias'])->map(function ($prov) {
                        return [
                            'id' => $prov['id'],
                            'name' => $prov['nombre']
                        ];
                    })->sortBy('name')->values();
                    return response()->json($provinces);
                }
            }
            return response()->json([], 500);
        });
    }

    public function getCities(Request $request)
    {
        $province = $request->input('province');
        if (!$province) {
            return response()->json(['error' => 'Province is required'], 400);
        }

        // Cache the cities list for 24 hours
        return Cache::remember("cities_{$province}", 86400, function () use ($province) {
            $response = Http::get('https://apis.datos.gob.ar/georef/api/municipios', [
                'provincia' => $province,
                'campos' => 'id,nombre',
                'max' => 1000
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['municipios'])) {
                    $municipios = collect($data['municipios'])->map(function($m) {
                        return ['name' => $m['nombre'], 'id' => $m['id']];
                    })->values();
                    return response()->json($municipios);
                }
            }
            
            return response()->json(['error' => 'Failed to fetch cities'], 500);
        });
    }
} 