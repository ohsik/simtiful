<?php
/**
 * Custom Logo
 */
function simtiful_customize_register( $wp_customize ) {
    $wp_customize->add_setting( 
        'simtiful_logo',
        array(
            'default' => get_template_directory_uri().'/img/logo.png',
            'sanitize_callback' => 'esc_url_raw',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'simtiful_logo', array(
        'label'    => __( 'Upload Logo', 'simtiful' ),
        'section'  => 'title_tagline',
        'settings' => 'simtiful_logo',
    ) ) );
}
add_action( 'customize_register', 'simtiful_customize_register' );

/**
 * Custom Copyright in Footer
 */
function footercopy_customizer( $wp_customize ) {
    $wp_customize->add_section(
        'footer_copyright',
        array(
            'title' => 'Footer Copyright',
            'description' => 'Set your own copyright message in footer',
            'priority' => 35,
        )
    );
    $wp_customize->add_setting(
        'copyright_textbox',
        array(
            'default' => 'Simtiful 2015 powered by WordPress',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'copyright_textbox',
        array(
            'label' => 'Copyright text',
            'section' => 'footer_copyright',
            'type' => 'text',
        )
    );
}
add_action( 'customize_register', 'footercopy_customizer' );