<?php

namespace App\Models;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public bool $site_active;

    public static function group(): string
    {
        return 'general';
    }

    public static function getSettingValue($key): string
    {
        return app(self::class)->$key;
    }

}
