<?php

if (!class_exists('WooCommerce')) {
    return;
}

add_action('after_setup_theme', function () {
    add_theme_support('woocommerce', [
        'thumbnail_image_width' => 600,
        'single_image_width'    => 1200,
        'product_grid'          => [
            'default_rows'    => 3,
            'min_rows'        => 1,
            'default_columns' => 3,
            'min_columns'     => 1,
            'max_columns'     => 6,
        ],
    ]);

    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-slider');
});

// Drop WooCommerce's default stylesheets — styling is owned by the theme.
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Force guest checkout: no customer accounts at this stage.
add_filter('pre_option_woocommerce_enable_guest_checkout', fn () => 'yes');
add_filter('pre_option_woocommerce_enable_signup_and_login_from_checkout', fn () => 'no');
add_filter('pre_option_woocommerce_enable_checkout_login_reminder', fn () => 'no');
add_filter('pre_option_woocommerce_enable_myaccount_registration', fn () => 'no');
add_filter('pre_option_woocommerce_registration_generate_username', fn () => 'yes');
add_filter('pre_option_woocommerce_registration_generate_password', fn () => 'yes');

// Block direct access to /my-account/* — redirect to home.
add_action('template_redirect', function () {
    if (function_exists('is_account_page') && is_account_page()) {
        wp_safe_redirect(home_url('/'));
        exit;
    }
});

// Strip WooCommerce's default sidebar wrappers; the theme provides its own layout.
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// Detach related products from the after-summary stack so the Twig template
// can render it in its own full-width section below the two-column layout.
add_action('init', function () {
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
});

// Strip the anchor tag that WC wraps each product-gallery image in (the link
// to the full-size attachment). Leaves the <img> in place.
add_filter('woocommerce_single_product_image_thumbnail_html', function ($html) {
    return preg_replace('#<a\b[^>]*>(.*?)</a>#is', '$1', $html);
});

// Render product short description inside WC's product-loop card (related
// products, upsells, etc.). Placed after the title/price stack at priority 11.
add_action('woocommerce_after_shop_loop_item_title', function () {
    global $product;
    if (!is_a($product, 'WC_Product')) {
        return;
    }
    $short = $product->get_short_description();
    if (!$short) {
        return;
    }
    echo '<div class="productLoop__shortDescription">' . wp_kses_post(apply_filters('woocommerce_short_description', $short)) . '</div>';
}, 11);

// Merge product-loop title + price into a single flex row so they sit
// side-by-side inside the .product card.
add_action('init', function () {
    remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
});

add_action('woocommerce_shop_loop_item_title', function () {
    global $product;
    if (!is_a($product, 'WC_Product')) {
        return;
    }
    echo '<div class="productLoop__titlePrice w-full flex flex-row justify-between">';
    echo '<h2 class="woocommerce-loop-product__title">' . esc_html($product->get_name()) . '</h2>';
    echo '<span class="price">' . $product->get_price_html() . '</span>';
    echo '</div>';
}, 10);

// Wrap WC's quantity input with minus/plus stepper buttons on single product
// pages. JS handler below increments/decrements the value.
add_action('woocommerce_before_add_to_cart_quantity', function () {
    echo '<div class="qty-stepper">';
    echo '<button type="button" class="qty-stepper__btn qty-stepper__btn--minus" aria-label="' . esc_attr__('Decrease quantity', 'flynt') . '">&minus;</button>';
});

add_action('woocommerce_after_add_to_cart_quantity', function () {
    echo '<button type="button" class="qty-stepper__btn qty-stepper__btn--plus" aria-label="' . esc_attr__('Increase quantity', 'flynt') . '">+</button>';
    echo '</div>';
});

