<?php

namespace Flynt\CheckoutFields;

use Flynt\Utils\Options;

if (!class_exists('WooCommerce')) {
    return;
}

/**
 * Fields exposed in the admin UI. Order matters — it's the order they appear
 * in the ACF options page.
 *
 * `default_enabled` controls the initial state when no value has been saved yet
 * (matches WC's own defaults: company/address_2/phone start off; the rest on).
 */
const FIELDS = [
    'first_name'  => ['label' => 'First Name',  'default_enabled' => true],
    'last_name'   => ['label' => 'Last Name',   'default_enabled' => true],
    'company'     => ['label' => 'Company',     'default_enabled' => false],
    'address_1'   => ['label' => 'Street',      'default_enabled' => true],
    'address_2'   => ['label' => 'Apartment',   'default_enabled' => false],
    'city'        => ['label' => 'City',        'default_enabled' => true],
    'postcode'    => ['label' => 'Post Code',   'default_enabled' => true],
    'country'     => ['label' => 'Country',     'default_enabled' => true],
    'state'       => ['label' => 'State',       'default_enabled' => true],
    'phone'       => ['label' => 'Phone',       'default_enabled' => false],
];

// -----------------------------------------------------------------------------
// ACF options page registration.
// -----------------------------------------------------------------------------
add_action('acf/init', function () {
    $fields = [];

    foreach (FIELDS as $key => $cfg) {
        $fields[] = [
            'name'  => "checkoutField_{$key}_tab",
            'label' => $cfg['label'],
            'type'  => 'tab',
        ];
        $fields[] = [
            'name'          => "checkoutField_{$key}_enabled",
            'label'         => __('Show field', 'flynt'),
            'type'          => 'true_false',
            'ui'            => 1,
            'default_value' => $cfg['default_enabled'] ? 1 : 0,
        ];
        $fields[] = [
            'name'          => "checkoutField_{$key}_required",
            'label'         => __('Required', 'flynt'),
            'type'          => 'true_false',
            'ui'            => 1,
            'default_value' => 1,
            'conditional_logic' => [
                [
                    ['field' => "checkoutField_{$key}_enabled", 'operator' => '==', 'value' => 1],
                ],
            ],
        ];
        $fields[] = [
            'name'         => "checkoutField_{$key}_label",
            'label'        => __('Label override', 'flynt'),
            'instructions' => __('Leave empty to use the default label.', 'flynt'),
            'type'         => 'text',
            'conditional_logic' => [
                [
                    ['field' => "checkoutField_{$key}_enabled", 'operator' => '==', 'value' => 1],
                ],
            ],
        ];
        $fields[] = [
            'name'         => "checkoutField_{$key}_placeholder",
            'label'        => __('Placeholder', 'flynt'),
            'instructions' => __('Optional placeholder shown inside the input.', 'flynt'),
            'type'         => 'text',
            'conditional_logic' => [
                [
                    ['field' => "checkoutField_{$key}_enabled", 'operator' => '==', 'value' => 1],
                ],
            ],
        ];
    }

    Options::addGlobal('CheckoutFields', $fields);
});

/**
 * Resolve the saved config for one field. Returns an array with keys:
 *   enabled (bool), required (bool), label (string|null), placeholder (string|null)
 */
function getFieldConfig(string $key): array
{
    $opts = Options::getGlobal('CheckoutFields') ?: [];
    $default = FIELDS[$key] ?? ['default_enabled' => true];
    $enabledRaw = $opts["checkoutField_{$key}_enabled"] ?? null;
    $requiredRaw = $opts["checkoutField_{$key}_required"] ?? null;

    return [
        'enabled'     => $enabledRaw === null ? (bool) $default['default_enabled'] : (bool) $enabledRaw,
        'required'    => $requiredRaw === null ? true : (bool) $requiredRaw,
        'label'       => trim((string) ($opts["checkoutField_{$key}_label"] ?? '')) ?: null,
        'placeholder' => trim((string) ($opts["checkoutField_{$key}_placeholder"] ?? '')) ?: null,
    ];
}

