<?php

namespace Modules\SysAdmin\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\SysAdmin\Interfaces\BlockInterface;
use Modules\SysAdmin\Interfaces\BlogCategoryInterface;
use Modules\SysAdmin\Interfaces\BlogInterface;
use  Modules\SysAdmin\Repository\PageRepository;
use Modules\SysAdmin\Interfaces\PageInterface;
use Modules\SysAdmin\Interfaces\SettingInterface;
use Modules\SysAdmin\Interfaces\SliderInterface;
use Modules\SysAdmin\Interfaces\SliderItemInterface;
use Modules\SysAdmin\Interfaces\UserInterface;
use Modules\SysAdmin\Repository\BlockRepository;
use Modules\SysAdmin\Repository\BlogCategoryRepository;
use Modules\SysAdmin\Repository\BlogRepository;
use Modules\SysAdmin\Repository\SettingRepository;
use Modules\SysAdmin\Repository\SliderItemRepository;
use Modules\SysAdmin\Repository\SliderRepository;
use Modules\SysAdmin\Repository\UserRepository;
use Modules\SysAdmin\Interfaces\AttributeGroupInterface;
use Modules\SysAdmin\Interfaces\AttributeInterface;
use Modules\SysAdmin\Interfaces\AttributeMappingInterface;
use Modules\SysAdmin\Interfaces\AttributeTypeInterface;
use Modules\SysAdmin\Repository\AttributeGroupRepository;
use Modules\SysAdmin\Repository\AttributeMappingRepository;
use Modules\SysAdmin\Repository\AttributeRepository;
use Modules\SysAdmin\Repository\AttributeTypeRepository;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BlogInterface::class, BlogRepository::class);
        $this->app->bind(BlockInterface::class, BlockRepository::class);
        $this->app->bind(BlogCategoryInterface::class, BlogCategoryRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(SettingInterface::class, SettingRepository::class);
        $this->app->bind(SliderInterface::class, SliderRepository::class);
        $this->app->bind(SliderItemInterface::class, SliderItemRepository::class);
        $this->app->bind(PageInterface::class, PageRepository::class);
        $this->app->bind(AttributeInterface::class, AttributeRepository::class);
        $this->app->bind(AttributeGroupInterface::class, AttributeGroupRepository::class);
        $this->app->bind(AttributeTypeInterface::class, AttributeTypeRepository::class);
        $this->app->bind(AttributeMappingInterface::class, AttributeMappingRepository::class);
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
