<?php

return [

    [
        'key' => 'dashboard',
        'name' => 'Dashboard',
        'route' => 'sysadmin.index',
        'sort' => 1,
        'icon' => 'home',
        'children' => [],
    ],

    [
        'key' => 'settings',
        'name' => 'Settings',
        'route' => '#',
        'sort' => 1,
        'icon' => 'settings',
        'children' => [
            [
                'key' => 'app-settings',
                'name' => 'App Settings',
                'route' => 'sysadmin.settings.index',
                'sort' => 1,
                'icon' => 'settings',
            ],

        ],
    ],

    [
        'key' => 'user',
        'name' => 'Users',
        'route' => '#',
        'sort' => 1,
        'icon' => 'users',
        'children' => [
            [
                'key' => 'user-list',
                'name' => 'Manage Users',
                'route' => 'sysadmin.user.index',
                'sort' => 1,
                'icon' => 'users',
            ],
            [
                'key' => 'roles-permissions',
                'name' => 'Roles & Permissions',
                'route' => 'sysadmin.roles.index',
                'sort' => 1,
                'icon' => 'shield',
            ],
        ],
    ],

    [
        'key' => 'slider',
        'name' => 'Slider',
        'route' => 'sysadmin.slider.index',
        'sort' => 1,
        'icon' => 'image',
        'children' => [
            [
                'key' => 'create-slider',
                'name' => 'Create Slider',
                'route' => 'sysadmin.slider.create',
                'sort' => 1,
                'icon' => 'plus',
            ],
            [
                'key' => 'index-slider',
                'name' => 'Manage Slider',
                'route' => 'sysadmin.slider.index',
                'sort' => 1,
                'icon' => 'image',
            ],
        ],
    ],

    [
        'key' => 'catalog',
        'name' => 'Catalog',
        'route' => '#',
        'sort' => 1,
        'icon' => 'box',
        'children' => [
            [
                'key' => 'atrribute-list',
                'name' => 'Manage Attributes',
                'route' => 'sysadmin.catalog.attribute.index',
                'sort' => 1,
                'icon' => 'tag',
            ],
            [
                'key' => 'attribute-family',
                'name' => 'Attribute Families',
                'route' => 'sysadmin.catalog.attribute.family.index',
                'sort' => 1,
                'icon' => 'layers',
            ],
            [
                'key' => 'attribute-type',
                'name' => 'Attribute Type',
                'route' => 'sysadmin.catalog.attribute.type.index',
                'sort' => 1,
                'icon' => 'settings',
            ],
            [
                'key' => 'product-list',
                'name' => 'Manage Products',
                'route' => 'sysadmin.catalog.product.index',
                'sort' => 1,
                'icon' => 'box',
            ],
            [
                'key' => 'product-category',
                'name' => 'Product Category',
                'route' => 'sysadmin.catalog.productcategory.index',
                'sort' => 1,
                'icon' => 'folder',
            ],

        ],
    ],
    [
        'key' => 'page',
        'name' => 'CMS Pages',
        'route' => '#',
        'sort' => 1,
        'icon' => 'file',
        'children' => [
            [
                'key' => 'page-list',
                'name' => 'Manage Pages',
                'route' => 'sysadmin.cms.page.index',
                'sort' => 1,
                'icon' => 'file',
            ],
            [
                'key' => 'page-create',
                'name' => 'Create Page',
                'route' => 'sysadmin.cms.page.create',
                'sort' => 1,
                'icon' => 'plus',
            ],
            [
                'key' => 'block-list',
                'name' => 'Manage Blocks',
                'route' => 'sysadmin.cms.block.index',
                'sort' => 1,
                'icon' => 'layers',
            ],
        ],
    ],

    [
        'key' => 'enquiry',
        'name' => 'Enquiry CRM',
        'route' => '#',
        'sort' => 1,
        'icon' => 'message',
        'children' => [
            [
                'key' => 'enquiry.create',
                'name' => 'Add Enquiry',
                'route' => 'sysadmin.enquiry.create',
                'sort' => 1,
                'icon' => 'plus',
            ],
            [
                'key' => 'enquiry.index',
                'name' => 'Enquiry CRM',
                'route' => 'sysadmin.enquiry.index',
                'sort' => 2,
                'icon' => 'message',
            ],
            [
                'key' => 'enquiry.appointments',
                'name' => 'Appointments',
                'route' => 'sysadmin.enquiry.appointments',
                'sort' => 3,
                'icon' => 'calendar',
            ],
        ],
    ],
    [
        'key' => 'testimonial',
        'name' => 'Testimonials',
        'route' => '#',
        'sort' => 1,
        'icon' => 'quote',
        'children' => [
            [
                'key' => 'testimonial.create',
                'name' => 'Add Testimonial',
                'route' => 'sysadmin.testimonial.create',
                'sort' => 1,
                'icon' => 'plus',
            ],
            [
                'key' => 'testimonial.index',
                'name' => 'Manage Testimonials',
                'route' => 'sysadmin.testimonial.index',
                'sort' => 2,
                'icon' => 'quote',
            ],
        ],
    ],

    [
        'key' => 'blog',
        'name' => 'Blogs',
        'route' => 'sysadmin.blog.index',
        'sort' => 1,
        'icon' => 'book',
        'children' => [
            [
                'key' => 'blog-category',
                'name' => 'Manage Category',
                'route' => 'sysadmin.blog.category.index',
                'sort' => 1,
                'icon' => 'folder',
            ],
            [
                'key' => 'blog-create',
                'name' => 'Create Blog',
                'route' => 'sysadmin.blog.create',
                'sort' => 1,
                'icon' => 'plus',
            ],
            [
                'key' => 'blog-list',
                'name' => 'Manage Blog',
                'route' => 'sysadmin.blog.index',
                'sort' => 1,
                'icon' => 'book',
            ],
        ],
    ],

    [
        'key' => 'system',
        'name' => 'System',
        'route' => '#',
        'sort' => 1,
        'icon' => 'server',
        'children' => [
            [
                'key' => 'system-tools',
                'name' => 'System Tools',
                'route' => 'sysadmin.tools.index',
                'sort' => 1,
                'icon' => 'server',
            ],
            [
                'key' => 'sitemap',
                'name' => 'XML Sitemap',
                'route' => 'sysadmin.media.sitemap.index',
                'sort' => 2,
                'icon' => 'map',
            ],
            [
                'key' => 'robots-editor',
                'name' => 'robots.txt Editor',
                'route' => 'sysadmin.media.code.robot',
                'sort' => 3,
                'icon' => 'bot',
            ],
        ],
    ],
];
