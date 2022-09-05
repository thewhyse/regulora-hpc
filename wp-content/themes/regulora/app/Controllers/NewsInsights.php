<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class NewsInsights extends Controller
{
    public static $postType = 'post';

    public static $acfRelatedPractices  = "related_practices_rpb";
    public static $acfRelatedNews       = "related_news_insights";
    public static $acfRelatedAttorneys  = "key_contacts";
    public static $acfAlternateFeatured = "alternate_featured_image";
    public static $acfAlternateTitle    = "alternate_title";
    public static $acfAlternateLink     = "alternate_link";
    public static $acfAlternateLinkCTA  = "alternate_link_cta";

    public static $postsPerPage = 9;

    public static $instance;

    public static function setup()
    {
        // Setup instance
        static::$instance = new NewsInsights();
    }

    public static function showNews( $force = false )
    {
        if ( $force ) {
            return true;
        }

        if ( is_search() ) {
            return false;
        }

        if ( function_exists( 'get_field' ) && get_field( 'show_news_block' ) ) {
            return true;
        }

        if ( is_front_page() ) {
            return false;
        }
    }

    public static function posts( $limit = 0, $categoryFilter = 0, $paged = 0 )
    {
        global $wp_query;
        if ( ! $paged ) {
            $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        }

//        $filter = get_query_var( 'filter' ) ? get_query_var( 'filter' ) : '';
        if ( ! empty( $_GET[ 'category' ] ) && (int) $_GET[ 'category' ] > 0 ) {
            $categoryFilter =  (int) $_GET[ 'category' ];
        }

        $limit = $limit != 0 ? $limit : NewsInsights::$postsPerPage;

        $args = array(
            'posts_per_page'        => $limit,
            'post_type'             => NewsInsights::$postType,
            'post_status'           => 'publish',
            'suppress_filters'      => true,
            'paged'                 => $paged,
//            'category_name'         => $categoryFilter,
            'order'                 => 'DESC',
            'orderby'               => 'date',
            'ignore_sticky_posts'   => true
        );

        if ( $categoryFilter ) {
            $args[ 'cat' ] = $categoryFilter;
        }

        if ( ! empty( $args[ 'meta_query' ] ) ) {
            $args[ 'meta_query' ][ 'relation' ] = 'AND';
        }

        $postsQuery = new \WP_Query( $args );
        NewsInsights::$instance = $postsQuery;

        $news = array_map( function ( $post ) {
            return static::getFormattedData( $post );
        }, $postsQuery->posts );

        return $news;
    }

    public static function getFormattedData ( $post )
    {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
        $imageX2 = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
        $categories = wp_get_post_terms( $post->ID, array( 'category' ));

        $alternateTitle = get_field( static::$acfAlternateTitle, $post->ID );
        $alternateLink = get_field( static::$acfAlternateLink, $post->ID );
        $alternateLinkCTA = get_field( static::$acfAlternateLinkCTA, $post->ID );

        return [
            'id' => $post->ID,
            'image' => !empty($image) ? reset( $image ) : get_theme_mod( 'placeholder_image' ),
            'imageX2' => !empty($imageX2) ? reset( $imageX2 ) : get_theme_mod( 'placeholder_image' ),
            'title' => $alternateTitle ? $alternateTitle : get_the_title( $post->ID ),
            'excerpt' => get_the_excerpt( $post->ID ),
            'terms' => ( !empty( $categories ) ) ? $categories[0] : '',
            'type' => get_post_type( $post->ID ),
            'url' => $alternateLink ? $alternateLink : get_permalink( $post->ID ),
            'alternateLinkCTA' => $alternateLinkCTA,
            'authorId' => $post->post_author,
            'date' => get_the_date( 'F j, Y', $post->ID ),
        ];
    }

    public static function getHeroImage( $postID = 0 )
    {
        if ( $postID == 0 ) {
            $postID = get_the_ID();
        }

        $postThumbID = get_post_thumbnail_id( $postID );

        if ( $postThumbID ) {
            $image = wp_get_attachment_image_src( $postThumbID, App::$heroImageSize );
            $imageX2 = wp_get_attachment_image_src( $postThumbID, App::$heroX2ImageSize );

            return array(
                'heroDefaultImage'  => array(
                    'x1'    => $image[ 0 ],
                    'x2'    => $imageX2[ 0 ],
                ),
            );
        }
        return false;
    }

    public static function getRelatedNews( $postID = 0, $title = 'Related Wins & Insights' )
    {
        if ( $postID == 0 ) {
            $postID = get_the_ID();
        }

        if ( function_exists( 'get_field' ) ) {
            $news = get_field( static::$acfRelatedNews, $postID );
//        if ( !empty( $news ) ) {
//            usort( $news, function ( $a, $b ) {
//                return strcmp( $a->post_title, $b->post_title );
//            } );
//        }
        } else {
            $news = false;
        }

        if ( ! $news ) {
            $args = array(
                'posts_per_page'        => 3,
                'post_type'             => NewsInsights::$postType,
                'post_status'           => 'publish',
                'suppress_filters'      => true,
                'order'                 => 'DESC',
                'orderby'               => 'date',
                'ignore_sticky_posts'   => true
            );

            $postsQuery = new \WP_Query( $args );

            if ( $postsQuery->have_posts() ) {
                $news = $postsQuery->posts;
            } else {
                return false;
            }
        }

        $result = array_map( function ( $post ) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb-news-preview' );
            $imageX2 = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb-news-preview@x2' );
            $categories = wp_get_post_terms( $post->ID, array( 'category' ));
            // $author = get_field( NewsInsights::$acfAuthorName, $post->ID );

            return [
                'id' => $post->ID,
                'image' => !empty($image) ? reset( $image ) : get_theme_mod( 'placeholder_image' ),
                'imageX2' => !empty($imageX2) ? reset( $imageX2 ) : get_theme_mod( 'placeholder_image' ),
                'title' => get_the_title( $post->ID ),
                'excerpt' => str_replace( '...', '', get_the_excerpt( $post->ID ) ),
                'terms' => ( !empty( $categories ) ) ? $categories[0] : '',
                'type' => get_post_type( $post->ID ),
                'url' => get_permalink( $post->ID ),
                //'author' => $author,
                'authorId' => $post->post_author,
                'date' => get_the_date( 'F j, Y', $post->ID ),
                'useFullWidth' => true,
            ];
        }, $news );

        return array(
            'title' => $title,
            'news'  => $result,
        );
    }
}
