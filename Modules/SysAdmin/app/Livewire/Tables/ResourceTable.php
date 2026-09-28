<?php

namespace Modules\SysAdmin\Livewire\Tables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use InvalidArgumentException;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\SysAdmin\Models\AttributeGroup;
use Modules\SysAdmin\Models\AttributeType;
use Modules\SysAdmin\Models\Blocks;
use Modules\SysAdmin\Models\Blog;
use Modules\SysAdmin\Models\BlogCategory;
use Modules\SysAdmin\Models\Gallery;
use Modules\SysAdmin\Models\Page;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Models\ProductCategory;
use Modules\SysAdmin\Models\Slider;
use Modules\SysAdmin\Models\Tag;

class ResourceTable extends Component
{
    use WithPagination;

    public string $resource;

    #[Url(except: '')]
    public string $search = '';

    public int $perPage = 15;

    public string $sortField = 'id';

    public string $sortDirection = 'desc';

    public function mount(string $resource): void
    {
        $this->resource = $resource;
        $definition = $this->definition();
        $this->sortField = $definition['sort'][0] ?? 'id';
        $this->sortDirection = $definition['sort'][1] ?? 'desc';
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function sort(string $field): void
    {
        $allowed = collect($this->definition()['columns'])->pluck('sort', 'key')->filter()->values()->all();
        abort_unless(in_array($field, $allowed, true), 422);

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $definition = $this->definition();
        $query = $definition['model']::query()->with($definition['with'] ?? []);

        if ($this->search !== '') {
            $term = '%'.trim($this->search).'%';
            $query->where(function (Builder $nested) use ($definition, $term): void {
                foreach ($definition['search'] as $index => $field) {
                    $index === 0 ? $nested->where($field, 'like', $term) : $nested->orWhere($field, 'like', $term);
                }
            });
        }

        /** @var LengthAwarePaginator $rows */
        $rows = $query->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);

        return view('sysadmin::livewire.tables.resource-table', compact('definition', 'rows'));
    }

    private function definition(): array
    {
        return self::definitions()[$this->resource]
            ?? throw new InvalidArgumentException("Unknown admin table [{$this->resource}].");
    }

