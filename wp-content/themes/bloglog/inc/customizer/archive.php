<?php
/**
* Archive Settings.
*
* @package Bloglog
*/

$bloglog_default = bloglog_get_default_theme_options();

// Single Post Section.
$wp_customize->add_section( 'archive_settings',
	array(
	'title'      => esc_html__( 'Archive Settings', 'bloglog' ),
	'priority'   => 35,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

$wp_customize->add_setting('ed_post_filter',
    array(
        'default' => $bloglog_default['ed_post_filter'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_post_filter',
    array(
        'label' => esc_html__('Enable Archive Post Filter', 'bloglog'),
        'section' => 'archive_settings',
        'type' => 'checkbox',
    )
);
