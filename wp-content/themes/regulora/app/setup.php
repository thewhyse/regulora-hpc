<?php

namespace App;

use App\Controllers\App;
use App\Controllers\Attorney;
use App\Controllers\NewsInsights;
use App\Controllers\Practices;
use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Add the critical CSS to the header.
 */
add_action( 'wp_head', function () {
    // DNS-prefetch and preconnect
    echo '<link rel="dns-prefetch" href="https://www.googletagmanager.com" />';
    echo '<link rel="preconnect" href="https://www.googletagmanager.com">';
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    echo '<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500&display=swap" rel="stylesheet">';

//    echo '<link rel="dns-prefetch" href="https://fonts.gstatic.com" />';
//    echo '<link rel="preconnect" href="https://fonts.gstatic.com">';
//    echo '<link rel="dns-prefetch" href="https://www.google-analytics.com" />';
//    echo '<link rel="preconnect" href="https://www.google-analytics.com">';
//    echo '<link rel="dns-prefetch" href="https://use.typekit.net">';
//    echo '<link rel="preconnect" href="https://use.typekit.net">';
    //echo '<link rel="preload" href="https://use.typekit.net/syg3yro.css">';
//    echo '<link rel="preload" href="' . asset_path( 'fonts/Adelle_Bold.woff' ) . '" as="font" type="font/woff" crossorigin>';
//    echo '<link rel="preload" href="' . asset_path( 'fonts/Adelle_Reg.woff' ) . '" as="font" type="font/woff" crossorigin>';
//    echo '<link rel="preload" href="' . asset_path( 'fonts/MrEavesXLModOT-Bold.ttf' ) . '" as="font" type="font/ttf" crossorigin>';
//    echo '<link rel="preload" href="' . asset_path( 'fonts/MrEavesXLModOT-Reg.ttf' ) . '" as="font" type="font/ttf" crossorigin>';
    //echo '<link rel="stylesheet" href="https://use.typekit.net/syg3yro.css">';
} );

/**
 * Inject critical assets in head as early as possible
 */
add_action('wp_head', function (): void {
    global $post;
    $post_slug = $post->post_name;

    $critical_CSS = false;
    if (is_front_page()) {
        $critical_CSS = 'front-page.css';
    } elseif ( is_category() ) {
        $critical_CSS = 'category.css';
    } elseif ( is_singular( NewsInsights::$postType ) ) {
        $critical_CSS = 'single-news.css';
    } elseif ( is_search() ) {
        $critical_CSS = 'search-page.css';
    } elseif ( is_404() ) {
        $critical_CSS = 'not-found.css';
    } elseif ( is_page() ) {
        $critical_CSS = 'page.css';
    }

    if ( $post_slug ) {
        $asset_path_slug = '/dist/styles/criticals/' . $post_slug . '.css';

        if ( file_exists( get_theme_file_path() . $asset_path_slug ) ) {
            $critical_CSS = $post_slug . '.css';
        }
    }

    if ( $critical_CSS ) {
        $asset_path = '/dist/styles/criticals/' . $critical_CSS;

        if ( file_exists( get_theme_file_path() . $asset_path ) ) {
            echo "<!-- Critical CSS {$critical_CSS} -->";
            echo '<style id="critical-css">' . file_get_contents( get_theme_file_path() . $asset_path ) . '</style>';
        } else {
            echo "<!-- No Critical CSS -->";
        }
    } else {
        echo "<!-- No Critical CSS -->";
    }
}, 1);

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    if ( !is_admin() ) {
//        wp_deregister_script('jquery');
    }

    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Colors define
     */
    define( 'COLOR_PRIMARY', '#7A95BF' );
    define( 'COLOR_PRIMARY_LIGHT', '#A3B7DA' );
    define( 'COLOR_SECONDARY', '#6FD3C8' );
    define( 'COLOR_BLUE', '#7F9AC6' );
    define( 'COLOR_BLUE_LIGHT', '#E1E6EF' );
    define( 'COLOR_GRAY', '#5B5D5C' );
    define( 'COLOR_YELLOW', '#EFCE1D' );
    define( 'COLOR_BLACK', '#333333' );
    define( 'COLOR_WHITE', '#ffffff' );

    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');
    add_theme_support( 'custom-logo', [
        'height' => 120,
        'width' => 260,
        'flex-width' => true,
        'flex-height' => true,
        'header-text' => array( 'site-logo', 'site-description' ),
    ] );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation'    => __('Primary Navigation', 'sage'),
        'footer_navigation'     => __('Footer Navigation', 'sage'),
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Enable editor color pallete
     */
    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => __('Primary', 'sage'),
            'slug' => 'primary',
            'color' => COLOR_PRIMARY,
        ),
        array(
            'name' => __('Primary Light', 'sage'),
            'slug' => 'primary-light',
            'color' => COLOR_PRIMARY_LIGHT,
        ),
        array(
            'name' => __('Secondary', 'sage'),
            'slug' => 'secondary',
            'color' => COLOR_SECONDARY,
        ),
        array(
            'name' => __('Gray', 'sage'),
            'slug' => 'gray',
            'color' => COLOR_GRAY,
        ),
        array(
            'name' => __('Blue', 'sage'),
            'slug' => 'blue',
            'color' => COLOR_BLUE,
        ),
        array(
            'name' => __('Blue Light', 'sage'),
            'slug' => 'blue-light',
            'color' => COLOR_BLUE_LIGHT,
        ),
        array(
            'name' => __('Yellow', 'sage'),
            'slug' => 'yellow',
            'color' => COLOR_YELLOW,
        ),
        array(
            'name' => __('Black', 'sage'),
            'slug' => 'black',
            'color' => COLOR_BLACK,
        ),
        array(
            'name' => __('White', 'sage'),
            'slug' => 'white',
            'color' => COLOR_WHITE,
        ),
    ) );

    /**
     * Enable predefined custom font sizes
     */
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name' => __('Small', 'sage'),
            'size' => 18,
            'slug' => 'small'
        ),
        array(
            'name' => __('Smaller', 'sage'),
            'size' => 20,
            'slug' => 'smaller'
        ),
        array(
            'name' => __('Regular', 'sage'),
            'size' => 22,
            'slug' => 'regular'
        ),
        array(
            'name' => __('Bigger', 'sage'),
            'size' => 24,
            'slug' => 'bigger'
        ),
        array(
            'name' => __('Large', 'sage'),
            'size' => 34,
            'slug' => 'large'
        ),
        array(
            'name' => __('Extra Large', 'sage'),
            'size' => 44,
            'slug' => 'extra-large'
        ),
    ) );

    /**
     * Enable custom line height
     */
    add_theme_support( 'custom-line-height' );

    /**
     * Enable custom spacing
     */
    add_theme_support( 'custom-spacing' );

    /**
     * Enable excerpt support for pages
     */
    add_post_type_support( 'page', 'excerpt' );

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Actions on init
 */