// Stepper click handler — vanilla JS, attached once via delegation.
add_action('wp_footer', function () {
    if (!function_exists('is_product') || !is_product()) {
        return;
    }
    ?>
    <script>
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.qty-stepper__btn');
        if (!btn) return;
        var stepper = btn.closest('.qty-stepper');
        var input = stepper && stepper.querySelector('input.qty');
        if (!input) return;
        var step = parseFloat(input.step) || 1;
        var min = parseFloat(input.min);
        if (isNaN(min)) min = 0;
        var max = parseFloat(input.max);
        if (isNaN(max)) max = Infinity;
        var val = parseFloat(input.value) || 0;
        var next = btn.classList.contains('qty-stepper__btn--plus') ? val + step : val - step;
        input.value = Math.max(min, Math.min(max, next));
        input.dispatchEvent(new Event('change', { bubbles: true }));
    });
    </script>
    <?php
});

// "Add to cart" → "Buy Now" on single product pages.
add_filter('woocommerce_product_single_add_to_cart_text', function () {
    return __('Buy Now', 'flynt');
});

// Single product page: merge title + price into one flex row AND group it with
// the add-to-cart form in a flex-col wrapper. Replaces WC's default title (5),
// price (10), and add-to-cart (30) actions.
add_action('init', function () {
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
});

add_action('woocommerce_single_product_summary', function () {
    global $product;
    if (!is_a($product, 'WC_Product')) {
        return;
    }
    echo '<div class="singleProduct__buyBlock w-full flex flex-col gap-sm">';
    echo '<div class="singleProduct__titlePrice w-full flex flex-row justify-between">';
    echo '<h1 class="product_title entry-title">' . esc_html($product->get_name()) . '</h1>';
    echo '<p class="price">' . $product->get_price_html() . '</p>';
    echo '</div>';
    woocommerce_template_single_add_to_cart();
    echo '</div>';
}, 5);

// Don't pipe the Shop page's flexible-content body into the archive description —
// page-builder components aren't safe to render inside the archive description
// context (no proper post loop, shortcodes break).
add_action('init', function () {
    remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
});

// Cart / Checkout / Order Received are regular WP pages with WC shortcodes in
// post_content. The theme's page.twig only renders ACF pageComponents and ignores
// post_content — so shortcodes never run. Re-route those pages through the theme's
// woocommerce.php bridge instead.
add_filter('template_include', function ($template) {
    $isShortcodePage =
        (function_exists('is_cart') && is_cart()) ||
        (function_exists('is_checkout') && is_checkout()) ||
        (function_exists('is_order_received_page') && is_order_received_page());

    if ($isShortcodePage) {
        $themeWc = get_template_directory() . '/woocommerce.php';
        if (file_exists($themeWc)) {
            return $themeWc;
        }
    }
    return $template;
}, 99);

// Render the Shop page's Flynt pageComponents above the shop loop / product
// taxonomy archives. Lets editors compose the shop archive top with Flynt blocks
// (BlockProductGrid, etc.) via the same flexible-content field used on pages.
add_action('woocommerce_before_shop_loop', function () {
    $isWcArchive =
        (function_exists('is_shop') && is_shop()) ||
        (function_exists('is_product_taxonomy') && is_product_taxonomy());

    if (!$isWcArchive) {
        return;
    }

    $shopId = function_exists('wc_get_page_id') ? wc_get_page_id('shop') : 0;
    if ($shopId <= 0) {
        echo "<!-- shopComponents: no Shop page configured -->\n";
        return;
    }

    $componentsCount = is_array(get_field('pageComponents', $shopId)) ? count(get_field('pageComponents', $shopId)) : 0;
    echo "<!-- shopComponents: shopId={$shopId}, components={$componentsCount} -->\n";

    if ($componentsCount === 0) {
        return;
    }

    echo do_shortcode('[flyntTheContent id="' . (int) $shopId . '"]');
}, 5);

add_action('woocommerce_before_main_content', function () {
    echo '<div class="wcMain w-full max-w-screen-max mx-auto px-xs py-md">';
}, 10);

add_action('woocommerce_after_main_content', function () {
    echo '</div>';
}, 10);
