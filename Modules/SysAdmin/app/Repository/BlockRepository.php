<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Core\Eloquent\RequestCriteria;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\BlockInterface;
use Modules\SysAdmin\Models\Blocks;

/**
 * Class BlockRepositoryEloquent.
 */
class BlockRepository extends BaseRepository implements BlockInterface
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Blocks::class;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $block = $id !== 0 ? $this->find($id) : null;
        $oldImage = null;

        if (! empty($data['thumbnail'])) {
            $data['thumbnail'] = ImageUploader::upload($data['thumbnail'], $block?->created_at);
            $oldImage = $block?->thumbnail;
        } elseif ($block?->thumbnail && ! empty($data['remove_thumbnail'])) {
            $data['thumbnail'] = null;
            $oldImage = $block->thumbnail;
        }

        unset($data['remove_thumbnail']);

        $savedBlock = $id !== 0
            ? parent::update($data, $id)
            : parent::create($data);

        if ($oldImage) {
            ImageUploader::remove((string) $savedBlock->created_at, $oldImage);
        }

        return $savedBlock;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
