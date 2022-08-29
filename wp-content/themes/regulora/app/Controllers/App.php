<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    // Connect modules
    use Helpers\HelperImages,
        Helpers\HelperSettings,
        Modules\ModuleBlockContent,
        Modules\ModuleFaq,
        Modules\ModuleTestimonials,
        Modules\ModuleTwitter
    {
        Helpers\HelperImages::traitSetup insteadof Helpers\HelperSettings;
        Helpers\HelperImages::traitSetup insteadof Modules\ModuleBlockContent;
        Helpers\HelperImages::traitSetup insteadof Modules\ModuleFaq;
        Helpers\HelperImages::traitSetup insteadof Modules\ModuleTestimonials;
        Helpers\HelperImages::traitSetup insteadof Modules\ModuleTwitter;
        Helpers\HelperImages::traitSetup as traitSetupHI;
        Helpers\HelperSettings::traitSetup as traitSetupHS;
        Modules\ModuleBlockContent::traitSetup as traitSetupBC;
        Modules\ModuleFaq::traitSetup as traitSetupFAQ;
        Modules\ModuleTestimonials::traitSetup as traitSetupTestimonials;
        Modules\ModuleTwitter::traitSetup as traitSetupTwitter;
    }

    public static function setup()
    {
        // Traits setup
        static::traitSetupHI();
        static::traitSetupHS();
        static::traitSetupBC();
        static::traitSetupFAQ();
        static::traitSetupTestimonials();
        static::traitSetupTwitter();
    }

    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Page Not Found', 'sage');
        }
        return get_the_title();
    }

    public static function siteLogo( string $type = NULL ) {
        switch ( $type ) {
            case 'footer' :
                $type = 'footer_logo';
                break;
            default:
                $type = 'custom_logo';
        }

        $logo    = '';
        $logo_id = get_theme_mod( $type );

        if ( $image_data = wp_get_attachment_image_src( $logo_id, 'full' ) ) {
            if ( strpos( $image_data[0], '.svg' ) !== false ) {
                $servPath = realpath( $_SERVER['DOCUMENT_ROOT'] . parse_url( esc_url( $image_data[0] ), PHP_URL_PATH ) );
                $logo     = file_get_contents( $servPath );
            } else {
                $logo = '<img src="' . esc_url( $image_data[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" />';
            }
        }

        return $logo ?: '<h1>' . get_bloginfo( 'name', 'display' ) . '</h1>';
    }

    public static function siteFooterCopyright()
    {
        $copyright = get_theme_mod( 'true_footer_copyright_text' );
        $copyright = str_replace(
            array('%year%'),
            array(date('Y')),
            $copyright
        );
        if ( !empty ( $copyright ) )
            return '<div class="footer-copyright">
                        <p>' . $copyright . '</p>
                    </div>';
    }

    public static function backLink( $link = '', $text = '' )
    {
        $link = ( !empty( $link ) ) ? $link : '#';

        if( is_singular( \Attorney::$postType ) ) {
            $text = "Our Attorneys";
            $link = "/attorneys/";
        }

        if ( is_singular( 'post' ) ) {
            $text = "Wins & Insights";
            $link = "/wins-insights/";
        }

        if( is_singular( 'practice' ) ) {
            $text = "Practices";
            $link = "/our-work/";
        }

        if ( isset( $_GET[ 'destination' ] ) ) {
            $link .= $_GET[ 'destination' ];
        }

        return "<a href='{$link}' class='back-link underlined'><span class='arrow via-border to-left'></span>{$text}</a>";
    }

    public static function dc_pagination( $instance = null, $category = 0 )
    {
        global $wp_query;

        if ( empty( $instance ) ) {
            $instance = $wp_query;
        }

        $total = isset( $instance->max_num_pages ) ? $instance->max_num_pages : 1;
        $args = array(
            'show_all'      => false,
            'prev_next'     => true,
            'prev_text'    => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-double-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-chevron-double-left fa-w-16 fa-2x"><path fill="currentColor" d="M34.5 239L228.9 44.7c9.4-9.4 24.6-9.4 33.9 0l22.7 22.7c9.4 9.4 9.4 24.5 0 33.9L131.5 256l154 154.7c9.3 9.4 9.3 24.5 0 33.9l-22.7 22.7c-9.4 9.4-24.6 9.4-33.9 0L34.5 273c-9.3-9.4-9.3-24.6 0-34zm192 34l194.3 194.3c9.4 9.4 24.6 9.4 33.9 0l22.7-22.7c9.4-9.4 9.4-24.5 0-33.9L323.5 256l154-154.7c9.3-9.4 9.3-24.5 0-33.9l-22.7-22.7c-9.4-9.4-24.6-9.4-33.9 0L226.5 239c-9.3 9.4-9.3 24.6 0 34z" class=""></path></svg><span class="meta-nav screen-reader-text">' . __( 'Previous page', 'yourtheme' ) . ' </span>',
            'next_text'    => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-double-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-chevron-double-right fa-w-16 fa-2x"><path fill="currentColor" d="M477.5 273L283.1 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.7-22.7c-9.4-9.4-9.4-24.5 0-33.9l154-154.7-154-154.7c-9.3-9.4-9.3-24.5 0-33.9l22.7-22.7c9.4-9.4 24.6-9.4 33.9 0L477.5 239c9.3 9.4 9.3 24.6 0 34zm-192-34L91.1 44.7c-9.4-9.4-24.6-9.4-33.9 0L34.5 67.4c-9.4 9.4-9.4 24.5 0 33.9l154 154.7-154 154.7c-9.3 9.4-9.3 24.5 0 33.9l22.7 22.7c9.4 9.4 24.6 9.4 33.9 0L285.5 273c9.3-9.4 9.3-24.6 0-34z" class=""></path></svg><span class="meta-nav screen-reader-text">' . __( 'Next page', 'yourtheme' ) . ' </span>',
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'yourtheme' ) . ' </span>',
//            'after_page_number'  => '<span class="delimiter">|</span>',
            'total'         => $total,
            'mid_size'      => 2,
            'end_size'      => 1,
            'add_args'      => array(),
        );

        if ( $category ) {
            if ( is_array( $category ) ) {
                $category = implode( ',', $category );
            }

            $args[ 'base' ] = get_category_link($category) . '%_%';
        }

        if ( $total > 1 ) echo '<nav class="pagination">';
        echo paginate_links( $args );
        if ( $total > 1 ) echo '</nav>';

    }
}
