<?php

namespace Modules\SysAdmin\Repository;

use App\Models\SliderItem;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\SliderInterface;
use Modules\SysAdmin\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

/**
 * Class BlockRepositoryEloquent.
 *
 * @package namespace Modules\SysAdmin\Repository;
 */
class SliderRepository extends BaseRepository implements SliderInterface
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
        return Slider::class;
    }

    public function saveOrUpdate($data, $id = 0)
    {

        //dd($data);
        if ($id !== 0) {
            $slider = $this->find($id);
            $createdAt = $slider->created_at;
           //dd($createdAt);
            // Only update thumbnail if a new file is uploaded
            if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
                if ($slider->thumbnail) {
                    ImageUploader::remove($createdAt, $slider->thumbnail);
                }

                $data['thumbnail'] = ImageUploader::upload($data['thumbnail'], $createdAt);
            } else {
                // Do not touch existing thumbnail
                unset($data['thumbnail']);
            }
            //dd($data);
            return parent::update($data, $id);
        }

        // Create
        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            $data['thumbnail'] = ImageUploader::upload($data['thumbnail'], null);
        } else {
            unset($data['thumbnail']);
        }

        return parent::create($data);
    }

    public function destroysliderimage($id){
        $slider = $this->find($id);
        $createdAt = $slider->created_at;

        ImageUploader::remove($createdAt, $slider->thumbnail);
    }
    
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
