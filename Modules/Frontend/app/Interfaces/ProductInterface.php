<?php

namespace Modules\SysAdmin\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;
use Modules\SysAdmin\Models\Product;

interface ProductInterface extends RepositoryInterface
{
    public function paginateForFrontend(array $filters = [], int $perPage = 12);

    public function findForFrontend(string|int $id): ?Product;

    public function findWithVariantsForFrontend(string|int $id): ?Product;

    public function getRelatedForFrontend(Product $product, int $limit = 10);
}
