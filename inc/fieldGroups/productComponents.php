<?php

use ACFComposer\ACFComposer;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'productComponents',
        'title' => __('Product Components', 'flynt'),
        'style' => 'seamless',
        'fields' => [
            [
                'name' => 'productComponents',
                'label' => __('Product Components', 'flynt'),
                'type' => 'flexible_content',
                'button_label' => __('Add Component', 'flynt'),
                'layouts' => [
                    Components\BlockAnchor\getACFLayout(),
                    Components\BlockImageTest2\getACFLayout(),
                    Components\BlockGalleryMedia\getACFLayout(),
                    Components\BlockSpacer\getACFLayout(),
                    Components\BlockWysiwygColumns\getACFLayout(),
                    Components\BlockWysiwygAccordion\getACFLayout(),
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ],
            ],
        ],
    ]);
});
