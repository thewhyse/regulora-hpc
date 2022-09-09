<?php

namespace App\Controllers\Modules;

use App\Controllers\App;

/**
 * Trait ModuleTestimonials
 * @package App\Controllers\Modules
 */

trait ModuleTwitter
{
    /**
     * Block settings
     */
    public static $blockTypeTweet = 'twitter';

    /**
     * Post type variables
     */
    public static $postTypeTweet = 'tweet';
    public static $postSlugTweet = 'tweets';
    public static $postSupportsTweet = array(
        'title',
        'custom-fields',
    );

    /**
     * ACF fields
     */
    public static $acfTweetText = 'tweet_text';
    public static $acfTweetHashtags = 'tweet_hashtags';
    public static $acfTweetHandle = 'tweet_handle';
    public static $acfTweetLink = 'tweet_link';
    public static $acfTweetsLimit = 'tweets_limit';
    public static $acfTweetsRandom = 'tweets_random';

    /**
     * Setup trait
     */
    public static function traitSetup()
    {
        static::tweetsPostType();

        add_action( 'acf/init', [ static::class, 'gutenbergBlockTweetsInit' ] );
    }

    public static function tweetsPostType()
    {
        register_post_type( static::$postTypeTweet,
            array(
                'label'              => __( 'Tweets' ),
                'singular_label'     => __( 'Tweet', 'sage' ),
                'labels'             => array(
                    'add_new_item' => __( 'Add New Tweet', 'sage' ),
                ),
                '_builtin'           => false,
                'public'             => true,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'exclude_from_search'=> true,
                'menu_icon'          => 'dashicons-twitter',
                'menu_position'      => 24,
                'rewrite'            => array(
                    'slug'       => static::$postSlugTweet,
                    'with_front' => false,
                ),
                'show_in_rest'       => true,
                'supports'           => static::$postSupportsTweet
            )
        );
    }

    public static function gutenbergBlockTweetsInit()
    {
        // Check function exists.
        if( function_exists('acf_register_block_type') ) {

            // Register a testimonial block.
            acf_register_block_type( array(
                'name'              => static::$blockTypeTweet,
                'title'             => __( 'Tweets' ),
                'description'       => __( 'Show block with Tweets' ),
                'keywords'          => array( 'tweet', 'slider', 'twitter' ),
                'icon'              => 'slides',
//                'align'             => 'full',
                'render_callback'   => [ static::class, 'renderBlockTweets' ],
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

    public static function renderBlockTweets( $block, $content = '', $is_preview = false, $post_id = 0 )
    {
        // Create id attribute allowing for custom "anchor" value.
        $id = 'tweets-slider-' . $block[ 'id' ];
        if( !empty( $block[ 'anchor' ] ) ) {
            $id = $block[ 'anchor' ];
        }

        // Create class attribute allowing for custom "className" and "align" values.
        $className = 'tweetsSlider';
        if( !empty( $block[ 'className' ] ) ) {
            $className .= ' ' . $block['className'];
        }
        if( !empty($block['align']) ) {
            $className .= ' align' . $block[ 'align' ];
        }

        $time = time() . $block[ 'id' ];

        $limit = get_field( static::$acfTweetsLimit );
        $random = get_field( static::$acfTweetsRandom );
        $testimonials = static::getTweets( $limit, $random );
        $arrowsLgClass = ( count( $testimonials ) > 1 ) ? 'd-none d-lg-block' : 'd-none';
        $arrowsSmClass = ( count( $testimonials ) > 1 ) ? 'd-flex d-lg-none' : 'd-none';
        ?>
        <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
            <div class="inner-container wp-block-tweets-slider">
                <?php if ( $testimonials ) : ?>
                    <div class="slider-container">
                        <div class="slider-inner">
                            <div class="prev-but-place desktop <?=$arrowsLgClass?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"/></svg>
                            </div>
                            <div class="tweets-slider">
                                <?php foreach ( $testimonials as $index => $item ) : ?>
                                    <div class="slide-item position-relative">
                                        <div class="slide-content">
                                            <div class="isc">
                                                <?= $item[ 'content' ] ?>&nbsp;&nbsp;<strong><?= $item[ 'hashtags' ] ?></strong>
                                            </div>
                                            <?php if ( $item[ 'tweetHandle' ] ) : ?>
                                                <div class="tweet-handle">
                                                    <?= $item[ 'tweetHandle' ] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ( $item[ 'tweetLink' ] ) : ?>
                                            <a href="<?= $item[ 'tweetLink' ] ?>" class="stretched-link" target="_blank"></a>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="next-but-place desktop <?=$arrowsLgClass?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/></svg>
                            </div>
                            <div class="controll-buttons <?=$arrowsSmClass?>">
                                <div class="prev-but-place mobile">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"/></svg>
                                </div>
                                <div class="next-but-place mobile">
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

    public static function getTweets( $limit = 10, $random = false )
    {
        $args = array(
            'posts_per_page'        => $limit,
            'post_type'             => static::$postTypeTweet,
            'post_status'           => 'publish',
            'suppress_filters'      => true,
            'ignore_sticky_posts'   => true,
            'orderby'               => $random ? 'rand' : 'date',
            'order'                 => 'DESC'
        );

        $posts = new \WP_Query( $args );

        return  array_map( function( $post ) {
            $tweetText = get_field( static::$acfTweetText, $post->ID );
            $tweetHashtags = get_field( static::$acfTweetHashtags, $post->ID );
            $tweetHashtags = get_field( static::$acfTweetHashtags, $post->ID );
            $tweetHandle   = get_field( static::$acfTweetHandle, $post->ID );
            $tweetLink     = get_field( static::$acfTweetLink, $post->ID );
            return array(
                'id'            => $post->ID,
                'hashtags'      => $tweetHashtags,
                'tweetHandle'   => $tweetHandle,
                'tweetLink'     => $tweetLink,
                'content'       => "<span>&ldquo;" . $tweetText . "&rdquo;</span>",
            );
        }, $posts->posts );
    }
}
