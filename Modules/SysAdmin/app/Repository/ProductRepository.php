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
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository implements ProductInterface
{
    public function model()
    {
        return Product::class;
    }

    /**
     * Create or update a product (base + thumb only)
     * Gallery handled separately using syncGallery()
     */
    public function saveOrUpdate($data, $id = 0)
    {
        if ($id !== 0) {
            $product = $this->find($id);
            $createdAt = Carbon::createFromTimestamp($product->created_at);

            // Only update thumb if a new file is uploaded
            if (isset($data['thumb']) && $data['thumb'] instanceof UploadedFile) {
                if ($product->thumb) {
                    ImageUploader::remove($createdAt, $product->thumb);
                }

                $data['thumb'] = ImageUploader::upload($data['thumb'], $createdAt);
            } else {
                // Do not touch existing thumb
                unset($data['thumb']);
            }

            return parent::update($data, $id);
        }

        // Create
        if (isset($data['thumb']) && $data['thumb'] instanceof UploadedFile) {
            $data['thumb'] = ImageUploader::upload($data['thumb'], null);
        } else {
            unset($data['thumb']);
        }

        return parent::create($data);
    }

    /**
     * Product Gallery Sync
     * - Uploads new images into product_image table
     * - Optional: if you want "replace", clear old first
     */
    public function syncGallery(Product $product, array $files = [], bool $replace = false): void
    {
        if (empty($files)) {
            return;
        }

        // If replacing: delete old rows + files (optional file removal if you store created_at)
        if ($replace) {
            DB::table('product_image')->where('product_id', $product->id)->delete();
        }

        $createdAt = Carbon::createFromTimestamp($product->created_at);

        foreach ($files as $file) {
            if (!($file instanceof UploadedFile)) {
                continue;
            }

            $filename = ImageUploader::upload($file, $createdAt);

            DB::table('product_image')->insert([
                'product_id'  => $product->id,
                'image'       => $filename,
                'sort_order'  => 0,
            ]);
        }
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
        return [];
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
