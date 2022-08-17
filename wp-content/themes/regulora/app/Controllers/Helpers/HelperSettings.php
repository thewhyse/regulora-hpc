<?php

namespace App\Controllers\Helpers;

use WebPConvert\WebPConvert;

/**
 * Trait ModuleTestimonials
 * @package App\Controllers\Modules
 */

trait HelperSettings
{
    /**
     * Class config
    */
    public static $defaultImageSize  = 'large';
    public static $heroImageSize     = 'background-fullwidth';
    public static $heroX2ImageSize   = 'background-fullwidth@x2';
    public static $placeholderImageSize     = 'attorney';
    public static $placeholderX2ImageSize   = 'full';
    public static $placeholderImageSizePost     = 'thumb-news-preview';
    public static $placeholderX2ImageSizePost   = 'thumb-news-preview@x2';

    /**
     * ACF Fields
     */
    public static $attorneyDefaultImage      = 'default_hero_image';
    public static $attorneyPlaceholderImage  = 'attorney_placeholder_image';
    public static $attorneyTaxonomyOrder     = 'attorney_taxonomy_order';
    public static $postPlaceholderImage      = 'post_placeholder_image';
    public static $practicesDefaultImage     = 'default_hero_image_practice';
    public static $notFoundPage              = 'not_found_page';
    public static $useWebpConverter          = 'use_webp_converter';

    /**
     * Setup trait
     */
    public static function traitSetup()
    {
        // Nothing Here
    }

    public static function themeOptions( $part = NULL )
    {
        $options = array();

        if ( ! function_exists('get_field') ) {
            return $options;
        }

        // Attorney Setings
        $heroImage = get_field( static::$attorneyDefaultImage, 'option' );
        if ( $heroImage ) {
            $heroImage_X1 = wp_get_attachment_image_src( $heroImage, static::$heroImageSize, false );
            $heroImage_X2 = wp_get_attachment_image_src( $heroImage, static::$heroX2ImageSize, false );

            $options[ 'attorney' ] = array(
                'heroDefaultImage'  => array(
                    'x1'    => $heroImage_X1[ 0 ],
                    'x2'    => $heroImage_X2[ 0 ],
                ),
            );
        }

        // Attorney Image Placeholder
        $attorneyPlaceholderImage = get_field( static::$attorneyPlaceholderImage, 'option' );
        if ( $attorneyPlaceholderImage ) {
            $placeholderImage_X1 = wp_get_attachment_image_src( $attorneyPlaceholderImage, static::$placeholderImageSize, false );
            $placeholderImage_X2 = wp_get_attachment_image_src( $attorneyPlaceholderImage, static::$placeholderX2ImageSize, false );

            if ( ! isset( $options[ 'attorney' ] ) ) {
                $options[ 'attorney' ] = array();
            }

            $options[ 'attorney' ][ 'placeholderImage' ]  = array(
                'x1'    => $placeholderImage_X1[ 0 ],
                'x2'    => $placeholderImage_X2[ 0 ],
            );
        }

        // Posts Placeholder
        $postsPlaceholderImage = get_field( static::$postPlaceholderImage, 'option' );
        if ( $postsPlaceholderImage ) {
            $placeholderImage_X1 = wp_get_attachment_image_src( $postsPlaceholderImage, static::$placeholderImageSizePost, false );
            $placeholderImage_X2 = wp_get_attachment_image_src( $postsPlaceholderImage, static::$placeholderX2ImageSizePost, false );

            $options[ 'posts' ] = array(
                'placeholderImage'  => array(
                    'x1'    => $placeholderImage_X1[ 0 ],
                    'x2'    => $placeholderImage_X2[ 0 ],
                ),
            );
        }

        // Practices
        $heroImagePractices = get_field( static::$practicesDefaultImage, 'option' );
        if ( $heroImagePractices ) {
            $heroImage_X1 = wp_get_attachment_image_src( $heroImagePractices, static::$heroImageSize, false );
            $heroImage_X2 = wp_get_attachment_image_src( $heroImagePractices, static::$heroX2ImageSize, false );

            $options[ 'global' ] = array(
                'heroDefaultImage'  => array(
                    'x1'    => $heroImage_X1[ 0 ],
                    'x2'    => $heroImage_X2[ 0 ],
                ),
            );
        }

        // 404 Page
        $options[ '404page' ] = get_field( static::$notFoundPage, 'option' );
        if ( ! isset( $options[ '404page' ] ) ) {
            $options[ '404page' ] = false;
        }

        // WebP
        $options[ 'webp' ] = get_field( static::$useWebpConverter, 'option' );
        if ( ! isset( $options[ 'webp' ] ) ) {
            $options[ 'webp' ] = false;
        }

        if ( $part && isset( $options[ $part ] ) ) {
            return $options[ $part ];
        }

        return $options;
    }
}
