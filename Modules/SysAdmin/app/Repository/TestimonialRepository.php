<?php

namespace Modules\SysAdmin\Repository;

use Illuminate\Http\UploadedFile;
use Modules\SysAdmin\Core\Eloquent\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\TestimonialInterface;
use Modules\SysAdmin\Models\Testimonial;
use Throwable;

class TestimonialRepository extends BaseRepository implements TestimonialInterface
{
    public function model()
    {
        return Testimonial::class;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $removeImage = (bool) ($data['remove_image'] ?? false);
        unset($data['remove_image']);

        if ((int) $id === 0) {
            $createdAt = now()->toDateTimeString();
            $newImage = null;
            if (($data['image'] ?? null) instanceof UploadedFile) {
                $newImage = ImageUploader::upload($data['image'], $createdAt);
                $data['image'] = $newImage;
            } else {
                unset($data['image']);
            }

            try {
                return parent::create($data);
            } catch (Throwable $exception) {
                if ($newImage) {
                    ImageUploader::remove($createdAt, $newImage);
                }

                throw $exception;
            }
        }

        /** @var Testimonial $testimonial */
        $testimonial = $this->find($id);
        $createdAt = $testimonial->created_at?->toDateTimeString() ?? now()->toDateTimeString();
        $oldImage = $testimonial->image;
        $newImage = null;

        if (($data['image'] ?? null) instanceof UploadedFile) {
            $newImage = ImageUploader::upload($data['image'], $createdAt);
            $data['image'] = $newImage;
        } elseif ($removeImage) {
            $data['image'] = null;
        } else {
            unset($data['image']);
        }

        try {
            $updated = parent::update($data, $id);
        } catch (Throwable $exception) {
            if ($newImage) {
                ImageUploader::remove($createdAt, $newImage);
            }

            throw $exception;
        }

        if ($oldImage && ($newImage || $removeImage)) {
            ImageUploader::remove($createdAt, $oldImage);
        }

        return $updated;
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
