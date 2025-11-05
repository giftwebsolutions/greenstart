<?php

namespace Modules\SysAdmin\Repository;

use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Interfaces\SettingInterface;
use Modules\SysAdmin\Models\Settings;
use Illuminate\Support\Facades\Cache;

/**
 * Class SettingRepository
 *
 * @package namespace Modules\SysAdmin\Repository;
 */
class SettingRepository extends BaseRepository implements SettingInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Settings::class;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $response = '';
        if ($id != 0) {
            $response =  parent::update($data, $id);
        } else {
            $response = parent::create($data);
        }
        Cache::forget(Settings::$cache_key);
        return $response;
    }
}
