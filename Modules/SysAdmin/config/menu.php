<?php
return [

    [
        'key'        => 'dashboard',
        'name'       => 'Dashboard',
        'route'      => 'sysadmin.index',
        'sort'       => 1,
        'icon'       => 'stroke-home',
        'children' => [],
    ],

    [
        'key'        => 'settings',
        'name'       => 'Settings',
        'route'      => '#',
        'sort'       => 1,
        'icon'       => 'stroke-widget',
        'children' => [
            [
                'key'        => 'app-settings',
                'name'       => 'App Settings',
                'route'      => 'sysadmin.settings.index',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ],

        ]
    ],

    [
        'key'        => 'user',
        'name'       => 'Users',
        'route'      => '#',
        'sort'       => 1,
        'icon'       => 'stroke-user',
        'children' => [
            [
                'key'        => 'user-list',
                'name'       => 'Manage Users',
                'route'      => 'sysadmin.user.index',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ],
            [
                'key'        => 'user-create',
                'name'       => 'Create User',
                'route'      => 'sysadmin.user.create',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ]
        ]
    ],
    [
        'key'        => 'catalog',
        'name'       => 'Catalog',
        'route'      => '#',
        'sort'       => 1,
        'icon'       => 'stroke-project',
        'children' => [
            [
                'key'        => 'atrribute-list',
                'name'       => 'Manage Attributes',
                'route'      => 'sysadmin.catalog.attribute.index',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ],
            [
                'key'        => 'attribute-group',
                'name'       => 'Attribute Groups',
                'route'      => 'sysadmin.catalog.attribute.group.index',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ],
             [
                'key'        => 'attribute-type',
                'name'       => 'Attribute Type',
                'route'      => 'sysadmin.catalog.attribute.type.index',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ],
            [
                'key'        => 'product-list',
                'name'       => 'Manage Products',
                'route'      => 'sysadmin.catalog.product.index',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ]
            
        ]
    ],
    [
        'key'        => 'page',
        'name'       => 'CMS Pages',
        'route'      => '#',
        'sort'       => 1,
        'icon'       => 'stroke-project',
        'children' => [
            [
                'key'        => 'page-list',
                'name'       => 'Manage Pages',
                'route'      => 'sysadmin.cms.page.index',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ],
            [
                'key'        => 'page-create',
                'name'       => 'Create Page',
                'route'      => 'sysadmin.cms.page.create',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ],
            [
                'key'        => 'block-list',
                'name'       => 'Manage Blocks',
                'route'      => 'sysadmin.cms.block.index',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ]
        ]
    ],
    [
        'key'        => 'blog',
        'name'       => 'Blogs',
        'route'      => 'sysadmin.blog.index',
        'sort'       => 1,
        'icon'       => 'stroke-user',
        'children' => [
            [
                'key'        => 'blog-category',
                'name'       => 'Manage Category',
                'route'      => 'sysadmin.blog.category.index',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ],
            [
                'key'        => 'blog-create',
                'name'       => 'Create Blog',
                'route'      => 'sysadmin.blog.create',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ],
            [
                'key'        => 'blog-list',
                'name'       => 'Manage Blog',
                'route'      => 'sysadmin.blog.index',
                'sort'       => 1,
                'icon'       => 'icon-gear',
            ]
        ]
    ],
];
