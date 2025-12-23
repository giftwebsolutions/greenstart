<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\Testimonial;
use Modules\SysAdmin\Interfaces\TestimonialInterface;
use Modules\SysAdmin\Helpers\ImageUploader;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class TestimonialRepository extends BaseRepository implements TestimonialInterface
{
    public function model()
    {
        return Testimonial::class;
    }

     public function saveOrUpdate($data, $id = 0)
    {
        $testimonial = null;
         $createdAt = $this->getModel()->created_at;
        if ($id !== 0) {
            // Editing existing product
            $testimonial = $this->find($id);

            // Handle image upload only if a new file is provided
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
              
                // Remove old image (original + thumbnail)
                if ($testimonial->image && $testimonial->created_at) {
                    //ImageUploader::remove($testimonial->image, $createdAt);
                }

                // Upload new one using existing created_at date
                $data['image'] = ImageUploader::upload(
                    $data['image'],
                    $createdAt
                );
            } else {
                // Don't touch the current image if no new file is uploaded
                unset($data['image']);
            }
            //dd($data);
            $testimonial = parent::update($data, $id);
        } else {
            // Creating new product

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                // For create, pass null date -> ImageUploader will use now()
                $data['image'] = ImageUploader::upload($data['image'], $createdAt);
            }

            $testimonial = parent::create($data);
        }
        return $testimonial;
    }
   

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /* ================= FRONTEND HELPERS ================= */

    protected function baseQuery()
    {
        return $this->model->newQuery()
            ->select(['id', 'name', 'content', 'image', 'created_at']);
    }

    public function paginateFrontend(int $perPage = 10)
    {
        return $this->baseQuery()
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function recentFrontend(int $limit = 6)
    {
        return $this->baseQuery()
            ->latest('id')
            ->limit($limit)
            ->get();
    }

    public function searchFrontendPaginate(string $term, int $perPage = 10)
    {
        return $this->baseQuery()
            ->when($term, function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('content', 'like', "%{$term}%");
            })
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }
}
