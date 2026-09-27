<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Support;

use Illuminate\Support\Str;

final class PermissionCatalog
{
    /** @return array<string, array<string, string>> */
    public static function groups(): array
    {
        return [
            'Administration' => [
                'sysadmin.dashboard.view' => 'View dashboard',
                'sysadmin.user.view' => 'View users',
                'sysadmin.user.create' => 'Create users',
                'sysadmin.user.update' => 'Update users',
                'sysadmin.user.delete' => 'Delete users',
                'sysadmin.user.assign_role' => 'Assign user roles',
                'sysadmin.role.view' => 'View roles and permissions',
                'sysadmin.role.create' => 'Create roles',
                'sysadmin.role.update' => 'Update role permissions',
                'sysadmin.role.delete' => 'Delete roles',
                'sysadmin.settings.view' => 'View site settings',
                'sysadmin.settings.update' => 'Update site settings',
            ],
            'Catalog' => [
                'catalog.attributes.view' => 'View attributes',
                'catalog.attributes.create' => 'Create attributes',
                'catalog.attributes.update' => 'Update attributes',
                'catalog.attributes.delete' => 'Delete attributes',
                'catalog.families.view' => 'View attribute families',
                'catalog.families.create' => 'Create attribute families',
                'catalog.families.update' => 'Update attribute families',
                'catalog.families.delete' => 'Delete attribute families',
                'catalog.products.view' => 'View products',
                'catalog.products.create' => 'Create products',
                'catalog.products.update' => 'Update products',
                'catalog.products.delete' => 'Delete products',
                'catalog.categories.view' => 'View product categories',
                'catalog.categories.create' => 'Create product categories',
                'catalog.categories.update' => 'Update product categories',
                'catalog.categories.delete' => 'Delete product categories',
            ],
            'Content' => [
                'content.pages.view' => 'View pages',
                'content.pages.create' => 'Create pages',
                'content.pages.update' => 'Update pages',
                'content.pages.delete' => 'Delete pages',
                'content.blocks.view' => 'View content blocks',
                'content.blocks.create' => 'Create content blocks',
                'content.blocks.update' => 'Update content blocks',
                'content.blocks.delete' => 'Delete content blocks',
                'content.blogs.view' => 'View blogs',
                'content.blogs.create' => 'Create blogs',
                'content.blogs.update' => 'Update blogs',
                'content.blogs.delete' => 'Delete blogs',
                'content.tags.view' => 'View tags',
                'content.tags.create' => 'Create tags',
                'content.tags.update' => 'Update tags',
                'content.tags.delete' => 'Delete tags',
                'content.testimonials.view' => 'View testimonials',
                'content.testimonials.create' => 'Create testimonials',
                'content.testimonials.update' => 'Update testimonials',
                'content.testimonials.delete' => 'Delete testimonials',
            ],
            'Customers' => [
                'customer.enquiries.view' => 'View enquiries',
                'customer.enquiries.create' => 'Create enquiries',
                'customer.enquiries.update' => 'Update enquiries',
                'customer.enquiries.delete' => 'Delete enquiries',
            ],
            'Media & tools' => [
                'media.sliders.view' => 'View sliders',
                'media.sliders.create' => 'Create sliders',
                'media.sliders.update' => 'Update sliders',
                'media.sliders.delete' => 'Delete sliders',
                'media.galleries.view' => 'View galleries',
                'media.galleries.create' => 'Create galleries',
                'media.galleries.update' => 'Update galleries',
                'media.galleries.delete' => 'Delete galleries',
                'sysadmin.server_tools.manage' => 'Manage server tools',
            ],
        ];
    }

    /** @return array<int, string> */
    public static function names(): array
    {
        return collect(self::groups())->flatMap(fn (array $permissions) => array_keys($permissions))->values()->all();
    }

    public static function forRoute(?string $routeName): ?string
    {
        if (! $routeName || ! Str::startsWith($routeName, 'sysadmin.')) {
            return null;
        }

        if ($routeName === 'sysadmin.index') {
            return 'sysadmin.dashboard.view';
        }

        $maps = [
            'sysadmin.user.' => 'sysadmin.user',
            'sysadmin.roles.' => 'sysadmin.role',
            'sysadmin.settings.' => 'sysadmin.settings',
            'sysadmin.catalog.attribute.family.' => 'catalog.families',
            'sysadmin.catalog.attribute.group.' => 'catalog.families',
            'sysadmin.catalog.attribute.' => 'catalog.attributes',
            'sysadmin.catalog.productcategory.' => 'catalog.categories',
            'sysadmin.catalog.product.' => 'catalog.products',
            'sysadmin.cms.page.' => 'content.pages',
            'sysadmin.cms.block.' => 'content.blocks',
            'sysadmin.blog.tags.' => 'content.tags',
            'sysadmin.blog.category.' => 'content.blogs',
            'sysadmin.blog.' => 'content.blogs',
            'sysadmin.testimonial.' => 'content.testimonials',
            'sysadmin.enquiry.' => 'customer.enquiries',
            'sysadmin.slider.' => 'media.sliders',
            'sysadmin.media.gallery.' => 'media.galleries',
            'sysadmin.media.sitemap.' => 'sysadmin.server_tools',
            'sysadmin.media.code.' => 'sysadmin.server_tools',
            'sysadmin.tools.' => 'sysadmin.server_tools',
        ];

        foreach ($maps as $prefix => $permissionPrefix) {
            if (! Str::startsWith($routeName, $prefix)) {
                continue;
            }

            $action = Str::afterLast($routeName, '.');
            if (Str::endsWith($routeName, 'attributes.store')) {
                $action = 'update';
            }
            $ability = match ($action) {
                'index', 'view', 'show', 'list', 'available-items', 'subcategories', 'load-attributes', 'attributes' => 'view',
                'create', 'store', 'upload', 'item-create' => 'create',
                'edit', 'update', 'reorder', 'item-save' => 'update',
                'delete', 'destroy', 'remove', 'item-delete' => 'delete',
                default => 'manage',
            };

            $permission = $permissionPrefix.'.'.$ability;

            return in_array($permission, self::names(), true) ? $permission : null;
        }

        return null;
    }
}
