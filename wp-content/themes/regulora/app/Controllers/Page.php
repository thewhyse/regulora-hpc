<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Page extends Controller
{
    public static $postType = 'page';

    public static $acfHeaderTitleColor = 'header_text_color';

    public static $instance;

    public static function setup()
    {
        // Setup instance
        static::$instance = new Page();
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

    public static function getPageTitleColor( $postID = 0 )
    {
        if ( ! $postID ) {
            $postID = get_the_ID();
        }
        return get_field( static::$acfHeaderTitleColor, $postID );
    }
}
