<?php

namespace Flynt\Components\HeroHeaderHome;

use Flynt\FieldVariables;

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
    
