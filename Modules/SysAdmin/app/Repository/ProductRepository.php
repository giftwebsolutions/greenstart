<?php

namespace Modules\SysAdmin\Repository;

use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Interfaces\ProductInterface;
use Modules\SysAdmin\Models\ProductCategory;
use Modules\SysAdmin\Helpers\ImageUploader;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

class ProductRepository extends BaseRepository implements ProductInterface
{
    protected $fillable = [];

    public function model()
    {
        return Product::class;
    }

    /**
     * Create or update a product
     */
    public function saveOrUpdate($data, $id = 0)
    {
        $product = null;

        if ($id !== 0) {
            // Editing existing product
            $product = $this->find($id);

            // Handle thumb upload only if a new file is provided
            if (isset($data['thumb']) && $data['thumb'] instanceof UploadedFile) {
                $createdAt = Carbon::createFromTimestamp($product->created_at);
                // Remove old image (original + thumbnail)
                if ($product->thumb && $product->created_at) {
                    ImageUploader::remove($product->thumb, $createdAt);
                }

                // Upload new one using existing created_at date
                $data['thumb'] = ImageUploader::upload(
                    $data['thumb'],
                    $createdAt
                );
            } else {
                // Don't touch the current thumb if no new file is uploaded
                unset($data['thumb']);
            }
            //dd($data);
            $product = parent::update($data, $id);
        } else {
            // Creating new product

            if (isset($data['thumb']) && $data['thumb'] instanceof UploadedFile) {
                // For create, pass null date -> ImageUploader will use now()
                $data['thumb'] = ImageUploader::upload($data['thumb'], null);
            }

            $product = parent::create($data);
        }

        return $product;
    }

    public function getStatuses(): array
    {
        return Product::$statuses;
    }

    public function getCategories(): array
    {
        return ProductCategory::where('parent_id', 0)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getSubCategories(int $parentId = null): array
    {
        $query = ProductCategory::query()->orderBy('name');

        if ($parentId) {
            $query->where('parent_id', $parentId);
        }

        return []; //$query->pluck('name', 'id')->toArray();
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
