<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'type', 'group', 'description'];

    public $timestamps = true;

    // Cache settings untuk performa
    protected static $cache = [];

    public static function getValue($key, $default = null)
    {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        // Convert value based on type
        $value = match($setting->type) {
            'number' => (float) $setting->value,
            'boolean' => (bool) $setting->value,
            'json' => json_decode($setting->value, true),
            default => $setting->value
        };

        self::$cache[$key] = $value;
        return $value;
    }

    public static function setValue($key, $value)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return false;
        }

        // Convert value based on type
        $setting->value = match($setting->type) {
            'number', 'boolean' => (string) $value,
            'json' => json_encode($value),
            default => $value
        };

        $setting->save();
        self::$cache[$key] = $value; // Update cache
        
        return true;
    }

    public static function getGroup($group)
    {
        return self::where('group', $group)->get()->mapWithKeys(function ($item) {
            return [$item->key => self::convertValue($item->value, $item->type)];
        });
    }

    private static function convertValue($value, $type)
    {
        return match($type) {
            'number' => (float) $value,
            'boolean' => (bool) $value,
            'json' => json_decode($value, true),
            default => $value
        };
    }
}