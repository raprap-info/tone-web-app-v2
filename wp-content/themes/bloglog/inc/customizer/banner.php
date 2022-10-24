<?php

$wp_customize->add_setting( 'ed_header_banner',
    array(
    'default'           => $bloglog_default['ed_header_banner'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control( 'ed_header_banner',
    array(
    'label'       => esc_html__( 'Enable Banner', 'bloglog' ),
    'section'     => 'header_image',
    'type'        => 'checkbox',
    'priority'   => 0,
    )
);


$wp_customize->add_setting('heade_banner_height_range',
    array(
        'default'           => $bloglog_default['heade_banner_height_range'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_number_range',
    )
);
$wp_customize->add_control('heade_banner_height_range',
    array(
        'label'       => esc_html__('Header Banner Height', 'bloglog'),
        'description'       => esc_html__( 'Define header banner height min-200 to max-700 (step-20)', 'bloglog' ),
        'section'     => 'header_image',
        'type'        => 'range',
        'input_attrs' => array(
                       'min'   => 200,
                       'max'   => 700,
                       'step'   => 20,
                    ),
    )
);

$wp_customize->add_setting( 'header_banner_title',
    array(
    'default'           => '',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control( 'header_banner_title',
    array(
    'label'       => esc_html__( 'Banner Title', 'bloglog' ),
    'section'     => 'header_image',
    'type'        => 'text',
    )
);

$wp_customize->add_setting( 'header_banner_sub_title',
    array(
    'default'           => '',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control( 'header_banner_sub_title',
    array(
    'label'       => esc_html__( 'Banner Sub Title', 'bloglog' ),
    'section'     => 'header_image',
    'type'        => 'text',
    )
);

$wp_customize->add_setting( 'header_banner_description',
    array(
    'default'           => '',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control( 'header_banner_description',
    array(
    'label'       => esc_html__( 'Banner Description', 'bloglog' ),
    'section'     => 'header_image',
    'type'        => 'textarea',
    )
);

$wp_customize->add_setting( 'header_banner_button_label',
    array(
    'default'           => '',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control( 'header_banner_button_label',
    array(
    'label'       => esc_html__( 'Banner Button Text', 'bloglog' ),
    'section'     => 'header_image',
    'type'        => 'text',
    )
);

$wp_customize->add_setting( 'header_banner_button_link',
    array(
    'default'           => '',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control( 'header_banner_button_link',
    array(
    'label'       => esc_html__( 'Banner Button Link', 'bloglog' ),
    'section'     => 'header_image',
    'type'        => 'text',
    )
);

$wp_customize->add_setting('ed_open_link_new_tab',
    array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);

$wp_customize->add_control('ed_open_link_new_tab',
    array(
        'label' => esc_html__('Open In New Tab', 'bloglog'),
        'section' => 'header_image',
        'type' => 'checkbox',
    )
 );