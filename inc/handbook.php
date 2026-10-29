<?php

/**
 * Handbook data and structured data (schema.org JSON-LD) for answer engines.
 * See inc/customPostTypes/handbook.php.
 */

namespace Flynt\Handbook;

use Flynt\Utils\Options;
use Timber\Timber;

/**
 * The hub is the page whose slug matches the handbook slug.
 */
function getHubPage()
{
    return get_page_by_path(\Flynt\CustomPostTypes\getHandbookSlug());
}

function getHubUrl()
{
    $hub = getHubPage();
    return $hub ? get_permalink($hub) : home_url('/');
}

function getHubTitle()
{
    $hub = getHubPage();
    return $hub ? get_the_title($hub) : __('Handbook', 'flynt');
}

function getHubIntro()
{
    $hub = getHubPage();
    foreach (($hub ? get_field('pageComponents', $hub->ID) : null) ?: [] as $component) {
        if ($component['acf_fc_layout'] === 'ListingHandbook') {
            return $component['intro'];
        }
    }
    return '';
}

/**
 * Editors also see drafts so entries can be reviewed in context.
 */
function getVisibleStatuses()
{
    return current_user_can('edit_pages') ? ['publish', 'draft', 'pending', 'private'] : ['publish'];
}

/**
 * Category overviews (top-level entries) with their topics.
 */
function getTree()
{
    $categories = Timber::get_posts([
        'post_type' => 'handbook',
        'post_parent' => 0,
        'post_status' => getVisibleStatuses(),
        'posts_per_page' => -1,
        'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC'],
    ])->to_array();

    return array_map(function ($category) {
        return [
            'post' => $category,
            'topics' => getTopics($category->ID),
        ];
    }, $categories);
}

function getTopics($parentId)
{
    return Timber::get_posts([
        'post_type' => 'handbook',
        'post_parent' => $parentId,
        'post_status' => getVisibleStatuses(),
        'posts_per_page' => -1,
        'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC'],
    ])->to_array();
}

function getBreadcrumbs($postId)
{
    $crumbs = [['title' => getHubTitle(), 'url' => getHubUrl()]];
    foreach (array_reverse(get_post_ancestors($postId)) as $ancestorId) {
        $crumbs[] = ['title' => get_the_title($ancestorId), 'url' => get_permalink($ancestorId)];
    }
    $crumbs[] = ['title' => get_the_title($postId), 'url' => get_permalink($postId)];
    return $crumbs;
}

function getSingleContext($post)
{
    $relatedIds = get_field('handbookRelated', $post->ID) ?: [];
    $isCategory = $post->post_parent === 0;

    return [
        'breadcrumbs' => getBreadcrumbs($post->ID),
        'hub' => ['title' => getHubTitle(), 'url' => getHubUrl()],
        'topics' => $isCategory ? getTopics($post->ID) : [],
        'siblings' => $isCategory ? [] : array_values(array_filter(
            getTopics($post->post_parent),
            fn ($sibling) => $sibling->ID !== $post->ID
        )),
        'related' => $relatedIds ? Timber::get_posts([
            'post_type' => 'handbook',
            'post__in' => $relatedIds,
            'orderby' => 'post__in',
            'posts_per_page' => -1,
        ])->to_array() : [],
        'options' => Options::getTranslatable('Handbook'),
    ];
}

function getPublisher()
{
    if (defined('WPSEO_VERSION')) {
        return ['@id' => home_url('/#organization')];
    }
    return [
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
    ];
}

function getSingleSchema($postId)
{
    $url = get_permalink($postId);
    $title = get_the_title($postId);
    $definition = get_field('handbookDefinition', $postId);
    $reviewed = get_field('handbookReviewed', $postId);
    $authorName = get_field('handbookAuthor', $postId);
    $faq = get_field('handbookFaq', $postId) ?: [];

    $graph = [
        [
            '@type' => 'Article',
            '@id' => $url . '#article',
            'headline' => $title,
            'description' => $definition,
            'url' => $url,
            'mainEntityOfPage' => $url,
            'inLanguage' => get_bloginfo('language'),
            'datePublished' => get_the_date('c', $postId),
            'dateModified' => $reviewed ? date('c', strtotime($reviewed)) : get_the_modified_date('c', $postId),
            'author' => $authorName ? ['@type' => 'Person', 'name' => $authorName] : getPublisher(),
            'publisher' => getPublisher(),
            'about' => ['@id' => $url . '#term'],
            'isPartOf' => ['@id' => getHubUrl() . '#termset'],
        ],
        [
            '@type' => 'DefinedTerm',
            '@id' => $url . '#term',
            'name' => $title,
            'description' => $definition,
            'url' => $url,
            'inDefinedTermSet' => ['@id' => getHubUrl() . '#termset'],
        ],
    ];

    if ($faq) {
        $graph[] = [
            '@type' => 'FAQPage',
            '@id' => $url . '#faq',
            'url' => $url,
            'mainEntity' => array_map(fn ($item) => [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => wp_strip_all_tags($item['answer'])],
            ], $faq),
        ];
    }

    if (!defined('WPSEO_VERSION')) {
        $graph[] = getBreadcrumbSchema(getBreadcrumbs($postId), $url);
    }

    return $graph;
}

function getHubSchema()
{
    $url = getHubUrl();
    $terms = get_posts([
        'post_type' => 'handbook',
        'posts_per_page' => -1,
        'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC'],
    ]);

    return [[
        '@type' => 'DefinedTermSet',
        '@id' => $url . '#termset',
        'name' => getHubTitle(),
        'description' => getHubIntro(),
        'url' => $url,
        'inLanguage' => get_bloginfo('language'),
        'publisher' => getPublisher(),
        'hasDefinedTerm' => array_map(fn ($term) => [
            '@type' => 'DefinedTerm',
            '@id' => get_permalink($term) . '#term',
            'name' => get_the_title($term),
            'url' => get_permalink($term),
        ], $terms),
    ]];
}

function getBreadcrumbSchema($crumbs, $url)
{
    return [
        '@type' => 'BreadcrumbList',
        '@id' => $url . '#breadcrumb',
        'itemListElement' => array_map(fn ($crumb, $index) => [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $crumb['title'],
            'item' => $crumb['url'],
        ], $crumbs, array_keys($crumbs)),
    ];
}

add_action('wp_head', function () {
    if (is_singular('handbook')) {
        $graph = getSingleSchema(get_queried_object_id());
    } elseif (getHubPage() && is_page(getHubPage()->ID)) {
        $graph = getHubSchema();
    } else {
        return;
    }
    $json = wp_json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    echo '<script type="application/ld+json">' . $json . '</script>' . "\n";
});

// Use the short answer as meta description unless Yoast has one.
add_filter('wpseo_metadesc', function ($description) {
    if (!$description && is_singular('handbook')) {
        return get_field('handbookDefinition', get_queried_object_id()) ?: $description;
    }
    return $description;
});

// Yoast breadcrumbs: Home › Hub › Category › Topic.
add_filter('wpseo_breadcrumb_links', function ($links) {
    if (!is_singular('handbook')) {
        return $links;
    }
    $crumbs = array_map(fn ($crumb) => ['url' => $crumb['url'], 'text' => $crumb['title']], getBreadcrumbs(get_queried_object_id()));
    return array_merge([$links[0]], $crumbs);
});
