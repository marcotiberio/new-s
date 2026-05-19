<?php

use Timber\Timber;

$context = Timber::context();

$context['wcPageType'] = 'archive';
if (function_exists('is_cart') && is_cart()) {
    $context['wcPageType'] = 'cart';
} elseif (function_exists('is_checkout') && is_checkout()) {
    $context['wcPageType'] = 'checkout';
} elseif (function_exists('is_order_received_page') && is_order_received_page()) {
    $context['wcPageType'] = 'order-received';
}

Timber::render('templates/woocommerce.twig', $context);