// -----------------------------------------------------------------------------
// Apply config to WC's address fields (used by both classic + block checkout).
// -----------------------------------------------------------------------------
add_filter('woocommerce_default_address_fields', function ($fields) {
    foreach (FIELDS as $key => $_cfg) {
        if (!isset($fields[$key])) {
            continue;
        }
        $cfg = getFieldConfig($key);

        if (!$cfg['enabled']) {
            $fields[$key]['required'] = false;
            $fields[$key]['hidden']   = true;
            continue;
        }

        $fields[$key]['required'] = $cfg['required'];
        if ($cfg['label'] !== null) {
            $fields[$key]['label'] = $cfg['label'];
        }
        if ($cfg['placeholder'] !== null) {
            $fields[$key]['placeholder'] = $cfg['placeholder'];
        }
    }
    return $fields;
}, 20);

/**
 * Toggle WC's phone field globally on the block checkout — the address-fields
 * filter alone doesn't fully suppress it.
 */
add_filter('woocommerce_checkout_fields', function ($fields) {
    $phoneCfg = getFieldConfig('phone');
    if (!$phoneCfg['enabled']) {
        unset($fields['billing']['billing_phone'], $fields['shipping']['shipping_phone']);
    } else {
        if (isset($fields['billing']['billing_phone'])) {
            $fields['billing']['billing_phone']['required'] = $phoneCfg['required'];
            if ($phoneCfg['label'] !== null) {
                $fields['billing']['billing_phone']['label'] = $phoneCfg['label'];
            }
            if ($phoneCfg['placeholder'] !== null) {
                $fields['billing']['billing_phone']['placeholder'] = $phoneCfg['placeholder'];
            }
        }
    }
    return $fields;
});

// -----------------------------------------------------------------------------
// Placeholder bridge — block checkout doesn't render the `placeholder` config
// as an HTML attribute (it uses a floating-label UI). Pipe placeholders to JS
// so custom.js can stamp them onto the inputs after the checkout mounts.
// -----------------------------------------------------------------------------
add_action('wp_enqueue_scripts', function () {
    if (!function_exists('is_checkout') || !is_checkout()) {
        return;
    }

    $placeholders = [];
    foreach (FIELDS as $key => $_cfg) {
        $cfg = getFieldConfig($key);
        if ($cfg['enabled'] && $cfg['placeholder'] !== null) {
            $placeholders[$key] = $cfg['placeholder'];
        }
    }

    wp_localize_script('Flynt/assets/main', 'FlyntCheckoutFields', [
        'placeholders' => (object) $placeholders,
    ]);
}, 20);

// -----------------------------------------------------------------------------
// CSS fallback — block checkout doesn't always honor `hidden: true`, so hide
// disabled fields via stylesheet as well.
// -----------------------------------------------------------------------------
add_action('wp_head', function () {
    if (!function_exists('is_checkout') || !is_checkout()) {
        return;
    }

    $selectors = [];
    foreach (FIELDS as $key => $_cfg) {
        if (getFieldConfig($key)['enabled']) {
            continue;
        }
        // Block checkout assigns ids like `shipping-first_name`, `billing-first_name`,
        // and renders state via a select with `[id$="-state"]`. Use `:has()` to hide
        // the field wrapper.
        $selectors[] = ".wc-block-components-address-form .wc-block-components-text-input:has(#shipping-{$key})";
        $selectors[] = ".wc-block-components-address-form .wc-block-components-text-input:has(#billing-{$key})";
        $selectors[] = ".wc-block-components-address-form .wc-block-components-select:has(#shipping-{$key})";
        $selectors[] = ".wc-block-components-address-form .wc-block-components-select:has(#billing-{$key})";
        $selectors[] = ".wc-block-components-address-form .wc-block-components-combobox:has(#shipping-{$key})";
        $selectors[] = ".wc-block-components-address-form .wc-block-components-combobox:has(#billing-{$key})";
    }
    if (!$selectors) {
        return;
    }

    echo "<style id='flynt-checkout-fields-css'>\n";
    echo implode(",\n", $selectors) . " { display: none !important; }\n";
    echo "</style>\n";
}, 110);
