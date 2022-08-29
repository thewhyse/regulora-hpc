<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);

    $wp_customize->add_setting(
        'placeholder_image',
        array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control(
        new \WP_Customize_Image_Control(
            $wp_customize,
            'placeholder_image_custom',
            array(
                'label'         => 'Placeholder image',
                'settings'      => 'placeholder_image',
                'section'       => 'title_tagline',
            )
        )
    );

    $wp_customize->add_section(
        'true_footer_options',
        array(
            'title'     => 'Footer',
            'priority'  => 201
        )
    );

    $wp_customize->add_setting(
        'footer_logo',
        array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control(
        new \WP_Customize_Media_Control(
            $wp_customize,
            'footer_logo',
            array(
                'label'         => 'Footer Logo',
                'settings'      => 'footer_logo',
                'section'       => 'true_footer_options',
            )
        )
    );

    $wp_customize->add_setting(
        'true_footer_copyright_text',
        array(
            'default'            => 'All rights reserved',
            'transport'          => 'postMessage'
        )
    );
    $wp_customize->add_control(
        'true_footer_copyright_text',
        array(
            'section'  => 'true_footer_options',
            'label'    => 'Copyright',
            'type'     => 'text'
        )
    );
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});

/**
 * Add ACF-powered options page(s).
 */
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-general-settings',
        'icon_url'   => 'dashicons-admin-customizer',
        'capability' => 'edit_posts',

    ) );

    acf_add_options_sub_page( array(
        'page_title'  => 'Theme General Settings',
        'menu_title'  => 'Theme Settings',
        'parent_slug' => 'theme-general-settings',
    ) );
}
