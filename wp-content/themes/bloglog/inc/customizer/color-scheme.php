<?php
/**
* Color Settings.
*
* @package Bloglog
*/

$bloglog_default = bloglog_get_default_theme_options();

$wp_customize->add_section( 'color_scheme',
    array(
    'title'      => esc_html__( 'Color Scheme', 'bloglog' ),
    'priority'   => 60,
    'capability' => 'edit_theme_options',
    'panel'      => 'theme_colors_panel',
    )
);

// Color Scheme.
$wp_customize->add_setting(
    'bloglog_color_schema',
    array(
        'default' 			=> $bloglog_default['bloglog_color_schema'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_select'
    )
);
$wp_customize->add_control(
    new Bloglog_Custom_Radio_Color_Schema( 
        $wp_customize,
        'bloglog_color_schema',
        array(
            'settings'      => 'bloglog_color_schema',
            'section'       => 'color_scheme',
            'label'         => esc_html__( 'Color Scheme', 'bloglog' ),
            'choices'       => array(
                'default'  => array(
                	'color' => array('#f5f6f8','#000','#0027ff','#000'),
                	'title' => esc_html__('Default','bloglog'),
                ),
                'fancy'  => array(
                	'color' => array('#faf7f2','#017eff','#fc9285','#455d58'),
                	'title' => esc_html__('Fancy','bloglog'),
                ),
                'dark'  => array(
                    'color' => array('#222222','#007CED','#fb7268','#ffffff'),
                    'title' => esc_html__('Dark','bloglog'),
                ),
            )
        )
    )
);

$wp_customize->add_setting( 'bloglog_primary_color',
    array(
    'default'           => $bloglog_default['bloglog_primary_color'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control( 
    new WP_Customize_Color_Control( 
    $wp_customize, 
    'bloglog_primary_color', 
    array(
        'label'      => esc_html__( 'Primary Color', 'bloglog' ),
        'section'    => 'colors',
        'settings'   => 'bloglog_primary_color',
    ) ) 
);

$wp_customize->add_setting( 'bloglog_secondary_color',
    array(
    'default'           => $bloglog_default['bloglog_secondary_color'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control( 
    new WP_Customize_Color_Control( 
    $wp_customize, 
    'bloglog_secondary_color', 
    array(
        'label'      => esc_html__( 'Secondary Color', 'bloglog' ),
        'section'    => 'colors',
        'settings'   => 'bloglog_secondary_color',
    ) ) 
);

$wp_customize->add_setting( 'bloglog_general_color',
    array(
    'default'           => $bloglog_default['bloglog_general_color'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control( 
    new WP_Customize_Color_Control( 
    $wp_customize, 
    'bloglog_general_color', 
    array(
        'label'      => esc_html__( 'General Color', 'bloglog' ),
        'section'    => 'colors',
        'settings'   => 'bloglog_general_color',
    ) ) 
);

$wp_customize->add_setting(
    'bloglog_premium_notiece_color_schema',
    array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
    )
);
$wp_customize->add_control(
    new Bloglog_Premium_Notiece_Control( 
        $wp_customize,
        'bloglog_premium_notiece_color_schema',
        array(
            'label'      => esc_html__( 'Color Schemes', 'bloglog' ),
            'settings' => 'bloglog_premium_notiece_color_schema',
            'section'       => 'color_scheme',
        )
    )
);


$wp_customize->add_setting(
    'bloglog_premium_notiece_color',
    array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
    )
);
$wp_customize->add_control(
    new Bloglog_Premium_Notiece_Control( 
        $wp_customize,
        'bloglog_premium_notiece_color',
        array(
            'label'      => esc_html__( 'Color Options', 'bloglog' ),
            'settings' => 'bloglog_premium_notiece_color',
            'section'       => 'colors',
        )
    )
);