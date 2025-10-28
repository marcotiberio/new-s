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
        'label' => __('Media', 'flynt'),
        'name' => 'mediaTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Logo', 'flynt'),
        'instructions' => __('Image-Format: JPG, PNG, SVG', 'flynt'),
        'name' => 'logoFooter',
        'type' => 'image',
        'preview_size' => 'full',
        'mime_types' => 'jpg,jpeg,png,svg,webp',
        'wrapper' => [
            'width' => 100
        ],
    ],
    [
        'label' => __('Content', 'flynt'),
        'name' => 'contentTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Columns', 'flynt'),
        'name' => 'columns',
        'type' => 'repeater',
        'layout' => 'block',
        'min' => 1,
        'max' => 4,
        'button_label' => __('Add Column', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Text starts in column:', 'flynt'),
                'name' => 'colStart',
                'type' => 'button_group',
                'choices' => [
                    'col-start-1 lg:col-start-1' => sprintf('<p>1</p>', __('1', 'flynt')),
                    'col-start-1 lg:col-start-2' => sprintf('<p>2</p>', __('2', 'flynt')),
                    'col-start-1 lg:col-start-3' => sprintf('<p>3</p>', __('3', 'flynt')),
                    'col-start-1 lg:col-start-4' => sprintf('<p>4</p>', __('4', 'flynt')),
                    'col-start-1 lg:col-start-5' => sprintf('<p>5</p>', __('5', 'flynt')),
                    'col-start-1 lg:col-start-6' => sprintf('<p>6</p>', __('6', 'flynt')),
                    'col-start-1 lg:col-start-7' => sprintf('<p>7</p>', __('7', 'flynt')),
                    'col-start-1 lg:col-start-8' => sprintf('<p>8</p>', __('8', 'flynt')),
                    'col-start-1 lg:col-start-9' => sprintf('<p>9</p>', __('9', 'flynt')),
                    'col-start-1 lg:col-start-10' => sprintf('<p>10</p>', __('10', 'flynt')),
                    'col-start-1 lg:col-start-11' => sprintf('<p>11</p>', __('11', 'flynt')),
                    'col-start-1 lg:col-start-12' => sprintf('<p>12</p>', __('12', 'flynt'))
                ],
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Text ends in column:', 'flynt'),
                'name' => 'colEnd',
                'type' => 'button_group',
                'choices' => [
                    'col-end-4 lg:col-end-2' => sprintf('<p>2</p>', __('2', 'flynt')),
                    'col-end-4 lg:col-end-3' => sprintf('<p>3</p>', __('3', 'flynt')),
                    'col-end-4 lg:col-end-4' => sprintf('<p>4</p>', __('4', 'flynt')),
                    'col-end-4 lg:col-end-5' => sprintf('<p>5</p>', __('5', 'flynt')),
                    'col-end-4 lg:col-end-6' => sprintf('<p>6</p>', __('6', 'flynt')),
                    'col-end-4 lg:col-end-7' => sprintf('<p>7</p>', __('7', 'flynt')),
                    'col-end-4 lg:col-end-8' => sprintf('<p>8</p>', __('8', 'flynt')),
                    'col-end-4 lg:col-end-9' => sprintf('<p>9</p>', __('9', 'flynt')),
                    'col-end-4 lg:col-end-10' => sprintf('<p>10</p>', __('10', 'flynt')),
                    'col-end-4 lg:col-end-11' => sprintf('<p>11</p>', __('11', 'flynt')),
                    'col-end-4 lg:col-end-12' => sprintf('<p>12</p>', __('12', 'flynt')),
                    'col-end-4 lg:col-end-13' => sprintf('<p>13</p>', __('13', 'flynt')),
                ],
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 0,
                'wrapper' => [
                    'width' => 100
                ],
            ],
            [
                'label' => __('Enable Newsletter Form', 'flynt'),
                'name' => 'enableNewsletter',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
                'wrapper' => [
                    'width' => 50
                ],
            ],
        ]
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
