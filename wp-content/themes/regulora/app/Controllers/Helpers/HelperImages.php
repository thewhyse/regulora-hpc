<?php

namespace App\Controllers\Helpers;

use App\Controllers\App;
use App\Controllers\Attorney;
use WebPConvert\WebPConvert;

/**
 * Trait ModuleTestimonials
 * @package App\Controllers\Modules
 */

trait HelperImages
{
    /**
     * Class config
    */
    protected static $useWebP       = true;
    protected static $defaultSize   = 'large';

    /**
     * Setup trait
     */
    public static function traitSetup()
    {
        // Thumbnail sizes
        add_image_size( 'attorney-square', 250, 250, array( 'center', 'center' ) );
        add_image_size( 'attorney-square@x2', 500, 500, array( 'center', 'center' ) );
        add_image_size( 'attorney', 750, 500, false );
        add_image_size( 'attorney@x2', 1500, 1000, array( 'center', 'center' ) );
        add_image_size( 'thumb-news-preview', 450, 300, true );
        add_image_size( 'thumb-news-preview@x2', 900, 600, true );
        add_image_size( 'background-fullwidth-mobile', 9999, 460, false );
        add_image_size( 'background-fullwidth', 2300, 1100, false );
        add_image_size( 'background-fullwidth@x2', 3840, 9999, false );

        add_filter( 'image_size_names_choose', function ( $sizes ) {
            return array_merge( $sizes, array(
                'attorney' => __( 'Attorney' ),
                'attorney-square' => __( 'Attorney Square' ),
                'thumb-news-preview' => __( 'News 3x2' ),
                'background-fullwidth' => __( 'Fullwidth FHD' ),
            ) );
        } );

        add_filter( 'wp_get_attachment_image', function ( $html, $attachment_id, $size, $icon, $attr ) {
            if ( \App\Controllers\App::themeOptions( 'webp' ) && ! is_admin() ) {
                $image = wp_get_attachment_image_src( $attachment_id, $size );
                $imageX2 = wp_get_attachment_image_src( $attachment_id, 'full' );
                $html = '<picture class="' . $attr[ 'class' ] . ' converted-in-helper">
                      <source srcset="' . App::webpConvert( $image[ 0 ] ) . ' 1x, ' . App::webpConvert( $imageX2[ 0 ] ) . ' 2x" type="image/webp" aria-label="' . $attr[ 'alt' ] . '">
                      <source srcset="' . $attr[ 'srcset' ] . '" type="image/jpeg" aria-label="' . $attr[ 'alt' ] . '">
                      <img src="' . $attr[ 'src' ] . '" class="' . $attr[ 'class' ] . '" alt="' . $attr[ 'alt' ] . '" width="' . $image[ 1 ] . '" height="' . $image[ 2 ] . '" loading="lazy">
                    </picture>';
            }
            return $html;
        }, 10, 5 );

        add_filter('the_content', function ( $content ){
//            global $post;
////            preg_match_all( "/<img(.*?)class=('|\" )(.*?)( '|\")(.*?)src=('|\")(.*?)('|\")(.*?)>/i", $content, $images );
//            preg_match_all( "/<img(.*?)>/i", $content, $images );
//
//            if( ! empty( $images[ 0 ] ) ) {
//                var_dump($images);
//                $imageTags = $images[ 0 ];
//                foreach( $imageTags as $img ) {
//
//                }
//                $imageLinks = $images[ 3 ];
//                $i = -1;
//                foreach ($images as $key) {
//                    $i++;
//                    //echo $key[$i];
//                    if(strpos($images[3][$i], 'size-full') !== false){
//                        //echo "hi";
//                        $slika_ekstenzija = $images[7][$i];
//                        $sewebp = preg_replace('/\\.[^.\\s]{3,4}$/', '', $slika_ekstenzija);
//                        $webp_slika_src = $sewebp.".webp";
//                        $replacement = '<picture><source srcset="'.$webp_slika_src.'" type="image/webp" /><img'.$images[1][$i].'class='.$images[2][$i].$images[3][$i].$images[4][$i].$images[5][$i].'src='.$images[6][$i].$images[7][$i].$images[8][$i].$images[9][$i].'></picture>';
//                        $content = str_replace($images[0][$i], $replacement, $content);
//                    }
//                }
//            }

            return $content;
        }, 9999);
    }

    // Converting image ID to data array of image
    public static function getImageDataByID ( int $imgID = NULL, string $size = NULL )
    {
        if ( ! $imgID )
            return false;

        $size = $size ?? static::$defaultSize;

        $imageData = wp_get_attachment_image( $imgID, $size );

        return $imageData;
    }

    public static function svg( $name, $class = '', $removeEncode = false, $ariaLabel = false )
    {
        $file = get_theme_file_path() . '/resources/assets/images/icons/' . $name . '.svg';
        if ( ! file_exists( $file ) ) {
            return false;
        }
        $svg = file_get_contents( $file );

        if ( $class ) {
            $svg = str_replace( '<svg', "<svg class='{$class}'", $svg );
        }

        if ( $ariaLabel ) {
            $svg = str_replace( '<svg', "<svg aria-label='{$ariaLabel}'", $svg );
        }


        if ( $removeEncode ) {
            $svg = str_replace( '<?xml version="1.0" encoding="UTF-8"?>', '', $svg );
        }

        return $svg;
    }

