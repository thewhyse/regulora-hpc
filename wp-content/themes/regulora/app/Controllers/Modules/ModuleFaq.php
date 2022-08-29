<?php

namespace App\Controllers\Modules;

/**
 * Trait ModuleTestimonials
 * @package App\Controllers\Modules
 */

trait ModuleFaq
{
    // Block settings
    public static $blockTypeFAQ = 'faq';
    /**
     * ACF fields
     */
    public static $acfFAQ = 'faq';

    /**
     * Setup trait
     */
    public static function traitSetup()
    {
        add_action( 'acf/init', [ static::class, 'gutenbergBlockFAQInit' ] );
    }

    public static function gutenbergBlockFAQInit()
    {
        // Check function exists.
        if( function_exists('acf_register_block_type') ) {

            // Register a testimonial block.
            acf_register_block_type( array(
                'name'              => static::$blockTypeFAQ,
                'title'             => __( 'FAQ' ),
                'description'       => __( 'Show block with FAQ' ),
                'keywords'          => array( 'faq', 'question', 'answer' ),
                'icon'              => 'format-chat',
//                'align'             => 'full',
                'render_callback'   => [ static::class, 'renderBlockFAQ' ],
                'category'          => 'common',
//                'enqueue_script'    => get_stylesheet_directory_uri() . '/assets/scripts/blocks/random-testimonial.js',
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

    public static function renderBlockFAQ( $block, $content = '', $is_preview = false, $post_id = 0 )
    {
        // Create id attribute allowing for custom "anchor" value.
        $id = 'faq-' . $block[ 'id' ];
        if( !empty( $block[ 'anchor' ] ) ) {
            $id = $block[ 'anchor' ];
        }

        // Create class attribute allowing for custom "className" and "align" values.
        $className = 'faq';
        if( !empty( $block[ 'className' ] ) ) {
            $className .= ' ' . $block['className'];
        }
        if( !empty($block['align']) ) {
            $className .= ' align' . $block[ 'align' ];
        }

        $time = $block[ 'id' ] . time();

        $faqData = get_field( static::$acfFAQ );
        ?>
        <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
            <div class="inner-container wp-block-faq">
                <?php if ( $faqData ) : ?>
                <div class="accordion faq-accordion" id="nav-tabContent-<?=$time?>">
                    <?php foreach ( $faqData as $index => $item ) : ?>
                        <div class="faq-item accordion-item">
                            <h4 class="accordion-header question" id="heading-<?=$index.$time?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?=$index.$time?>" aria-expanded="false" aria-controls="collapse-<?=$index.$time?>">
                                    <?= $item[ 'question' ] ?>
                                </button>
                            </h4>
                            <div id="collapse-<?=$index.$time?>" class="accordion-collapse collapse" aria-labelledby="heading-<?=$index.$time?>">
                                <div class="accordion-body">
                                    <?= $item[ 'answer' ] ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
