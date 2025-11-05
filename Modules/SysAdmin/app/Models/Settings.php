<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Support\Facades\Cache;

/**
 * Class Setting
 * 
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string|null $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package Modules\SysAdmin\Models
 */
class Settings extends Model implements Transformable
{
    use HasFactory, TransformableTrait;

    public static $cache_key = 'settings';

    public static $types = [
        'core' => 'Core Settings',
        'system' => 'System Settings',
        'social-media' => 'Social Media Settings',
        'smtp' => 'STMP Settings',
    ];

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'type'
    ];

    public static function getSettingByType(string $type)
    {
        if (Cache::has(self::$cache_key)) {
            return Cache::get(self::$cache_key);
        } else {
            $datas = Settings::where('type', 'system')->select(['key', 'value'])->get()->toArray();
            $settings = [];
            if (!empty($datas)) {
                foreach ($datas as $data) {
                    $settings[$data['key']] = $data['value'];
                }
                Cache::put(self::$cache_key, $settings);
            }
            return $settings;
        }
    }
}
