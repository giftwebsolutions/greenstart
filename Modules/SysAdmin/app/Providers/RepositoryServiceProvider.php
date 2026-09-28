<?php

namespace Modules\SysAdmin\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\SysAdmin\Interfaces\AttributeGroupInterface;
use Modules\SysAdmin\Interfaces\AttributeInterface;
use Modules\SysAdmin\Interfaces\AttributeTypeInterface;
use Modules\SysAdmin\Interfaces\AttributeValueInterface;
use Modules\SysAdmin\Interfaces\BlockInterface;
use Modules\SysAdmin\Interfaces\BlogCategoryInterface;
use Modules\SysAdmin\Interfaces\BlogInterface;
use Modules\SysAdmin\Interfaces\EnquiryInterface;
use Modules\SysAdmin\Interfaces\GalleryInterface;
use Modules\SysAdmin\Interfaces\GalleryItemInterface;
use Modules\SysAdmin\Interfaces\PageInterface;
use Modules\SysAdmin\Interfaces\ProductAttributeValueInterface;
use Modules\SysAdmin\Interfaces\ProductCategoryInterface;
use Modules\SysAdmin\Interfaces\ProductConfigurableAttributeInterface;
use Modules\SysAdmin\Interfaces\ProductInterface;
use Modules\SysAdmin\Interfaces\ProductVariantInterface;
use Modules\SysAdmin\Interfaces\SliderInterface;
use Modules\SysAdmin\Interfaces\SliderItemInterface;
use Modules\SysAdmin\Interfaces\TagInterface;
use Modules\SysAdmin\Interfaces\TestimonialInterface;
use Modules\SysAdmin\Repository\AttributeGroupRepository;
use Modules\SysAdmin\Repository\AttributeRepository;
use Modules\SysAdmin\Repository\AttributeTypeRepository;
use Modules\SysAdmin\Repository\AttributeValueRepository;
use Modules\SysAdmin\Repository\BlockRepository;
use Modules\SysAdmin\Repository\BlogCategoryRepository;
use Modules\SysAdmin\Repository\BlogRepository;
use Modules\SysAdmin\Repository\EnquiryRepository;
use Modules\SysAdmin\Repository\GalleryItemRepository;
use Modules\SysAdmin\Repository\GalleryRepository;
use Modules\SysAdmin\Repository\PageRepository;
use Modules\SysAdmin\Repository\ProductAttributeValueRepository;
use Modules\SysAdmin\Repository\ProductCategoryRepository;
use Modules\SysAdmin\Repository\ProductConfigurableAttributeRepository;
use Modules\SysAdmin\Repository\ProductRepository;
use Modules\SysAdmin\Repository\ProductVariantRepository;
use Modules\SysAdmin\Repository\SliderItemRepository;
use Modules\SysAdmin\Repository\SliderRepository;
use Modules\SysAdmin\Repository\TagRepository;
use Modules\SysAdmin\Repository\TestimonialRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TagInterface::class, TagRepository::class);
        $this->app->bind(GalleryInterface::class, GalleryRepository::class);
        $this->app->bind(GalleryItemInterface::class, GalleryItemRepository::class);
        $this->app->bind(TestimonialInterface::class, TestimonialRepository::class);
        $this->app->bind(BlogInterface::class, BlogRepository::class);
        $this->app->bind(BlockInterface::class, BlockRepository::class);
        $this->app->bind(BlogCategoryInterface::class, BlogCategoryRepository::class);
        $this->app->bind(SliderInterface::class, SliderRepository::class);
        $this->app->bind(SliderItemInterface::class, SliderItemRepository::class);
        $this->app->bind(PageInterface::class, PageRepository::class);
        $this->app->bind(AttributeInterface::class, AttributeRepository::class);
        $this->app->bind(AttributeGroupInterface::class, AttributeGroupRepository::class);
        $this->app->bind(AttributeTypeInterface::class, AttributeTypeRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(ProductCategoryInterface::class, ProductCategoryRepository::class);
        $this->app->bind(ProductAttributeValueInterface::class, ProductAttributeValueRepository::class);
        $this->app->bind(AttributeValueInterface::class, AttributeValueRepository::class);
        $this->app->bind(ProductConfigurableAttributeInterface::class, ProductConfigurableAttributeRepository::class);
        $this->app->bind(ProductVariantInterface::class, ProductVariantRepository::class);
        $this->app->bind(EnquiryInterface::class, EnquiryRepository::class);
    }
}
