<?php

namespace Flynt\Components\BlockProductGrid;

function getACFLayout()
{
    return [
        'name' => 'BlockProductGrid',
        'label' => __('Block: Product Grid', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Headline', 'flynt'),
                'instructions' => __('Optional headline shown above the grid.', 'flynt'),
                'name' => 'headlineTitle',
                'type' => 'text',
            ],
            [
                'label' => __('Source', 'flynt'),
                'name' => 'source',
                'type' => 'button_group',
                'choices' => [
                    'latest' => __('Latest products', 'flynt'),
                    'category' => __('By category', 'flynt'),
                    'manual' => __('Pick products', 'flynt'),
                ],
                'default_value' => 'latest',
            ],
            [
                'label' => __('Categories', 'flynt'),
                'name' => 'categories',
                'type' => 'taxonomy',
                'taxonomy' => 'product_cat',
                'field_type' => 'multi_select',
                'return_format' => 'id',
                'allow_null' => 1,
                'conditional_logic' => [
                    [
                        ['field' => 'source', 'operator' => '==', 'value' => 'category'],
                    ],
                ],
            ],
            [
                'label' => __('Products', 'flynt'),
                'name' => 'products',
                'type' => 'post_object',
                'post_type' => ['product'],
                'multiple' => 1,
                'return_format' => 'id',
                'ui' => 1,
                'conditional_logic' => [
                    [
                        ['field' => 'source', 'operator' => '==', 'value' => 'manual'],
                    ],
                ],
            ],
            [
                'label' => __('Limit', 'flynt'),
                'instructions' => __('Maximum number of products to display.', 'flynt'),
                'name' => 'limit',
                'type' => 'number',
                'default_value' => 12,
                'min' => 1,
                'max' => 60,
                'conditional_logic' => [
                    [
                        ['field' => 'source', 'operator' => '!=', 'value' => 'manual'],
                    ],
                ],
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'label' => __('Grid Columns', 'flynt'),
                        'name' => 'gridColumns',
                        'type' => 'button_group',
                        'choices' => [
                            '1' => '<p>1</p>',
                            '2' => '<p>2</p>',
                            '3' => '<p>3</p>',
                            '4' => '<p>4</p>',
                            '5' => '<p>5</p>',
                        ],
                        'default_value' => '3',
                    ],
                    [
                        'label' => __('Show price', 'flynt'),
                        'name' => 'showPrice',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Show add to cart', 'flynt'),
                        'name' => 'showAddToCart',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                        'wrapper' => ['width' => 50],
                    ],
                ],
            ],
        ],
    ];
}

add_filter('Flynt/addComponentData?name=BlockProductGrid', function ($data) {
    if (!class_exists('WooCommerce')) {
        $data['products'] = [];
        return $data;
    }

    $source = $data['source'] ?? 'latest';
    $limit = (int) ($data['limit'] ?? 12);

    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'tax_query' => [
            [
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => ['exclude-from-catalog'],
                'operator' => 'NOT IN',
            ],
        ],
    ];

    if ($source === 'manual' && !empty($data['products'])) {
        $ids = array_map('intval', (array) $data['products']);
        $args['post__in'] = $ids;
        $args['orderby'] = 'post__in';
        $args['posts_per_page'] = count($ids);
    } elseif ($source === 'category' && !empty($data['categories'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => array_map('intval', (array) $data['categories']),
        ];
    }

    $query = new \WP_Query($args);

    $products = [];
    foreach ($query->posts as $post) {
        $product = wc_get_product($post);
        if (!$product) {
            continue;
        }
        $thumbId = $product->get_image_id();
        $products[] = [
            'id' => $product->get_id(),
            'title' => $product->get_name(),
            'url' => get_permalink($product->get_id()),
            'priceHtml' => $product->get_price_html(),
            'shortDescription' => apply_filters('woocommerce_short_description', $product->get_short_description()),
            'image' => $thumbId ? [
                'id' => $thumbId,
                'src' => wp_get_attachment_image_url($thumbId, 'woocommerce_thumbnail'),
                'srcset' => wp_get_attachment_image_srcset($thumbId, 'woocommerce_thumbnail') ?: '',
                'alt' => get_post_meta($thumbId, '_wp_attachment_image_alt', true),
            ] : null,
            'isPurchasable' => $product->is_purchasable() && $product->is_in_stock(),
            'isVariable' => $product->is_type('variable'),
            'addToCartText' => $product->add_to_cart_text(),
            'addToCartUrl' => $product->add_to_cart_url(),
        ];
    }

    wp_reset_postdata();

    $data['products'] = $products;
    return $data;
});
