<?php

namespace App\Controllers\Modules;

/**
 * Trait ModuleTestimonials
 * @package App\Controllers\Modules
 */

trait ModuleSlider
{
    // Block settings
    public static $blockTypeSlider = 'slider';
    /**
     * ACF fields
     */
    public static $acfSlides = 'slides';
    public static $acfUseSteps = 'use_steps_on_the_top';

    /**
     * Setup trait
     */
    public static function traitSetup()
    {
        add_action( 'acf/init', [ static::class, 'gutenbergBlockSliderInit' ] );
    }

    public static function gutenbergBlockSliderInit()
    {
        // Check function exists.
        if( function_exists('acf_register_block_type') ) {

            // Register a testimonial block.
            acf_register_block_type( array(
                'name'              => static::$blockTypeSlider,
                'title'             => __( 'Slider' ),
                'description'       => __( 'Show block with Slider' ),
                'keywords'          => array( 'slider', 'slide', 'step' ),
                'icon'              => 'slides',
//                'align'             => 'full',
                'render_callback'   => [ static::class, 'renderBlockSlider' ],
                'category'          => 'common',
//                'enqueue_script'    => get_stylesheet_directory_uri() . '/assets/scripts/components/step-slider.js',
                'supports'          => array(
                    'align'             => array( 'center', 'wide', 'full' ),
                    'align_content'     => true,
                    'full_height'       => true,
                    'mode'              => true,
                    'multiple'          => true,
                ),
            ) );
        }
    }

    public static function renderBlockSlider( $block, $content = '', $is_preview = false, $post_id = 0 )
    {
        // Create id attribute allowing for custom "anchor" value.
        $id = 'step-slider-' . $block[ 'id' ];
        if( !empty( $block[ 'anchor' ] ) ) {
            $id = $block[ 'anchor' ];
        }

        // Create class attribute allowing for custom "className" and "align" values.
        $className = 'stepSlider';
        if( !empty( $block[ 'className' ] ) ) {
            $className .= ' ' . $block['className'];
        }
        if( !empty($block['align']) ) {
            $className .= ' align' . $block[ 'align' ];
        }

        $time = time();

        $slidesData = get_field( static::$acfSlides );
        $showSteps = get_field( static::$acfUseSteps );
        ?>
        <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
            <div class="inner-container wp-block-step-slider">
                <?php if ( $slidesData && $showSteps ) : ?>
                <div class="text-center">
                    <div class="steps">
                        <div class="inner">
                            <?php foreach ( $slidesData as $index => $item ) : ?>
                                <div class="stepItem <?= ( $index == 0 ? 'active' : '' ) ?>">
                                    <?= ++$index ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ( $slidesData ) : ?>
                    <div class="slider-container alignfull">
                        <div class="slider-inner">
                            <div class="prev-but-place">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"/></svg>
                            </div>
                            <div class="step-slider">
                                <?php foreach ( $slidesData as $index => $item ) : ?>
                                    <div class="slide-item">
                                        <div class="slide-content">
                                            <?= $item[ 'content' ] ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="next-but-place">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/></svg>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
