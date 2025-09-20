<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function timezones(): JsonResponse
    {
        $list = Cache::remember('meta.timezones.v1', 86400, function () {
            $now = new \DateTime('now');
            $zones = \DateTimeZone::listIdentifiers();
            $out = [];
            foreach ($zones as $tz) {
                $tzObj = new \DateTimeZone($tz);
                $offsetSeconds = $tzObj->getOffset($now);
                $hours = floor($offsetSeconds / 3600);
                $minutes = floor(($offsetSeconds % 3600) / 60);
                $sign = $offsetSeconds >= 0 ? '+' : '-';
                $offsetFormatted = sprintf('UTC%s%02d:%02d', $sign, abs($hours), abs($minutes));
                $out[] = [
                    'id' => $tz,
                    'offset' => $offsetFormatted,
                    'raw_offset' => $offsetSeconds,
                    'label' => $offsetFormatted . ' · ' . str_replace('_', ' ', $tz),
                ];
            }
            usort($out, fn($a,$b) => $a['raw_offset'] <=> $b['raw_offset'] ?: strcmp($a['id'],$b['id']));
            return $out;
        });
        Log::info('MetaController@timezones served', ['count' => is_countable($list) ? count($list) : 0]);
        return response()->json($list);
    }

    public function currencies(): JsonResponse
    {
        $list = Cache::remember('meta.currencies.v1', 86400, function () {
            $file = resource_path('data/currencies.json');
            if (!file_exists($file)) {
                return [];
            }
            $data = json_decode(file_get_contents($file), true) ?: [];
            // Normalizar estructura (code, name, symbol, decimals)
            return array_map(function ($row) {
                return [
                    'code' => strtoupper($row['code']),
                    'name' => $row['name'] ?? $row['code'],
                    'symbol' => $row['symbol'] ?? '',
                    'decimals' => $row['decimals'] ?? 2,
                    'label' => ($row['symbol'] ?? '') . ' ' . strtoupper($row['code']) . ' · ' . ($row['name'] ?? '')
                ];
            }, $data);
        });
        Log::info('MetaController@currencies served', ['count' => is_countable($list) ? count($list) : 0]);
        return response()->json($list);
    }
}
