<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Models\Testimonial;
use Modules\SysAdmin\Interfaces\TestimonialInterface;
use Modules\SysAdmin\Helpers\ImageUploader;

class TestimonialRepository extends BaseRepository implements TestimonialInterface
{
    public function model()
    {
        return Testimonial::class;
    }

    public function saveOrUpdate(array $data, int $id = 0)
    {
        if ($id > 0) {
            $testimonial = $this->find($id);

            if (!empty($data['image'])) {
                $data['image'] = ImageUploader::upload(
                    $data['image'],
                    $testimonial->created_at
                );
            }

            return $this->update($data, $id);
        }

        if (!empty($data['image'])) {
            $data['image'] = ImageUploader::upload(
                $data['image'],
                now()
            );
        }

        return $this->create($data);
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
