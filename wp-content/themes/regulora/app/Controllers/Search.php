<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Search extends Controller
{
    private $post_types;

    public $instance;

    public static $queryInstance;

    public $wp_query;

    public $searchQuery;

    public $results;

    public static function results( $action = 'results' )
    {
        $search = new Search();
        $search->instance = $search;

        if ( $action == 'results' ) {
            return $search->getResultsByPostType();
        }

        if ( $action == 'totalCount' ) {
            $total = 0;
            foreach ( $search->getResultsByPostType() as $postType ) {
                $total += $postType['total'];
            }
            return $total;
        }
    }

    public function __construct()
    {
        global $wp_query;

        $this->post_types = array(
//            Attorney::$postType,
//            Practices::$postType,
            NewsInsights::$postType,
            Page::$postType,
        );

        if ( !is_admin() && get_search_query() ) {
            $this->wp_query = $wp_query;
            $this->searchQuery = get_search_query();
        }
    }

    public function getResultsByPostType()
    {
        $args = array(
            's' => $this->searchQuery,
            'ignore_sticky_posts' => true,
            'post_status' => 'publish',
//            'posts_per_page' => 6,
        );

        $currentPostType = ( isset( $_GET[ 'post_type' ] ) ) ? $_GET[ 'post_type' ] : 'any';

        if ( $currentPostType != 'any' && in_array( $currentPostType, $this->post_types ) ) {
            $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

            if ( isset( $args['meta_query'] ) ) {
                unset( $args['meta_query'] );
            }
            if ( isset( $args['tax_query'] ) ) {
                unset( $args['tax_query'] );
            }

            if ( isset( $args['orderby'] ) ) {
                unset( $args['orderby'] );
            }

            if ( isset( $args['order'] ) ) {
                unset( $args['order'] );
            }

            $args['post_type'] = $currentPostType;
            if ( $exclude = Search::excludeIdsFromSearch() ) {
                $args['post__not_in'] = $exclude;
            }

//            if ( $addSearchQuery = Search::addMetaSearch( $currentPostType, $this->searchQuery ) ) {
//                if ( isset( $args['meta_query'] ) ) {
//                    $args['meta_query'][] = $addSearchQuery;
//                } else {
//                    $args['meta_query'] = $addSearchQuery;
//                }
//                $args['_meta_query_relation'] = 'OR';
//            }

            $limit = 9;
            $args['posts_per_page'] = $limit;
            $args['paged'] = $paged;
            $query = new \WP_Query( $args );

            Search::$queryInstance = $query;

            $this->results[$currentPostType] = array(
                'total'     => $query->found_posts,
                'showedNum' => ( $paged * $limit - ( $limit - 1 ) ) . "-" . ( ( $paged * $limit ) <= $query->found_posts ? $paged * $limit : $query->found_posts ),
                'posts'     => $query->posts,
                'sql'       => $query->request,
            );
        } else {
            foreach ( $this->post_types as $post_type ) {
                $args['post_type'] = $post_type;

                $args[ 'posts_per_page' ] = 3;
                if ( isset( $args['meta_query'] ) ) {
                    unset( $args['meta_query'] );
                }

                if ( isset( $args['tax_query'] ) ) {
                    unset( $args['tax_query'] );
                }

                if ( isset( $args['orderby'] ) ) {
                    unset( $args['orderby'] );
                }

                if ( isset( $args['order'] ) ) {
                    unset( $args['order'] );
                }

                if ( $exclude = Search::excludeIdsFromSearch() ) {
                    $args['post__not_in'] = $exclude;
                }

                $query = new \WP_Query( $args );

                $this->results[$post_type] = array(
                    'total' => $query->found_posts,
                    'posts' => $query->posts,
                    'sql'   => $query->request,
                );
            }
        }

        return $this->results;
    }

    public static function excludeIdsFromSearch()
    {
        global $wpdb;
        $query = $wpdb->get_results( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = 'exclude_from_search' AND meta_value = 1" );

        if ( ! $query ) {
            return array();
        }

        return array_map( function( $item ) {
            return $item->post_id;
        }, $query );
    }
}
