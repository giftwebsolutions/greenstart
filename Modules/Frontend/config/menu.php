<?php

return [
    [
        'label' => 'Home',
        'route' => 'frontend.home',
    ],
    [
        'label' => 'New Arrival',
        'route' => 'frontend.shop.newarraival',
    ],
    [
        'label' => 'Shop',
        'route' => 'frontend.shop.categories',
    ],
    [
        'label' => 'Blog',
        'route' => 'frontend.blog.index',
    ],
    [
        'label' => 'About Page',
        'route' => 'frontend.cms.view',
        'params' => ['slug' => 'about'],
    ],
    [
        'label' => 'Enquiry',
        'route' => 'frontend.enquiry',
    ],
    [
        'label' => 'Contact Us',
        'route' => 'frontend.contact',
    ],

    /* [
        'label' => 'Pages',
        'route' => null,
        'children' => [
            ['label' => 'About Page',           'url' => 'about.html'],
            ['label' => 'Cart Page',            'url' => 'cart.html'],
            ['label' => 'Checkout Page',        'url' => 'checkout.html'],
            ['label' => 'Compare Page',         'url' => 'compare.html'],
            ['label' => 'Login & Register',     'url' => 'login.html'],
            ['label' => 'Account Page',         'url' => 'my-account.html'],
            ['label' => 'Empty Cart',           'url' => 'empty-cart.html'],
            ['label' => '404 Page',             'url' => '404.html'],
            ['label' => 'Privacy Policy',       'url' => 'privacy-policy.html'],
            ['label' => 'FAQ Page',             'url' => 'faq.html'],
            ['label' => 'Coming Soon',          'url' => 'coming-soon.html'],
            ['label' => 'Wishlist',             'url' => 'wishlist.html'],
        ]
    ], */
];
