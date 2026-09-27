<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class Setting
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string|null $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Settings extends Model
{
    use HasFactory;

    public static $cache_key = 'settings';

    public static $types = [
        'core' => 'Core Settings',
        'system' => 'System Settings',
        'social-media' => 'Social Media Settings',
        'theme' => 'Theme Settings',
        'seo' => 'SEO Settings',
        'analytics' => 'Analytics & Code Settings',
        'catalog' => 'Catalog Settings',
        'smtp' => 'SMTP Settings',
        'custom' => 'Custom Settings',
    ];

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    public static function getSettingByType(string $type): array
    {
        // Kept as an all-settings map for backwards compatibility: storefront
        // consumers historically request "system" and then read social/core keys.
        return Cache::rememberForever(self::$cache_key, fn (): array => self::query()
            ->pluck('value', 'key')
            ->map(fn ($value) => (string) $value)
            ->all());
    }

    public static function assetUrl(?string $path, string $fallback): string
    {
        if (blank($path)) {
            return asset($fallback);
        }

        return Str::startsWith($path, ['http://', 'https://'])
            ? $path
            : Storage::disk('public')->url($path);
    }
}
