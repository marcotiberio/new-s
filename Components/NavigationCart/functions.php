<?php

namespace Flynt\Components\NavigationCart;

if (!class_exists('WooCommerce')) {
    return;
}

add_filter('Flynt/addComponentData?name=NavigationCart', function ($data) {
    $cart = WC()->cart;
    $data['cart'] = [
        'count' => $cart ? $cart->get_cart_contents_count() : 0,
        'url'   => function_exists('wc_get_cart_url') ? wc_get_cart_url() : '',
    ];
    return $data;
});

// AJAX fragment swaps after add-to-cart — replaces the count badge and mini-cart body.
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

    ob_start(); ?>
    <span class="js-cart-count cartToggle__counter ml-1" data-count="<?php echo (int) $count; ?>">(<?php echo (int) $count; ?>)</span>
    <?php
    $fragments['span.js-cart-count'] = ob_get_clean();

    ob_start(); ?>
    <div class="js-mini-cart miniCart__body">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php
    $fragments['div.js-mini-cart'] = ob_get_clean();

    return $fragments;
});

// Make sure WC's cart-fragments JS is loaded site-wide (otherwise the count
// won't refresh on pages WC didn't enqueue it on).
add_action('wp_enqueue_scripts', function () {
    if (function_exists('is_admin') && is_admin()) {
        return;
    }
    wp_enqueue_script('wc-cart-fragments');
}, 20);
