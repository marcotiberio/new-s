<?php

namespace Flynt\WoocommerceOptions;

use Flynt\Utils\Options;

if (!class_exists('WooCommerce')) {
    return;
}

add_action('acf/init', function () {
    Options::addGlobal('Woocommerce', [
        [
            'name'  => 'navigationTab',
            'label' => __('Navigation', 'flynt'),
            'type'  => 'tab',
        ],
        [
            'name'          => 'hideNavigationCart',
            'label'         => __('Hide NavigationCart toggle', 'flynt'),
            'instructions'  => __('When enabled, the cart icon in the header is not rendered.', 'flynt'),
            'type'          => 'true_false',
            'ui'            => 1,
            'default_value' => 0,
        ],
    ]);
});
