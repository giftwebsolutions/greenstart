<?php

namespace Modules\SysAdmin\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;
use Modules\SysAdmin\Models\Product;

interface ProductInterface extends RepositoryInterface
{
    /**
     * Frontend paginated listing.
     */
    public function paginateForFrontend(array $filters = [], int $perPage = 12);

    /**
     * Find product for frontend (by slug or ID).
     */
    public function findForFrontend(string|int $id): ?Product;

    /**
     * Related products for frontend.
     */
    public function getRelatedForFrontend(Product $product, int $limit = 10);
}
