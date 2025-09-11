<?php

namespace Flynt\Components\NavigationFooter;

use Flynt\Utils\Options;
use Flynt\Shortcodes;
use Timber\Timber;

add_action('init', function () {
    register_nav_menus([
        'navigation_footer' => __('Navigation Footer', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationFooter', function ($data) {
    $data['maxLevel'] = 0;
    $data['menu'] = Timber::get_menu('navigation_footer') ?? Timber::get_pages_menu();

    return $data;
});


Options::addTranslatable('NavigationFooter', [
    // [
    //     'label' => __('CTA', 'flynt'),
    //     'name' => 'ctaTab',
    //     'type' => 'tab',
    //     'placement' => 'top',
    //     'endpoint' => 0
    // ],
    // [
    //     'label' => __('CTA Link', 'flynt'),
    //     'name' => 'ctaMenuItem',
    //     'type' => 'link',
    //     'return_format' => 'array',
    //     'wrapper' =>  [
    //         'width' => '100',
    //     ]
    // ],
    [
        'label' => __('Logo', 'flynt'),
        'instructions' => __('Image-Format: JPG, PNG, SVG', 'flynt'),
        'name' => 'logoFooter',
        'type' => 'image',
        'preview_size' => 'full',
        'mime_types' => 'jpg,jpeg,png,svg',
        'wrapper' => [
            'width' => 100
        ],
    ],
    // [
    //     'label' => __('Newsletter', 'flynt'),
    //     'name' => 'newsletterTab',
    //     'type' => 'tab',
    //     'placement' => 'top',
    //     'endpoint' => 0
    // ],
    // [
    //     'label' => __('Newsletter Link', 'flynt'),
    //     'name' => 'newsletterLink',
    //     'type' => 'link',
    //     'required' => 0,
    //     'wrapper' => [
    //         'width' => 100
    //     ],
    // ],
    [
        'label' => __('Labels', 'flynt'),
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('Aria Label', 'flynt'),
                'name' => 'ariaLabel',
                'type' => 'text',
                'default_value' => __('Footer', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