    public static function definitions(): array
    {
        $status = ['key' => 'status', 'label' => 'Status', 'sort' => 'status', 'type' => 'status'];
        $id = ['key' => 'id', 'label' => 'ID', 'sort' => 'id'];

        return [
            'attribute-groups' => ['model' => AttributeGroup::class, 'title' => 'Attribute Groups', 'description' => 'Groups are arranged inside the family builder.', 'columns' => [$id, ['key' => 'family.name', 'label' => 'Family'], ['key' => 'name', 'label' => 'Group', 'sort' => 'name'], ['key' => 'position', 'label' => 'Position', 'sort' => 'position'], $status], 'search' => ['name', 'slug'], 'with' => ['family'], 'create' => 'sysadmin.catalog.attribute.family.index', 'edit' => null, 'view' => null, 'delete' => null, 'sort' => ['position', 'asc']],
            'attribute-types' => ['model' => AttributeType::class, 'title' => 'Attribute Types', 'description' => 'Input controls available to product attributes.', 'columns' => [['key' => 'attribute_type_id', 'label' => 'ID', 'sort' => 'attribute_type_id'], ['key' => 'type_name', 'label' => 'Name', 'sort' => 'type_name'], ['key' => 'identifier', 'label' => 'Identifier', 'sort' => 'identifier'], $status], 'search' => ['type_name', 'identifier'], 'create' => 'sysadmin.catalog.attribute.type.create', 'edit' => 'sysadmin.catalog.attribute.type.edit', 'view' => 'sysadmin.catalog.attribute.type.view', 'delete' => 'sysadmin.catalog.attribute.type.delete', 'sort' => ['type_name', 'asc']],
            'blocks' => ['model' => Blocks::class, 'title' => 'Content Blocks', 'description' => 'Reusable storefront content sections.', 'columns' => [$id, ['key' => 'key', 'label' => 'Key', 'sort' => 'key'], ['key' => 'title', 'label' => 'Title', 'sort' => 'title'], ['key' => 'created_at', 'label' => 'Created', 'sort' => 'created_at', 'type' => 'date']], 'search' => ['key', 'title'], 'create' => 'sysadmin.cms.block.create', 'edit' => 'sysadmin.cms.block.edit', 'view' => 'sysadmin.cms.block.view', 'delete' => 'sysadmin.cms.block.delete'],
            'blog-categories' => ['model' => BlogCategory::class, 'title' => 'Blog Categories', 'description' => 'Organize articles and news.', 'columns' => [$id, ['key' => 'name', 'label' => 'Name', 'sort' => 'name'], ['key' => 'parent.name', 'label' => 'Parent'], $status, ['key' => 'updated_at', 'label' => 'Updated', 'sort' => 'updated_at', 'type' => 'date']], 'search' => ['name', 'slug'], 'with' => ['parent'], 'create' => 'sysadmin.blog.category.create', 'edit' => 'sysadmin.blog.category.edit', 'view' => 'sysadmin.blog.category.view', 'delete' => 'sysadmin.blog.category.delete'],
            'blogs' => ['model' => Blog::class, 'title' => 'Blogs', 'description' => 'Articles and storefront editorial content.', 'columns' => [$id, ['key' => 'title', 'label' => 'Title', 'sort' => 'title'], ['key' => 'category.name', 'label' => 'Category'], $status, ['key' => 'updated_at', 'label' => 'Updated', 'sort' => 'updated_at', 'type' => 'date']], 'search' => ['title', 'slug'], 'with' => ['category'], 'create' => 'sysadmin.blog.create', 'edit' => 'sysadmin.blog.edit', 'view' => 'sysadmin.blog.view', 'delete' => 'sysadmin.blog.delete'],
            'galleries' => ['model' => Gallery::class, 'title' => 'Galleries', 'description' => 'Storefront media collections.', 'columns' => [$id, ['key' => 'name', 'label' => 'Name', 'sort' => 'name'], $status, ['key' => 'created_at', 'label' => 'Created', 'sort' => 'created_at', 'type' => 'date']], 'search' => ['name'], 'create' => 'sysadmin.media.gallery.create', 'edit' => 'sysadmin.media.gallery.edit', 'view' => 'sysadmin.media.gallery.view', 'delete' => 'sysadmin.media.gallery.delete'],
            'pages' => ['model' => Page::class, 'title' => 'Pages', 'description' => 'Storefront content pages.', 'columns' => [$id, ['key' => 'name', 'label' => 'Name', 'sort' => 'name'], ['key' => 'title', 'label' => 'Title', 'sort' => 'title'], $status, ['key' => 'updated_at', 'label' => 'Updated', 'sort' => 'updated_at', 'type' => 'date']], 'search' => ['name', 'title', 'slug'], 'create' => 'sysadmin.cms.page.create', 'edit' => 'sysadmin.cms.page.edit', 'view' => 'sysadmin.cms.page.view', 'delete' => 'sysadmin.cms.page.delete'],
            'products' => ['model' => Product::class, 'title' => 'Products', 'description' => 'Catalog products, prices, inventory and families.', 'columns' => [$id, ['key' => 'title', 'label' => 'Product', 'sort' => 'title'], ['key' => 'model', 'label' => 'Model', 'sort' => 'model'], ['key' => 'category.name', 'label' => 'Category'], ['key' => 'attributeFamily.name', 'label' => 'Family'], $status, ['key' => 'updated_at', 'label' => 'Updated', 'sort' => 'updated_at', 'type' => 'date']], 'search' => ['title', 'model', 'sku', 'product_code'], 'with' => ['category', 'attributeFamily'], 'create' => 'sysadmin.catalog.product.create', 'edit' => 'sysadmin.catalog.product.edit', 'view' => 'sysadmin.catalog.product.view', 'delete' => 'sysadmin.catalog.product.delete'],
            'product-categories' => ['model' => ProductCategory::class, 'title' => 'Product Categories', 'description' => 'Storefront catalog navigation.', 'columns' => [$id, ['key' => 'name', 'label' => 'Category', 'sort' => 'name'], ['key' => 'parent.name', 'label' => 'Parent'], ['key' => 'slug', 'label' => 'Slug', 'sort' => 'slug'], ['key' => 'sort', 'label' => 'Position', 'sort' => 'sort'], $status], 'search' => ['name', 'slug'], 'with' => ['parent'], 'create' => 'sysadmin.catalog.productcategory.create', 'edit' => 'sysadmin.catalog.productcategory.edit', 'view' => 'sysadmin.catalog.productcategory.view', 'delete' => 'sysadmin.catalog.productcategory.delete', 'sort' => ['sort', 'asc']],
            'sliders' => ['model' => Slider::class, 'title' => 'Sliders', 'description' => 'Storefront promotional sliders.', 'columns' => [$id, ['key' => 'name', 'label' => 'Name', 'sort' => 'name'], $status, ['key' => 'created_at', 'label' => 'Created', 'sort' => 'created_at', 'type' => 'date']], 'search' => ['name', 'slug'], 'create' => 'sysadmin.slider.create', 'edit' => 'sysadmin.slider.edit', 'view' => 'sysadmin.slider.view', 'delete' => 'sysadmin.slider.delete'],
            'tags' => ['model' => Tag::class, 'title' => 'Tags', 'description' => 'Editorial labels used by blog content.', 'columns' => [$id, ['key' => 'name', 'label' => 'Name', 'sort' => 'name'], ['key' => 'slug', 'label' => 'Slug', 'sort' => 'slug'], ['key' => 'created_at', 'label' => 'Created', 'sort' => 'created_at', 'type' => 'date']], 'search' => ['name', 'slug'], 'create' => 'sysadmin.blog.tags.create', 'edit' => 'sysadmin.blog.tags.edit', 'view' => 'sysadmin.blog.tags.view', 'delete' => 'sysadmin.blog.tags.delete'],
        ];
    }
}
