<?php

namespace Flynt\Colors;

use Flynt\Utils\Options;

add_action('acf/init', function () {
    // Add Color fields to Global Options
    Options::addGlobal('Colors', [
        // Primary Colors
        [
            'label' => __('Black', 'flynt'),
            'instructions' => __('Primary black color (e.g., #000000).', 'flynt'),
            'name' => 'colorBlack',
            'type' => 'color_picker',
            'default_value' => '#000000',
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('White', 'flynt'),
            'instructions' => __('Primary white color (e.g., #ffffff).', 'flynt'),
            'name' => 'colorWhite',
            'type' => 'color_picker',
            'default_value' => '#ffffff',
            'wrapper' => [
                'width' => 50,
            ],
        ],
        // Brand Colors
        [
            'label' => __('Orange', 'flynt'),
            'instructions' => __('Primary orange color (e.g., #fa642e).', 'flynt'),
            'name' => 'colorOrange',
            'type' => 'color_picker',
            'default_value' => '#fa642e',
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Orange Hover', 'flynt'),
            'instructions' => __('Orange color for hover states (e.g., #fe4400).', 'flynt'),
            'name' => 'colorOrangeHover',
            'type' => 'color_picker',
            'default_value' => '#fe4400',
            'wrapper' => [
                'width' => 50,
            ],
        ],
        // [
        //     'label' => __('Yellow', 'flynt'),
        //     'instructions' => __('Yellow color (e.g., #ffdd47).', 'flynt'),
        //     'name' => 'colorYellow',
        //     'type' => 'color_picker',
        //     'default_value' => '#ffdd47',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Green', 'flynt'),
        //     'instructions' => __('Green color (e.g., #7bdb8f).', 'flynt'),
        //     'name' => 'colorGreen',
        //     'type' => 'color_picker',
        //     'default_value' => '#7bdb8f',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Blue', 'flynt'),
        //     'instructions' => __('Blue color (e.g., #6690ff).', 'flynt'),
        //     'name' => 'colorBlue',
        //     'type' => 'color_picker',
        //     'default_value' => '#6690ff',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Light Blue', 'flynt'),
        //     'instructions' => __('Light blue color (e.g., #b1d1e4).', 'flynt'),
        //     'name' => 'colorLightBlue',
        //     'type' => 'color_picker',
        //     'default_value' => '#b1d1e4',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Acqua', 'flynt'),
        //     'instructions' => __('Acqua/cyan color (e.g., #51bad9).', 'flynt'),
        //     'name' => 'colorAcqua',
        //     'type' => 'color_picker',
        //     'default_value' => '#51bad9',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Beige', 'flynt'),
        //     'instructions' => __('Beige color (e.g., #f6f4ca).', 'flynt'),
        //     'name' => 'colorBeige',
        //     'type' => 'color_picker',
        //     'default_value' => '#f6f4ca',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Grey', 'flynt'),
        //     'instructions' => __('Light grey color (e.g., #f9f9f9).', 'flynt'),
        //     'name' => 'colorGrey',
        //     'type' => 'color_picker',
        //     'default_value' => '#f9f9f9',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Dark Grey', 'flynt'),
        //     'instructions' => __('Dark grey color (e.g., #28321E).', 'flynt'),
        //     'name' => 'colorDarkGrey',
        //     'type' => 'color_picker',
        //     'default_value' => '#28321E',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Azul Grey', 'flynt'),
        //     'instructions' => __('Azul grey color (e.g., #e6ecee).', 'flynt'),
        //     'name' => 'colorAzulGrey',
        //     'type' => 'color_picker',
        //     'default_value' => '#e6ecee',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // // Category Colors
        // [
        //     'label' => __('Blog Color', 'flynt'),
        //     'instructions' => __('Color for blog category (e.g., #7bdb8f).', 'flynt'),
        //     'name' => 'colorBlog',
        //     'type' => 'color_picker',
        //     'default_value' => '#7bdb8f',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Event Color', 'flynt'),
        //     'instructions' => __('Color for event category (e.g., #6690ff).', 'flynt'),
        //     'name' => 'colorEvent',
        //     'type' => 'color_picker',
        //     'default_value' => '#6690ff',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Lernen Color', 'flynt'),
        //     'instructions' => __('Color for lernen category (e.g., #ff904f).', 'flynt'),
        //     'name' => 'colorLernen',
        //     'type' => 'color_picker',
        //     'default_value' => '#ff904f',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // // Semantic Colors
        // [
        //     'label' => __('Text Color', 'flynt'),
        //     'instructions' => __('Default text color for body content.', 'flynt'),
        //     'name' => 'colorText',
        //     'type' => 'color_picker',
        //     'default_value' => '#000000',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Text Muted', 'flynt'),
        //     'instructions' => __('Muted/secondary text color.', 'flynt'),
        //     'name' => 'colorTextMuted',
        //     'type' => 'color_picker',
        //     'default_value' => '#666666',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Background Color', 'flynt'),
        //     'instructions' => __('Default background color.', 'flynt'),
        //     'name' => 'colorBackground',
        //     'type' => 'color_picker',
        //     'default_value' => '#ffffff',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Background Secondary', 'flynt'),
        //     'instructions' => __('Secondary background color for contrast.', 'flynt'),
        //     'name' => 'colorBackgroundSecondary',
        //     'type' => 'color_picker',
        //     'default_value' => '#f5f5f5',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Accent Color', 'flynt'),
        //     'instructions' => __('Accent color for highlights, links, buttons.', 'flynt'),
        //     'name' => 'colorAccent',
        //     'type' => 'color_picker',
        //     'default_value' => '#fa642e',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Border Color', 'flynt'),
        //     'instructions' => __('Default border color.', 'flynt'),
        //     'name' => 'colorBorder',
        //     'type' => 'color_picker',
        //     'default_value' => '#e0e0e0',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
        // [
        //     'label' => __('Error Color', 'flynt'),
        //     'instructions' => __('Error/warning color for form validation.', 'flynt'),
        //     'name' => 'colorError',
        //     'type' => 'color_picker',
        //     'default_value' => '#dc3545',
        //     'wrapper' => [
        //         'width' => 50,
        //     ],
        // ],
    ], 'Colors');
});

