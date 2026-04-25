<?php

namespace Modules\SysAdmin\Repository;

use App\Models\Slider;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\SliderItemInterface;
use Modules\SysAdmin\Models\SliderItem;

/**
 * Class BlockRepositoryEloquent.
 *
 * @package namespace Modules\SysAdmin\Repository;
 */
class SliderItemRepository extends BaseRepository implements SliderItemInterface
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
        return SliderItem::class;
    }

    public function save($data)
    {
        $response = '';
        $data['file'] = ImageUploader::upload($data['file'], null);        
        $response = parent::create($data);
        return $response;
    }


    public function destroyslideritemimage($id)
    {
        $slideritem = $this->find($id);
        $createdAt = $slideritem->created_at;
        ImageUploader::remove($createdAt, $slideritem->file);
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
