<?php

use ACFComposer\ACFComposer;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'pageMeta',
        'title' => 'Page Meta',
        'style' => '',
        'fields' => [
            [
                'label' => __('Page Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            // [
            //     'label' => __('Page Background', 'flynt'),
            //     'name' => 'pageBackground',
            //     'type' => 'color_picker',
            //     'default' => '#000',
            //     'required' => 0
            // ],
            [
                'label' => __('Page Background Color', 'flynt'),
                'name' => 'pageBackgroundCustom',
                'type' => 'select',
                'choices' => [
                    'bg-white' => 'White',
                    'bg-orange' => 'Orange',
                ],
                'default_value' => 'bg-white',
                'required' => 0
            ],
            [
                'label' => 'CTA Button',
                'name' => 'ctaButton',
                'type' => 'link',
                'return_format' => 'array',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page'
                ]
                ],
        ],
        'menu_order' => 0,
        'position' => 'side',
    ]);
    ACFComposer::registerFieldGroup([
        'name' => 'pageComponents',
        'title' => __('Page Components', 'flynt'),
        'style' => 'seamless',
        'fields' => [
            [
                'name' => 'pageComponents',
                'label' => __('Page Components', 'flynt'),
                'type' => 'flexible_content',
                'button_label' => __('Add Component', 'flynt'),
                'layouts' => [
                    Components\BlockAnchor\getACFLayout(),
                    // Components\BlockBannerCta\getACFLayout(),
                    // Components\BannerContactForm\getACFLayout(),
                    // Components\BannerImageText\getACFLayout(),
                    // Components\BlockCollapse\getACFLayout(),
                    // Components\BlockContactForm\getACFLayout(),
                    // Components\BlockCta\getACFLayout(),
                    Components\BlockDivider\getACFLayout(),
                    Components\BlockImage\getACFLayout(),
                    // Components\BlockImageText\getACFLayout(),
                    // Components\BlockImageTextMultiple\getACFLayout(),
                    // Components\BlockMultipleBoxesLink\getACFLayout(),
                    // Components\BlockMultipleBoxes\getACFLayout(),
                    // Components\BlockMultipleBoxesSimple\getACFLayout(),
                    // Components\BlockNewsletter\getACFLayout(),
                    // Components\BlockPdfDownload\getACFLayout(),
                    // Components\BlockProgramm\getACFLayout(),
                    // Components\BlockVideoOembed\getACFLayout(),
                    Components\BlockGalleryMedia\getACFLayout(),
                    // Components\BlockVideoText\getACFLayout(),
                    // Components\BlockWysiwyg\getACFLayout(),
                    Components\BlockWysiwygColumns\getACFLayout(),
                    // Components\BlockWysiwygTwoCol\getACFLayout(),
                    // Components\GridLogos\getACFLayout(),
                    // Components\GridImageText\getACFLayout(),
                    // Components\GridImages\getACFLayout(),
                    // Components\GridPostSelector\getACFLayout(),
                    // Components\GridPostSpeakers\getACFLayout(),
                    // Components\GridVideos\getACFLayout(),
                    Components\HeroHeaderHome\getACFLayout(),
                    // Components\HeroImageText\getACFLayout(),
                    // Components\HeroVideoBackground\getACFLayout(),
                    // Components\HeroSlider\getACFLayout(),
                    // Components\HeroSliderComposite\getACFLayout(),
                    // Components\ListTextLink\getACFLayout(),
                    // Components\ListingEvents\getACFLayout(),
                    // Components\ListingEventsFeat\getACFLayout(),
                    Components\ListingJournal\getACFLayout(),
                    Components\ListingJournalFeat\getACFLayout(),
                    // Components\ListingLernen\getACFLayout(),
                    Components\ListingProjects\getACFLayout(),
                    Components\ListingProjectsFeat\getACFLayout(),
                    // Components\SliderBox\getACFLayout(),
                    // Components\SliderBoxText\getACFLayout(),
                    // Components\SliderLogos\getACFLayout(),
                    Components\BlockSliderLogos\getACFLayout(),
                    // Components\SliderHorizontal\getACFLayout(),
                    // Components\SliderImages\getACFLayout(),
                    // Components\SliderQuotes\getACFLayout(),
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'post'
                ],
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'journal'
                ],
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'reusable-components'
                ],
            ],
        ],
    ]);
});
