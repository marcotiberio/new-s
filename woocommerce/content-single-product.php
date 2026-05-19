<?php

/**
 * Theme override of WooCommerce's content-single-product template.
 *
 * Picked up automatically by WC's wc_get_template() because this file lives
 * under {theme}/woocommerce/. Hands rendering to a Timber/Twig partial so the
 * outer layout is fully ours, while WC's hook actions still fire — keeping
 * plugins (Stripe, reviews, upsells, etc.) wired in.
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

if (!is_a($product, 'WC_Product')) {
    return;
}

$context = \Timber\Timber::context();
$context['product'] = $product;
$context['productClasses'] = implode(' ', wc_get_product_class('', $product));

\Timber\Timber::render('templates/woocommerce/content-single-product.twig', $context);
