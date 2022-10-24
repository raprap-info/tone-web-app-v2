<?php
/**
* Header Options.
*
* @package Bloglog
*/

$bloglog_default = bloglog_get_default_theme_options();

// Header Advertise Area Section.
$wp_customize->add_section( 'main_header_setting',
	array(
	'title'      => esc_html__( 'Header Settings', 'bloglog' ),
	'priority'   => 10,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Enable Disable Search.
$wp_customize->add_setting('ed_header_search',
    array(
        'default' => $bloglog_default['ed_header_search'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_header_search',
    array(
        'label' => esc_html__('Enable Search', 'bloglog'),
        'section' => 'main_header_setting',
        'type' => 'checkbox',
    )
);

$wp_customize->add_setting('ed_desktop_menu',
    array(
        'default' => $bloglog_default['ed_desktop_menu'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_desktop_menu',
    array(
        'label' => esc_html__('Enable Primary Desktop Menu', 'bloglog'),
        'section' => 'main_header_setting',
        'type' => 'checkbox',
    )
);

$wp_customize->add_setting('ed_header_search_recent_posts',
    array(
        'default' => $bloglog_default['ed_header_search_recent_posts'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_header_search_recent_posts',
    array(
        'label' => esc_html__('Enable Recent Posts on Search Area', 'bloglog'),
        'section' => 'main_header_setting',
        'type' => 'checkbox',
    )
);
$wp_customize->add_setting( 'recent_post_title_search',
    array(
    'default'           => $bloglog_default['recent_post_title_search'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control( 'recent_post_title_search',
    array(
    'label'    => esc_html__( 'Related Posts Section Title', 'bloglog' ),
    'section'  => 'main_header_setting',
    'type'     => 'text',
    )
);
$wp_customize->add_setting('ed_header_search_top_category',
    array(
        'default' => $bloglog_default['ed_header_search_top_category'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_header_search_top_category',
    array(
        'label' => esc_html__('Enable Top Category on Search Area', 'bloglog'),
        'section' => 'main_header_setting',
        'type' => 'checkbox',
    )
);
$wp_customize->add_setting( 'top_category_title_search',
    array(
    'default'           => $bloglog_default['top_category_title_search'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control( 'top_category_title_search',
    array(
    'label'    => esc_html__( 'Top Category Section Title', 'bloglog' ),
    'section'  => 'main_header_setting',
    'type'     => 'text',
    )
);