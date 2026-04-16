<?php

/**
 * Moves most relevant editor buttons to the first toolbar
 * and provides config for creating new toolbars, block formats, and style formats.
 * See the TinyMce documentation for more information: https://www.tiny.cloud/docs/
 *
 */

namespace Flynt\TinyMce;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;

// Add tinyMce styles to editor
add_action('admin_init', function () {
    add_editor_style(Asset::requireUrl('assets/tinymce.scss'));
});

// First Toolbar
add_filter('mce_buttons', function ($buttons) {
    $config = getConfig();
    if ($config && isset($config['toolbars'])) {
        $toolbars = $config['toolbars'];
        if (isset($toolbars['default']) && isset($toolbars['default'][0])) {
            return $toolbars['default'][0];
        }
    }
    return $buttons;
});

// Second Toolbar
add_filter('mce_buttons_2', '__return_empty_array');

add_filter('tiny_mce_before_init', function ($init) {
    $config = getConfig();
    if ($config) {
        if (isset($config['blockformats'])) {
            $init['block_formats'] = getBlockFormats($config['blockformats']);
        }

        if (isset($config['styleformats'])) {
            // Send it to style_formats as true js array
            $init['style_formats'] = json_encode($config['styleformats']);
        }

        if (isset($config['textcolor_map'])) {
            // Send it to textcolor_map as true js array
            $init['textcolor_map'] = json_encode($config['textcolor_map']);
        }
    }
    
    // Get typography options from backend
    $typographyOptions = Options::getGlobal('Typography');
    $fontLoadingMethod = !empty($typographyOptions['fontLoadingMethod']) 
        ? $typographyOptions['fontLoadingMethod'] 
        : 'local';
    
    // Build CSS to inject into TinyMCE iframe
    $contentStyle = '';
    
    // Add CSS variables for typography
    $primaryFont = !empty($typographyOptions['primaryFontFamily']) 
        ? esc_attr($typographyOptions['primaryFontFamily']) 
        : 'FKGroteskNeue';
    $primaryFontFallback = !empty($typographyOptions['primaryFontFallback']) 
        ? esc_attr($typographyOptions['primaryFontFallback']) 
        : 'Arial, sans-serif';
    $baseFontSizeMobile = !empty($typographyOptions['baseFontSizeMobile']) 
        ? floatval($typographyOptions['baseFontSizeMobile']) 
        : 14;
    $baseFontSizeDesktop = !empty($typographyOptions['baseFontSizeDesktop']) 
        ? floatval($typographyOptions['baseFontSizeDesktop']) 
        : 16;
    $h1SizeMobile = !empty($typographyOptions['h1SizeMobile']) 
        ? floatval($typographyOptions['h1SizeMobile']) 
        : 2.25;
    $h1SizeDesktop = !empty($typographyOptions['h1SizeDesktop']) 
        ? floatval($typographyOptions['h1SizeDesktop']) 
        : 3.25;
    $h2SizeMobile = !empty($typographyOptions['h2SizeMobile']) 
        ? floatval($typographyOptions['h2SizeMobile']) 
        : 1.75;
    $h2SizeDesktop = !empty($typographyOptions['h2SizeDesktop']) 
        ? floatval($typographyOptions['h2SizeDesktop']) 
        : 2;
    $bodySizeMobile = !empty($typographyOptions['bodySizeMobile']) 
        ? floatval($typographyOptions['bodySizeMobile']) 
        : 1.25;
    $bodySizeDesktop = !empty($typographyOptions['bodySizeDesktop']) 
        ? floatval($typographyOptions['bodySizeDesktop']) 
        : 1.25;
    $bodySmallSize = !empty($typographyOptions['bodySmallSize']) 
        ? floatval($typographyOptions['bodySmallSize']) 
        : 0.75;
    $menuSize = !empty($typographyOptions['menuSize']) 
        ? floatval($typographyOptions['menuSize']) 
        : 1;
    $h1LineHeight = !empty($typographyOptions['h1LineHeight']) 
        ? floatval($typographyOptions['h1LineHeight']) 
        : 1.2;
    $h2LineHeight = !empty($typographyOptions['h2LineHeight']) 
        ? floatval($typographyOptions['h2LineHeight']) 
        : 1.2;
    $bodyLineHeight = !empty($typographyOptions['bodyLineHeight']) 
        ? floatval($typographyOptions['bodyLineHeight']) 
        : 1.2;
    $bodySmallLineHeight = !empty($typographyOptions['bodySmallLineHeight']) 
        ? floatval($typographyOptions['bodySmallLineHeight']) 
        : 1.2;
    $menuLineHeight = !empty($typographyOptions['menuLineHeight']) 
        ? floatval($typographyOptions['menuLineHeight']) 
        : 1.2;
    $h1FontWeight = !empty($typographyOptions['h1FontWeight']) 
        ? intval($typographyOptions['h1FontWeight']) 
        : 400;
    $h2FontWeight = !empty($typographyOptions['h2FontWeight']) 
        ? intval($typographyOptions['h2FontWeight']) 
        : 400;
    $bodyFontWeight = !empty($typographyOptions['bodyFontWeight']) 
        ? intval($typographyOptions['bodyFontWeight']) 
        : 400;
    $bodySmallFontWeight = !empty($typographyOptions['bodySmallFontWeight']) 
        ? intval($typographyOptions['bodySmallFontWeight']) 
        : 400;
    $menuFontWeight = !empty($typographyOptions['menuFontWeight']) 
        ? intval($typographyOptions['menuFontWeight']) 
        : 400;
    
    // Build CSS variables
    $contentStyle .= ":root {";
    $contentStyle .= " --primary-font-family: '{$primaryFont}', {$primaryFontFallback};";
    $contentStyle .= " --base-font-size-mobile: {$baseFontSizeMobile}px;";
    $contentStyle .= " --base-font-size-desktop: {$baseFontSizeDesktop}px;";
    $contentStyle .= " --h1-size-mobile: {$h1SizeMobile}rem;";
    $contentStyle .= " --h1-size-desktop: {$h1SizeDesktop}rem;";
    $contentStyle .= " --h1-line-height: {$h1LineHeight};";
    $contentStyle .= " --h1-font-weight: {$h1FontWeight};";
    $contentStyle .= " --h2-size-mobile: {$h2SizeMobile}rem;";
    $contentStyle .= " --h2-size-desktop: {$h2SizeDesktop}rem;";
    $contentStyle .= " --h2-line-height: {$h2LineHeight};";
    $contentStyle .= " --h2-font-weight: {$h2FontWeight};";
    $contentStyle .= " --body-size-mobile: {$bodySizeMobile}rem;";
    $contentStyle .= " --body-size-desktop: {$bodySizeDesktop}rem;";
    $contentStyle .= " --body-line-height: {$bodyLineHeight};";
    $contentStyle .= " --body-font-weight: {$bodyFontWeight};";
    $contentStyle .= " --body-small-size: {$bodySmallSize}rem;";
    $contentStyle .= " --body-small-line-height: {$bodySmallLineHeight};";
    $contentStyle .= " --body-small-font-weight: {$bodySmallFontWeight};";
    $contentStyle .= " --menu-size: {$menuSize}rem;";
    $contentStyle .= " --menu-line-height: {$menuLineHeight};";
    $contentStyle .= " --menu-font-weight: {$menuFontWeight};";
    $contentStyle .= " }";
    
    // Add font-face declaration for local fonts
    if ($fontLoadingMethod === 'local') {
        $fontUrl = get_template_directory_uri() . '/assets/fonts/FKGroteskNeue-Regular.woff2';
        $contentStyle .= " @font-face { font-display: swap; font-family: '{$primaryFont}'; font-style: normal; font-weight: 400; src: url('" . esc_url($fontUrl) . "') format('woff2'); }";
        $fontMediumUrl = get_template_directory_uri() . '/assets/fonts/FKGroteskNeue-Medium.woff2';
        $contentStyle .= " @font-face { font-display: swap; font-family: '{$primaryFont}'; font-style: normal; font-weight: 500; src: url('" . esc_url($fontMediumUrl) . "') format('woff2'); }";
    }
    
    // Add Google Fonts import if using Google Fonts
    if ($fontLoadingMethod === 'google') {
        $googleFontsUrl = !empty($typographyOptions['googleFontsUrl']) 
            ? esc_url($typographyOptions['googleFontsUrl']) 
            : '';
        if (!empty($googleFontsUrl)) {
            $contentStyle .= " @import url('{$googleFontsUrl}');";
        }
    }
    
    // Append to existing content_style or set it
    if (isset($init['content_style'])) {
        $init['content_style'] .= ' ' . $contentStyle;
    } else {
        $init['content_style'] = $contentStyle;
    }
    
    return $init;
});

