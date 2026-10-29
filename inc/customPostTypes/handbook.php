<?php

/**
 * Handbook: a public knowledge base of key terms (GEO / LLM citation hub).
 *
 * Top-level entries are category overviews, child entries are topics:
 * /circular-economy-handbook/                       → hub (page with the ListingHandbook component)
 * /circular-economy-handbook/{category}/             → category overview
 * /circular-economy-handbook/{category}/{topic}/     → topic
 *
 * The hub is a regular page whose slug matches the handbook slug. Change the
 * slug with the `Flynt/handbookSlug` filter. Rewrite rules flush automatically
 * when the slug changes.
 */

namespace Flynt\CustomPostTypes;

function getHandbookSlug()
{
    return apply_filters('Flynt/handbookSlug', 'circular-economy-handbook');
}

function registerHandbookPostType()
{
    $labels = [
        'name'                  => _x('Handbook', 'Post Type General Name', 'flynt'),
        'singular_name'         => _x('Handbook Entry', 'Post Type Singular Name', 'flynt'),
        'menu_name'             => __('Handbook', 'flynt'),
        'name_admin_bar'        => __('Handbook Entry', 'flynt'),
        'parent_item_colon'     => __('Category:', 'flynt'),
        'all_items'             => __('All Entries', 'flynt'),
        'add_new_item'          => __('Add New Entry', 'flynt'),
        'add_new'               => __('Add New', 'flynt'),
        'new_item'              => __('New Entry', 'flynt'),
        'edit_item'             => __('Edit Entry', 'flynt'),
        'update_item'           => __('Update Entry', 'flynt'),
        'view_item'             => __('View Entry', 'flynt'),
        'view_items'            => __('View Handbook', 'flynt'),
        'search_items'          => __('Search Entries', 'flynt'),
        'not_found'             => __('Not found', 'flynt'),
        'not_found_in_trash'    => __('Not found in Trash', 'flynt'),
    ];
    $args = [
        'label'                 => __('Handbook', 'flynt'),
        'description'           => __('Key terms explained', 'flynt'),
        'labels'                => $labels,
        'supports'              => ['title', 'thumbnail', 'page-attributes', 'revisions'],
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'menu_position'         => 9,
        'menu_icon'             => 'dashicons-book-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'rewrite'               => ['slug' => getHandbookSlug(), 'with_front' => false],
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    ];
    register_post_type('handbook', $args);

    if (get_option('flynt_handbook_rewrite') !== getHandbookSlug() . '|page') {
        flush_rewrite_rules(false);
        update_option('flynt_handbook_rewrite', getHandbookSlug() . '|page');
    }
}

add_action('init', '\\Flynt\\CustomPostTypes\\registerHandbookPostType');
