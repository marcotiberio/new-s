<?php

use ACFComposer\ACFComposer;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'journalMeta',
        'title' => 'Main Content',
        'style' => '',
        'menu_order' => 1,
        'position' => 'acf_after_title',
        'fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => 'Date (Required)',
                'instructions' => '',
                'required' => 1,
                'name' => 'end_date',
                'type' => 'date_picker',
                'display_format' => 'd.m.y',
                'return_format' => 'd.m.y',
                'first_day' => 1,
                'wrapper' => [
                    'width' => 100,
                ]
            ],
            [
                'label' => __('Author', 'flynt'),
                'name' => 'postAuthor',
                'type' => 'text',
                'wrapper' => [
                    'width' => 100,
                ]
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'postContent',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'width' => 100,
                ]
            ],
            // [
            //     'label' => __('Main Text', 'flynt'),
            //     'name' => 'maintextTab',
            //     'type' => 'tab',
            //     'placement' => 'top',
            //     'endpoint' => 0,
            // ],
            // [
            //     'label' => __('Main Text', 'flynt'),
            //     'name' => 'mainText',
            //     'type' => 'wysiwyg',
            //     'tabs' => 'visual',
            //     'media_upload' => 0,
            //     'delay' => 1,
            //     'wrapper' => [
            //         'width' => 100,
            //     ]
            // ],
            // [
            //     'label' => 'Start (Optional)',
            //     'instructions' => '',
            //     'name' => 'start_date',
            //     'type' => 'date_picker',
            //     'display_format' => 'F j, Y',
            //     'return_format' => 'Ymd',
            //     'first_day' => 1,
            // ],
            // [
            //     'label' => 'Time',
            //     'name' => 'eventTime',
            //     'type' => 'time_picker',
            //     'display_format' => 'g:i a',
            //     'return_format' => 'g:i a',
            //     'wrapper' => [
            //         'width' => 50,
            //     ]
            // ],
            // [
            //     'label' => 'Time',
            //     'name' => 'eventTime',
            //     'type' => 'text',
            //     'wrapper' => [
            //         'width' => 50,
            //     ]
            // ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'journal',
                ],
            ],
        ],
    ]);
    ACFComposer::registerFieldGroup([
        'name' => 'postMedia',
        'title' => 'Featured Media',
        'style' => '',
        'menu_order' => 1,
        'position' => 'side',
        'fields' => [
            [
                'label' => __('Featured Image (Alternative)', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG.', 'flynt'),
                'name' => 'featImageAlt',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png'
            ],
            [
                'label' => __('Featured Video', 'flynt'),
                'instructions' => __('Video-Format: MP4, MOV.', 'flynt'),
                'name' => 'featVideo',
                'type' => 'file',
                'preview_size' => 'medium',
                'mime_types' => 'mp4,mov'
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'journal',
                ],
            ],
        ],
    ]);
    // ACFComposer::registerFieldGroup([
    //     'name' => 'journalComponents',
    //     'title' => __('Journal Components', 'flynt'),
    //     'style' => 'seamless',
    //     'fields' => [
    //         [
    //             'name' => 'journalComponents',
    //             'label' => __('Journal Components', 'flynt'),
    //             'type' => 'flexible_content',
    //             'button_label' => __('Add Component', 'flynt'),
    //             'layouts' => [
    //                 Components\BlockAnchor\getACFLayout(),
    //                 Components\BlockBannerCta\getACFLayout(),
    //                 Components\BlockCollapse\getACFLayout(),
    //                 Components\BlockImage\getACFLayout(),
    //                 Components\BlockImageText\getACFLayout(),
    //                 Components\BlockVideoOembed\getACFLayout(),
    //                 Components\BlockWysiwyg\getACFLayout(),
    //                 Components\BlockWysiwygTwoCol\getACFLayout(),
    //                 Components\ListingBlog\getACFLayout(),
    //                 Components\GridVideos\getACFLayout(),
    //                 Components\ListingEvents\getACFLayout(),
    //                 Components\SliderBox\getACFLayout(),
    //                 Components\SliderHorizontal\getACFLayout(),
    //                 Components\SliderImages\getACFLayout(),
    //             ],
    //         ],
    //     ],
    //     'location' => [
    //         [
    //             [
    //                 'param' => 'post_type',
    //                 'operator' => '==',
    //                 'value' => 'event',
    //             ],
    //         ],
    //     ],
    // ]);
});
