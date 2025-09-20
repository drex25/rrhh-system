<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    // GET /api/countries
    public function countries(): JsonResponse
    {
        $countries = Cache::remember('countries_all_es_api', 86400, function () {
            $list = $this->fetchRestCountriesV3();
            return collect($list)
                ->filter(fn($c) => isset($c['name']) && $c['name'])
                ->map(fn($c) => ['name' => (string) $c['name'], 'code' => $c['code'] ?? null])
                ->unique('name')
                ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
                ->values()
                ->all();
        });

        return response()->json($countries);
    }

    /**
     * Fetch countries from RestCountries v3.1 with Spanish translation when available
     * @return array<int, array{name:string, code:?string}>
     */
    protected function fetchRestCountriesV3(): array
    {
        try {
            $response = Http::timeout(6)->retry(2, 200)->get('https://restcountries.com/v3.1/all', [
                'fields' => 'name,cca2,translations'
            ]);
            if (!$response->successful()) {
                return [];
            }
            $data = $response->json();
            if (!is_array($data)) return [];
            return collect($data)
                ->map(function ($c) {
                    $name = $c['translations']['spa']['common']
                        ?? $c['translations']['es']['common']
                        ?? ($c['name']['common'] ?? null);
                    $code = $c['cca2'] ?? null;
                    return $name ? ['name' => $name, 'code' => $code] : null;
                })
                ->filter()
                ->values()
                ->all();
        } catch (\Throwable $e) {
            return [];
        }
    }


    // GET /api/provinces (Argentina)
    public function provinces(): JsonResponse
    {
        $provinces = Cache::remember('ar_provinces', 86400, function () {
            $response = Http::timeout(6)->retry(2, 200)->get('https://apis.datos.gob.ar/georef/api/provincias', [
                'campos' => 'id,nombre',
                'max' => 100
            ]);
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['provincias'])) {
                    return collect($data['provincias'])
                    ->map(fn($p) => ['id' => $p['id'], 'name' => $p['nombre']])
                    ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
                    ->values()
                    ->all();
                }
            }
            // Sin fallback: solo API. Si falla, lista vacía.
            return [];
        });

        return response()->json($provinces);
    }

    // GET /api/cities?province={id}
    public function cities(Request $request): JsonResponse
    {
        $province = $request->query('province');
        if (!$province) {
            return response()->json(['error' => 'province param required'], 400);
        }

        $cities = Cache::remember("ar_cities_{$province}", 86400, function () use ($province) {
            $response = Http::get('https://apis.datos.gob.ar/georef/api/municipios', [
                'provincia' => $province,
                'campos' => 'id,nombre',
                'max' => 1000,
            ]);
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['municipios'])) {
                    return collect($data['municipios'])
                    ->map(fn($m) => ['id' => $m['id'], 'name' => $m['nombre']])
                    ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
                    ->values()
                    ->all();
                }
            }
            // Sin fallback: solo API. Si falla, lista vacía.
            return [];
        });

        return response()->json($cities);
    }
}
