<?php

namespace Flynt\Components\ListingHandbook;

use Flynt\FieldVariables;
use Flynt\Handbook;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=ListingHandbook', function ($data) {
    $data['tree'] = Handbook\getTree();
    $data['cta'] = Options::getTranslatable('Handbook');
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'ListingHandbook',
        'label' => 'Listing Handbook',
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'label' => __('Intro', 'flynt'),
                'instructions' => __('One or two sentences: what the handbook covers and who publishes it. Also used in structured data.', 'flynt'),
                'name' => 'intro',
                'type' => 'textarea',
                'rows' => 3,
                'new_lines' => '',
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getColorBackground(),
                    FieldVariables\getColorText(),
                ]
            ]
        ],
    ];
}