// Output dynamic CSS variables based on ACF options
add_action('wp_head', function () {
    $colorOptions = Options::getGlobal('Colors');
    
    // Get values with fallbacks
    $black = !empty($colorOptions['colorBlack']) 
        ? esc_attr($colorOptions['colorBlack']) 
        : '#000000';
    $white = !empty($colorOptions['colorWhite']) 
        ? esc_attr($colorOptions['colorWhite']) 
        : '#ffffff';
    $orange = !empty($colorOptions['colorOrange']) 
        ? esc_attr($colorOptions['colorOrange']) 
        : '#fa642e';
    $orangeHover = !empty($colorOptions['colorOrangeHover']) 
        ? esc_attr($colorOptions['colorOrangeHover']) 
        : '#fe4400';
    $yellow = !empty($colorOptions['colorYellow']) 
        ? esc_attr($colorOptions['colorYellow']) 
        : '#ffdd47';
    $green = !empty($colorOptions['colorGreen']) 
        ? esc_attr($colorOptions['colorGreen']) 
        : '#7bdb8f';
    $blue = !empty($colorOptions['colorBlue']) 
        ? esc_attr($colorOptions['colorBlue']) 
        : '#6690ff';
    $lightBlue = !empty($colorOptions['colorLightBlue']) 
        ? esc_attr($colorOptions['colorLightBlue']) 
        : '#b1d1e4';
    $acqua = !empty($colorOptions['colorAcqua']) 
        ? esc_attr($colorOptions['colorAcqua']) 
        : '#51bad9';
    $beige = !empty($colorOptions['colorBeige']) 
        ? esc_attr($colorOptions['colorBeige']) 
        : '#f6f4ca';
    $grey = !empty($colorOptions['colorGrey']) 
        ? esc_attr($colorOptions['colorGrey']) 
        : '#f9f9f9';
    $darkGrey = !empty($colorOptions['colorDarkGrey']) 
        ? esc_attr($colorOptions['colorDarkGrey']) 
        : '#28321E';
    $azulGrey = !empty($colorOptions['colorAzulGrey']) 
        ? esc_attr($colorOptions['colorAzulGrey']) 
        : '#e6ecee';
    $blog = !empty($colorOptions['colorBlog']) 
        ? esc_attr($colorOptions['colorBlog']) 
        : '#7bdb8f';
    $event = !empty($colorOptions['colorEvent']) 
        ? esc_attr($colorOptions['colorEvent']) 
        : '#6690ff';
    $lernen = !empty($colorOptions['colorLernen']) 
        ? esc_attr($colorOptions['colorLernen']) 
        : '#ff904f';
    $text = !empty($colorOptions['colorText']) 
        ? esc_attr($colorOptions['colorText']) 
        : '#000000';
    $textMuted = !empty($colorOptions['colorTextMuted']) 
        ? esc_attr($colorOptions['colorTextMuted']) 
        : '#666666';
    $background = !empty($colorOptions['colorBackground']) 
        ? esc_attr($colorOptions['colorBackground']) 
        : '#ffffff';
    $backgroundSecondary = !empty($colorOptions['colorBackgroundSecondary']) 
        ? esc_attr($colorOptions['colorBackgroundSecondary']) 
        : '#f5f5f5';
    $accent = !empty($colorOptions['colorAccent']) 
        ? esc_attr($colorOptions['colorAccent']) 
        : '#fa642e';
    $border = !empty($colorOptions['colorBorder']) 
        ? esc_attr($colorOptions['colorBorder']) 
        : '#e0e0e0';
    $error = !empty($colorOptions['colorError']) 
        ? esc_attr($colorOptions['colorError']) 
        : '#dc3545';
    
    // Build CSS variables
    $css = ":root {\n";
    $css .= "  --black: {$black};\n";
    $css .= "  --white: {$white};\n";
    $css .= "  --orange: {$orange};\n";
    $css .= "  --orangeHover: {$orangeHover};\n";
    $css .= "  --yellow: {$yellow};\n";
    $css .= "  --green: {$green};\n";
    $css .= "  --blue: {$blue};\n";
    $css .= "  --lightblue: {$lightBlue};\n";
    $css .= "  --acqua: {$acqua};\n";
    $css .= "  --beige: {$beige};\n";
    $css .= "  --grey: {$grey};\n";
    $css .= "  --darkgrey: {$darkGrey};\n";
    $css .= "  --azulgrey: {$azulGrey};\n";
    $css .= "  --blog: {$blog};\n";
    $css .= "  --event: {$event};\n";
    $css .= "  --lernen: {$lernen};\n";
    $css .= "  --color-text: {$text};\n";
    $css .= "  --color-text-muted: {$textMuted};\n";
    $css .= "  --color-background: {$background};\n";
    $css .= "  --color-background-secondary: {$backgroundSecondary};\n";
    $css .= "  --color-accent: {$accent};\n";
    $css .= "  --color-border: {$border};\n";
    $css .= "  --color-error: {$error};\n";
    $css .= "}\n";
    
    echo "<style id='flynt-colors-css'>\n{$css}\n</style>\n";
}, 100);

