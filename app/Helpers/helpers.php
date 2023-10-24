<?php

use App\Repositories\Contracts\FileContract;
use Illuminate\Support\Arr;

if (!function_exists('__json')) {
    /**
     * Get the translation for a given key from json files.
     *
     * @param string|null $key
     * @param array $replace
     * @param string|null $locale
     * @return string|array|null
     */
    function __json(string $key = null, array $replace = [], string $locale = null): array|string|null
    {
        // Default behavior
        if (is_null($key)) return $key;
        if (trans()->has($key)) return trans($key, $replace, $locale);
        // Search in .json file
        $search = Arr::get(trans('*'), $key);
        if ($search !== null) return $search;
        // Return .json fallback
        $fallback = Arr::get(trans('*', [], config('app.fallback_locale')), $key);
        if ($fallback !== null) return $fallback;
        // Return key name if not found
        else return $key;
    }
}

/**
 * default static url for file not exists (specific for frontend)
 *
 */
if (!function_exists('static_url')) {
    function static_url($url): array
    {
        return ['url' => asset("UI/assets/$url")];
    }
}

if (!function_exists('saveFileByRelation')) {
    function saveFileByRelation($model, $fileId, $relationName = 'files'): void
    {
        $fileModel = resolve(FileContract::class)->find($fileId);
        $relation = $model->{$relationName}();
        $relation?->save($fileModel);
    }
}

if (!function_exists('convert_number_to_time')) {
    function convert_number_to_time($number): string
    {
        $number = explode('.', $number);
        $hours = isset($number[0]) ? (int)$number[0] : 0;
        $wrongMinutes = isset($number[1]) ? (int)$number[1] : 0;
        $minutes = (int)substr(ceil(($wrongMinutes < 10 ? $wrongMinutes * 10 : $wrongMinutes) * 0.6), 0, 2);
        return (string)($hours . '.' . $minutes);
    }
}

if (!function_exists('convert_number_to_time_array')) {
    function convert_number_to_time_array($number): array
    {
        $number = explode('.', $number);
        $hours = isset($number[0]) ? (int)$number[0] : 0;
        $wrongMinutes = isset($number[1]) ? (int)$number[1] : 0;
        $minutes = (int)substr(ceil(($wrongMinutes < 10 ? $wrongMinutes * 10 : $wrongMinutes) * 0.6), 0, 2);
        return [
            'hours' => $hours,
            'minutes' => $minutes
        ];
    }
}

if (!function_exists('convert_time_to_minutes')) {
    function convert_time_to_minutes($time): float|int
    {
        if (!$time) {
            return 0.0;
        }
        $time = explode('.', $time);
        $hours = isset($time[0]) ? abs((int)$time[0]) : 0;
        $minutes = isset($time[1]) ? abs((int)$time[1]) : 0;
        $hours *= 60;
        return $hours + $minutes;
    }
}


