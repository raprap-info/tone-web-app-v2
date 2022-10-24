<?php
/**
* Posts Settings.
*
* @package Bloglog
*/

$bloglog_default = bloglog_get_default_theme_options();

// Single Post Section.
$wp_customize->add_section( 'posts_settings',
	array(
	'title'      => esc_html__( 'Posts Settings', 'bloglog' ),
	'priority'   => 35,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

$wp_customize->add_setting('ed_post_author',
    array(
        'default' => $bloglog_default['ed_post_author'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_post_author',
    array(
        'label' => esc_html__('Enable Posts Author', 'bloglog'),
        'section' => 'posts_settings',
        'type' => 'checkbox',
    )
);

$wp_customize->add_setting('ed_post_date',
    array(
        'default' => $bloglog_default['ed_post_date'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_post_date',
    array(
        'label' => esc_html__('Enable Posts Date', 'bloglog'),
        'section' => 'posts_settings',
        'type' => 'checkbox',
    )
);

$wp_customize->add_setting('ed_post_category',
    array(
        'default' => $bloglog_default['ed_post_category'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_post_category',
    array(
        'label' => esc_html__('Enable Posts Category', 'bloglog'),
        'section' => 'posts_settings',
        'type' => 'checkbox',
    )
);

$wp_customize->add_setting('ed_post_tags',
    array(
        'default' => $bloglog_default['ed_post_tags'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_post_tags',
    array(
        'label' => esc_html__('Enable Posts Tags', 'bloglog'),
        'section' => 'posts_settings',
        'type' => 'checkbox',
    )
);


$wp_customize->add_setting('ed_post_excerpt',
    array(
        'default' => $bloglog_default['ed_post_excerpt'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_post_excerpt',
    array(
        'label' => esc_html__('Enable Posts Excerpt', 'bloglog'),
        'section' => 'posts_settings',
        'type' => 'checkbox',
    )
);

// Enable Disable Post.
$wp_customize->add_setting('post_video_aspect_ration',
    array(
        'default' => $bloglog_default['post_video_aspect_ration'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_select',
    )
);
$wp_customize->add_control('post_video_aspect_ration',
    array(
        'label' => esc_html__('Global Video Aspect Ratio', 'bloglog'),
        'section' => 'posts_settings',
        'type' => 'select',
        'choices'               => array(
            'default' => esc_html__( 'Default', 'bloglog' ),
            'square' => esc_html__( 'Square', 'bloglog' ),
            'portrait' => esc_html__( 'Portrait', 'bloglog' ),
            'landscape' => esc_html__( 'Landscape', 'bloglog' ),
            ),
        )
);


$wp_customize->add_setting('ed_autoplay',
    array(
        'default' => $bloglog_default['ed_autoplay'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_select',
    )
);
$wp_customize->add_control('ed_autoplay',
    array(
        'label' => esc_html__('Global Video Autoplay', 'bloglog'),
        'section' => 'posts_settings',
        'type' => 'select',
        'choices'               => array(
            'autoplay-enable' => esc_html__( 'Autoplay Enable', 'bloglog' ),
            'autoplay-disable' => esc_html__( 'Autoplay Disable', 'bloglog' ),
            ),
        )
);