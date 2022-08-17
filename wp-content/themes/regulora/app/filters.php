<?php

namespace App;

use App\Controllers\Attorney;
use App\Controllers\NewsInsights;
use App\Controllers\Practices;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);

/**
 * Async load CSS
 */
add_filter('style_loader_tag', function (string $html, string $handle): string {
    if ( is_admin() || ( isset( $_GET['no-async'] ) && $_GET['no-async'] ) ) {
        return $html;
    }

    $dom = new \DOMDocument();
    $dom->loadHTML( $html );
    $tag = $dom->getElementById( $handle . '-css' );
    $tag->setAttribute( 'media', 'print' );
    $tag->setAttribute( 'onload', "this.media='all'" );
    $tag->removeAttribute( 'type' );
    $tag->removeAttribute( 'id' );
    $html = $dom->saveHTML( $tag );

    return $html;
}, 999, 2);

/**
 * ACF json settings
 */

add_filter( 'acf/settings/save_json', function ( $path ) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
} );

add_filter( 'acf/settings/load_json', function ( $paths ) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
} );

/**
 * MIME SVG add
 * Allow .vcf files to upload to the media library
 */
add_filter( 'upload_mimes', function ( $mimes ) {
    $mimes[ 'svg' ]     = 'image/svg+xml';
    $mimes[ 'svgz' ]    = 'image/svg+xml';
    $mimes[ 'vcf' ]     = 'text/vcard';
    return $mimes;
} );

/**
 * Excerpt length
 */
remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', function( $excerpt, $post ) {
    $characters = 150; // character limit
    $raw_excerpt = $excerpt;
    if ( '' == $excerpt ) {
        $excerpt = $post->post_content;
        $excerpt = strip_shortcodes( $excerpt );
        $excerpt = apply_filters( 'the_content', $excerpt );
        $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
        $excerpt = strip_tags( $excerpt, '<b><i><sup><sub><strong>' );
    }
    $excerpt = htmlspecialchars_decode( trim( strip_tags( $excerpt, '<sup>' ) ) );
    if ( strlen( $excerpt ) > $characters ) {
        $lastSpacer = strpos( $excerpt, ' ', $characters );
        if ( $lastSpacer !== false ) {
            $return = substr( $excerpt, 0, $lastSpacer );
            if ( in_array( substr( $return, -1 ), array( '.', ',', ':', ';' ) ) ) {
                $return = substr( $return, 0, strlen( $return ) - 1 );
            }
            return '<p>' . $return . '... <a href="' . get_the_permalink( $post->ID ) . '" class="read-more-link">Read more</a></p>';
        }
    }
    return "<p>$excerpt...</p>";
}, 25, 2 );

/**
 * Add li class to main menu items
 */
add_filter('nav_menu_css_class', function ( $classes, $item, $args ) {
    if( property_exists( $args, 'add_li_class' ) ) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}, 1, 3);

add_filter( 'nav_menu_link_attributes', function( $atts, $item, $args ) {
    if ( property_exists( $args, 'link_class' ) ) {
        $atts[ 'class' ] = $args->link_class;
    }
    return $atts;
}, 1, 3 );
