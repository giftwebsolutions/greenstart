<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Interfaces\RoleInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository implements RoleInterface
{
    public function model()
    {
        return Role::class;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        if ($id !== 0) {
            return parent::update($data, $id);
        }

        return parent::create($data);
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
