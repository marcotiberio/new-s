<?php

use ACFComposer\ACFComposer;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'postMeta',
        'title' => 'Blog Info',
        'style' => '',
        'menu_order' => 1,
        'position' => 'acf_after_title',
        'fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Intro', 'flynt'),
                'name' => 'postIntro',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'width' => 100,
                ]
            ],
            [
                'label' => __('Custom Text', 'flynt'),
                'name' => 'postCustomText',
                'type' => 'text',
                'wrapper' => [
                    'width' => 100,
                ]
            ],
            [
                'label' => __('Media', 'flynt'),
                'name' => 'mediaTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Featured Image (Alternative)', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG.', 'flynt'),
                'name' => 'featImageAlt',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png',
                'wrapper' => [
                    'width' => 33,
                ],
            ],
            [
                'label' => __('Featured Video', 'flynt'),
                'instructions' => __('Video-Format: MP4, MOV.', 'flynt'),
                'name' => 'featVideo',
                'type' => 'file',
                'preview_size' => 'medium',
                'mime_types' => 'mp4,mov',
                'wrapper' => [
                    'width' => 33,
                ],
            ],
            [
                'label' => __('Featured Video Embed', 'flynt'),
                'name' => 'featVideoEmbed',
                'type' => 'oembed',
            ],
            [
                'label' => __('Project Overview Image', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG.', 'flynt'),
                'name' => 'projectOverviewImage',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png',
                'wrapper' => [
                    'width' => 33,
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ],
            ],
        ],
    ]);
    // ACFComposer::registerFieldGroup([
    //     'name' => 'postMedia',
    //     'title' => 'Featured Media',
    //     'style' => '',
    //     'menu_order' => 1,
    //     'position' => 'side',
    //     'fields' => [
            
    //     ],
    //     'location' => [
    //         [
    //             [
    //                 'param' => 'post_type',
    //                 'operator' => '==',
    //                 'value' => 'post',
    //             ],
    //         ],
    //     ],
    // ]);
    ACFComposer::registerFieldGroup([
        'name' => 'postComponents',
        'title' => __('Post Components', 'flynt'),
        'style' => 'seamless',
        'fields' => [
            [
                'name' => 'postComponents',
                'label' => __('Post Components', 'flynt'),
                'type' => 'flexible_content',
                'button_label' => __('Add Component', 'flynt'),
                'layouts' => [
                    Components\BlockAnchor\getACFLayout(),
                    Components\BlockImageTest2\getACFLayout(),
                    Components\BlockGalleryMedia\getACFLayout(),
                    Components\BlockWysiwygColumns\getACFLayout(),
                    Components\ListingProjectsRelated\getACFLayout(),
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ],
            ],
        ],
    ]);
});