add_action( 'init', function () {
    // REMOVE EMOJIS
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

    add_action( 'wpcf7_enqueue_styles', function () {
        wp_deregister_style( 'contact-form-7' );
    } );

    remove_action( "wp_head", "wp_print_scripts" );
    remove_action( "wp_head", "wp_print_head_scripts", 9 );
    remove_action( "wp_head", "wp_enqueue_scripts", 1 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );

    add_action( "wp_footer", "wp_print_scripts", 5 );
    add_action( "wp_footer", "wp_enqueue_scripts", 5 );
    add_action( "wp_footer", "wp_print_head_scripts", 5 );
} );

/**
 * Gutenberg scripts and styles
 */
add_action( 'enqueue_block_editor_assets', function () {
    wp_enqueue_script(
        'dc-editor',
        get_stylesheet_directory_uri() . '/assets/scripts/editor.js',
        [ 'wp-blocks', 'wp-dom' ],
        filemtime( get_stylesheet_directory() . '/assets/scripts/editor.js' ),
        true
    );
} );

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
            'name'          => __('Before Header Section', 'sage'),
            'id'            => 'sidebar-before-header'
        ] + $config);
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Menu Eyebrow', 'sage'),
        'id'            => 'sidebar-menu'
    ] + $config);
    register_sidebar([
        'name'          => __('Under Footer Menu', 'sage'),
        'id'            => 'sidebar-footer-under-menu'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer Left', 'sage'),
        'id'            => 'sidebar-footer-left'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer Center', 'sage'),
        'id'            => 'sidebar-footer-center'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer Right', 'sage'),
        'id'            => 'sidebar-footer-right'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});

/**
 * ACF Color Picker Presets
 */
add_action( 'acf/input/admin_footer', function () {
    echo '
          <script>
          (function($) {
            acf.add_filter("color_picker_args", function( args, $field ){
                args.palettes = [ "' . COLOR_PRIMARY . '", "' . COLOR_SECONDARY . '", "' . COLOR_GRAY . '", "' . COLOR_BLACK . '" ]
                return args;

            });
          })(jQuery);
          </script>
        ';
} );

/**
 * Fix for search pagination
 */
add_action( 'pre_get_posts', function ( $q )
{
    if( !is_admin()
        && $q->is_main_query()
        && ( is_category() || is_search() || is_page() )
    ) {
        if ( is_search() ) {
            $q->set( 'posts_per_page', 100 );
        } else {
            $q->set( 'posts_per_page', 1 );
        }
    }
} );

/**
 * Custom Features Setup
 */
add_action( 'after_setup_theme', function() {
    App::setup();
} );