    /**
     * @param string $file path to file with filename
     * @param string $destination path to destination file, empty if return is true
     */
    public static function webpConvert( $file, $destination = '' )
    {
        // TODO: Remove before deploy
        if ( is_admin() ) {
            return $file;
        }

        $starterFile = $file;
        if ( strpos( $file, home_url() ) !== false ) {
            $file = str_replace( home_url(), '', $file );
            $file = ABSPATH . $file;
            $file = str_replace( '//', '/', $file );
        }
        if ( !file_exists( $file ) ) {
            return false;
        }
        $source = $file;
        if ( !empty( $destination ) ) {
            if ( strpos( $destination, home_url() ) !== false ) {
                $destination = str_replace( home_url(), '', $destination );
                $destination = str_replace( home_url(), '', $destination );
                $destination = ABSPATH . $destination;
                $destination = str_replace( '//', '/', $destination );
            }
        } else {
            $destination = str_replace( pathinfo( $source, PATHINFO_EXTENSION ), '', $source) . 'webp';
        }

        if ( file_exists( $destination ) ) {
            $destination = str_replace( ABSPATH, '', $destination );
            if ( $destination[0] != '/' ) {
                $destination = '/' . $destination;
            }
            $destination = home_url() . $destination;
            return $destination;
        }

        WebPConvert::convert( $source, $destination, array(
            'stack-converters' => [/*'cwebp', 'vips', 'imagick', 'gmagick', 'imagemagick', 'graphicsmagick', 'wpc', 'ewww',*/ 'gd'],
            'converter-options' => [
                'gd' => [
                    'quality' => 100
                ],
            ]
        ) );
        $destination = str_replace( ABSPATH, '', $destination );
        if ( ! file_exists( $destination ) ) {
            return $starterFile;
        }
        if ( $destination[0] != '/' ) {
            $destination = '/' . $destination;
        }
        $destination = home_url() . $destination;

        return $destination;
    }

    /**
     * Function to set hero image as background for any block
     * @param string $selectorCSS block class
     * @param null $image image src
     * @param null $imageX2 image src
     * @param null $fallbackImage image src
     * @param string $backgroundColor HEX color
     * @param string $bgSize options cover|contain|100%
     * @return string
     */
    public static function setHeroBackgroundImage( $selectorCSS, $image = NULL, $imageX2 = NULL, $fallbackImage = NULL, $backgroundColor = 'transparent', $bgSize = 'cover' )
    {
        if ( ! $image && $fallbackImage ) {
            $image = $fallbackImage;
        }
        $styles = "
        <style>
            .{$selectorCSS} {
              background-color: $backgroundColor;
              background-size: $bgSize;
              background-position: center;
              background-repeat: no-repeat;
              image-rendering: optimizeQuality;
              -ms-interpolation-mode: nearest-neighbor;  /* IE (non-standard property) */
              background-image: url( " . App::webpConvert( $image ) . " );
            }
            .ie .{$selectorCSS},
            .no-webp .{$selectorCSS} {
              background-image: url( " . $image . " );
            }
        ";

        if ( $imageX2 ) {
            $styles .= "
            @media (min-width: 1921px),
            only screen and (-webkit-min-device-pixel-ratio: 1.5),
            only screen and (min--moz-device-pixel-ratio: 1.5),
            only screen and (-o-min-device-pixel-ratio: 3/2),
            only screen and (min-resolution: 1.5dppx),
            only screen and (min-resolution: 144dpi) {
              .{$selectorCSS} {
                background-image: url( " . App::webpConvert( $imageX2 ) . " );
              }
              .ie .{$selectorCSS},
              .no-webp .{$selectorCSS} {
                background-image: url( " . $imageX2 . " );
              }
            }
            ";
        }

        $styles .= "</style>";

        return $styles;
    }

    /**
     * Get attachment image with webP
     */
    public static function getFeaturedImage( $postID = NULL, $alt = NULL, $class = 'img-fluid' )
    {
        if ( ! $postID ) {
            $postID = get_the_ID();
        }

        $postThumb = get_post_thumbnail_id( $postID );

        $image      = wp_get_attachment_image_src( $postThumb, 'thumb-news-preview' );
        $imageX2    = wp_get_attachment_image_src( $postThumb, 'thumb-news-preview@x2' );

        $isDefaultImage = 'post-featured-image';

        if ( ! $image ) {
            return '';
        }

        $html = '
        <picture class="' . $isDefaultImage . '">
          <source srcset="' . App::webpConvert( $image[ 0 ] ) . ' 1x, ' . App::webpConvert( $imageX2[ 0 ] ) . ' 2x" type="image/webp" aria-label="' . $alt . '">
          <source srcset="' . $image[ 0 ] . ' 1x, ' . $imageX2[ 0 ] . ' 2x" type="image/jpeg" aria-label="' . $alt . '">
          <img src="' . $image[ 0 ] . '" class="' . $class . '" alt="' . $alt . '">
        </picture>
        ';

        return $html;
    }
}
