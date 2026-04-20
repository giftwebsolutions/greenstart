<?php

namespace Modules\SysAdmin\Repository;

use Illuminate\Support\Str;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Interfaces\TagInterface;
use Modules\SysAdmin\Models\Tag;
use Prettus\Repository\Criteria\RequestCriteria;

class TagRepository extends BaseRepository implements TagInterface
{
    public function model()
    {
        return Tag::class;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $data['slug'] = Str::slug($data['name']);

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
