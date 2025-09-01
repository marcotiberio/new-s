<?php

namespace Flynt\Components\HeroHeaderHome;

use Flynt\FieldVariables;
use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Timber\Timber;

add_action('init', function () {
    register_nav_menus([
        'navigation_main' => __('Navigation Main', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=HeroHeaderHome', function ($data) {
    $data['menu'] = Timber::get_menu('navigation_main') ?? Timber::get_pages_menu();
    $data['logo'] = [
        'src' => get_theme_mod('custom_header_logo') ? get_theme_mod('custom_header_logo') : Asset::requireUrl('assets/images/logo.svg'),
        'alt' => get_bloginfo('name')
    ];

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'heroHeaderHome',
        'label' => __('Hero Home', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Image', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Image', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG, SVG.', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 1,
                'mime_types' => 'jpg,jpeg,png,svg'
            ],
            [
                'label' => __('Logo', 'flynt'),
                'name' => 'logoTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Logo', 'flynt'),
                'instructions' => __('Image-Format: PNG, SVG', 'flynt'),
                'name' => 'logoHeader',
                'type' => 'image',
                'preview_size' => 'full',
                'mime_types' => 'png,svg',
                'wrapper' => [
                    'width' => 100
                ],
            ],
        ]

    ];
}
    
