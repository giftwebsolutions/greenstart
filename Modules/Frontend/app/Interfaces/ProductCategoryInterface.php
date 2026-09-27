<?php

namespace Modules\Frontend\Interfaces;

use Modules\SysAdmin\Core\Contracts\RepositoryInterface;

interface ProductCategoryInterface extends RepositoryInterface
{
    /**
     * List active root categories (parent_id = 0)
     */
    public function getRootCategories();

    /**
     * List active children of a category
     */
    public function getChildren(int $parentId);

    /**
     * Find active category by slug (for frontend)
     */
    public function findBySlug(string $slug);
}
