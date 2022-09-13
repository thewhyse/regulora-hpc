<?php

namespace App\Controllers\Modules;

use App\Controllers\App;

/**
 * Trait ModuleTestimonials
 * @package App\Controllers\Modules
 */

trait ModuleTestimonials
{
    /**
     * Block settings
     */
    public static $blockTypeSlider = 'testimonials';

    /**
     * Post type variables
     */
    public static $postType = 'testimonial';
    public static $postSlug = 'testimonials';
    public static $testimonialsTaxonomy = 'testimonials_cat';
    public static $postSupports = array(
        'title',
        'editor',
        'custom-fields',
    );

    /**
     * ACF fields
     */
    public static $acfPdfLink = 'pdf_link';
    public static $acfViewType = 'view_type';
    public static $acfLimit = 'show_limit';
    public static $acfShowRandom = 'show_random';
    public static $acfShowCategory = 'show_category';

    /**
     * Setup trait
     */
    public static function traitSetup()
    {
        static::testimonialsPostType();

        add_action( 'acf/init', [ static::class, 'gutenbergBlockTestimonialsInit' ] );
    }

    public static function testimonialsPostType()
    {
        register_post_type( static::$postType,
            array(
                'label'              => __( 'Testimonials' ),
                'singular_label'     => __( 'Testimonial', 'sage' ),
                'labels'             => array(
                    'add_new_item' => __( 'Add New Testimonial', 'sage' ),
                ),
                '_builtin'           => false,
                'public'             => true,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'exclude_from_search'=> true,
                'menu_icon'          => 'dashicons-format-chat',
                'menu_position'      => 24,
                'rewrite'            => array(
                    'slug'       => static::$postSlug,
                    'with_front' => false,
                ),
                'show_in_rest'       => true,
                'supports'           => static::$postSupports
            )
        );

        register_taxonomy( static::$testimonialsTaxonomy, array( static::$postType ), array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x( 'Categories', 'sage' ),
                'singular_name' => _x( 'Category', 'sage' ),
                'search_items' =>  __( 'Search Categories', 'sage' ),
                'all_items' => __( 'All Categories', 'sage' ),
                'edit_item' => __( 'Edit Category', 'sage' ),
                'update_item' => __( 'Update Category', 'sage' ),
                'add_new_item' => __( 'Add New Category', 'sage' ),
                'new_item_name' => __( 'New Category Name', 'sage' ),
                'menu_name' => __( 'Categories', 'sage' ),
            ),
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => static::$testimonialsTaxonomy ),
        ) );
    }

    public static function gutenbergBlockTestimonialsInit()
    {
        // Check function exists.
        if( function_exists('acf_register_block_type') ) {

            // Register a testimonial block.
            acf_register_block_type( array(
                'name'              => static::$blockTypeSlider,
                'title'             => __( 'Testimonials' ),
                'description'       => __( 'Show block with Testimonials' ),
                'keywords'          => array( 'testimonial', 'slider', 'feedback' ),
                'icon'              => 'slides',
//                'align'             => 'full',
                'render_callback'   => [ static::class, 'renderBlockTestimonials' ],
                'category'          => 'common',
//                'enqueue_script'    => get_stylesheet_directory_uri() . '/assets/scripts/components/step-slider.js',
                'supports'          => array(
                    'align'             => array( 'left', 'right', 'center', 'wide', 'full' ),
                    'align_content'     => true,
                    'full_height'       => true,
                    'mode'              => true,
                    'multiple'          => true,
                ),
            ) );
        }
    }

    public static function renderBlockTestimonials( $block, $content = '', $is_preview = false, $post_id = 0 )
    {
        // Create id attribute allowing for custom "anchor" value.
        $id = 'testimonials-slider-' . $block[ 'id' ];
        if( !empty( $block[ 'anchor' ] ) ) {
            $id = $block[ 'anchor' ];
        }

        // Create class attribute allowing for custom "className" and "align" values.
        $className = 'testimonialSlider';
        if( !empty( $block[ 'className' ] ) ) {
            $className .= ' ' . $block['className'];
        }
        if( !empty($block['align']) ) {
            $className .= ' align' . $block[ 'align' ];
        }

        $time = time() . $block[ 'id' ];

        $viewType = get_field( static::$acfViewType );
        $limit = get_field( static::$acfLimit );
        $category = get_field( static::$acfShowCategory );
        $random = get_field( static::$acfShowRandom );
        $testimonials = static::getTestimonials( $category, $limit, $random );
        ?>
        <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
            <div class="inner-container wp-block-testimonials-slider view-<?=$viewType?>">
                <?php if ( $testimonials ) : ?>
                    <div class="slider-container">
                        <div class="slider-inner">
                            <div class="prev-but-place desktop <?= ( $viewType === 'head' ? 'd-block mobile' : 'd-none d-lg-block' ) ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"/></svg>
                            </div>
                            <div class="testimonials-slider">
                                <?php foreach ( $testimonials as $index => $item ) : ?>
                                    <div class="slide-item">
                                        <div class="slide-content">
                                            <?=App::svg( 'quote', 'quote' )?>
                                            <?= $item[ 'content' ] ?>
                                        </div>
                                        <?php if ( $viewType === 'default' && $item[ 'pdfLink' ] ) : ?>
                                            <a href="<?=$item[ 'pdfLink' ]?>" class="pdfLink" target="_blank">Review the evidence</a>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="next-but-place desktop <?= ( $viewType === 'head' ? 'd-block mobile' : 'd-none d-lg-block' ) ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/></svg>
                            </div>
                            <div class="controll-buttons <?= ( $viewType === 'head' ? 'd-none' : 'd-flex d-lg-none' ) ?>">
                                <div class="prev-but-place <?= ( $viewType === 'head' ? '' : 'mobile' ) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"/></svg>
                                </div>
                                <div class="next-but-place <?= ( $viewType === 'head' ? '' : 'mobile' ) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    public static function getTestimonials( $category = false, $limit = 10, $random = false )
    {
        $args = array(
            'posts_per_page'        => $limit,
            'post_type'             => static::$postType,
            'post_status'           => 'publish',
            'suppress_filters'      => true,
            'ignore_sticky_posts'   => true,
            'orderby'               => $random ? 'rand' : 'date',
            'order'                 => 'DESC'
        );

        if ( $category ) {
            $args[ 'tax_query' ] = array(
                array(
                    'taxonomy' => static::$testimonialsTaxonomy,
                    'field'    => 'term_id',
                    'terms'    => $category
                )
            );
        }

        $posts = new \WP_Query( $args );

        return  array_map( function( $post ) {
            $pdfLink = get_field( static::$acfPdfLink, $post->ID );
            return array(
                'id'        => $post->ID,
                'pdfLink'    => $pdfLink,
                'content'      => apply_filters( 'the_content', $post->post_content ),
            );
        }, $posts->posts );
    }
}