add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
    // Load Toolbars and parse them into TinyMCE
    $config = getConfig();
    if ($config && !empty($config['toolbars'])) {
        $toolbars = array_map(function ($toolbar) {
            array_unshift($toolbar, []);
            return $toolbar;
        }, $config['toolbars']);
    }
    return $toolbars;
});

function getBlockFormats($blockFormats)
{
    if (!empty($blockFormats)) {
        $blockFormatStrings = array_map(
            function ($tag, $label) {
                return "${label}=${tag}";
            },
            $blockFormats,
            array_keys($blockFormats)
        );
        return implode(';', $blockFormatStrings);
    }
    return '';
}

function getConfig()
{
    return [
        'textcolor_map' => [
            '000000', 'Black',
            'ffffff', 'White',
            'fe4400', 'Orange',
        ],
        'blockformats' => [
            'Heading 1' => 'h1',
            'Heading 2' => 'h2',
            'Paragraph' => 'p',
            'Small Text' => 'samp',
        ],
        'styleformats' => [
            // [
            //     'title' => 'Headings',
            //     'icon' => '',
            //     'items' => [
            //         [
            //             'title' => 'Title',
            //             'classes' => 'font-heroTitle',
            //             'selector' => '*'
            //         ],
            //         [
            //             'title' => 'Subtitle',
            //             'classes' => 'font-heroSubtitle',
            //             'selector' => '*'
            //         ],
            //         [
            //             'title' => 'Heading 3',
            //             'classes' => 'h3',
            //             'selector' => '*'
            //         ],
            //         [
            //             'title' => 'Heading 4',
            //             'classes' => 'h4',
            //             'selector' => '*'
            //         ],
            //     ]
            // ],
            [
                'title' => 'Text',
                'icon' => '',
                'items' => [
                    [
                        'title' => 'Regular',
                        'classes' => 'font-body',
                        'selector' => '*'
                    ],
                    [
                        'title' => 'Small',
                        'classes' => 'font-bodySmall',
                        'selector' => '*'
                    ],
                ]
            ],
            [
                'title' => 'Buttons/Links',
                'icon' => '',
                'items' => [
                    [
                        'title' => 'Button Outline',
                        'classes' => 'button button--outline',
                        'selector' => 'a'
                    ],
                    [
                        'title' => 'Link No Arrow',
                        'classes' => 'link-NoArrow',
                        'selector' => 'a'
                    ],
                ]
            ],
        ],
        'toolbars' => [
            'default' => [
                [
                    'formatselect',
                    'styleselect',
                    'bold',
                    'italic',
                    'blockquote',
                    'forecolor',
                    '|',
                    'alignleft',
                    'aligncenter',
                    'alignright',
                    'alignjustify',
                    '|',
                    'hr',
                    '|',
                    'bullist',
                    'numlist',
                    '|',
                    'link',
                    'unlink',
                    '|',
                    'removeformat'
                ]
            ],
            'basic' => [
                [
                    'formatselect',
                    'styleselect',
                    'bold',
                    'italic',
                    'blockquote',
                    'forecolor',
                    '|',
                    'alignleft',
                    'aligncenter',
                    'alignright',
                    'alignjustify',
                    '|',
                    'hr',
                    '|',
                    'bullist',
                    'numlist',
                    '|',
                    'link',
                    'unlink',
                    '|',
                    'removeformat'
                ]
            ]
        ]
    ];
}
