<?php
/**
 * Pagination Settings
 *
 * @package Bloglog
 */

$bloglog_default = bloglog_get_default_theme_options();

// Pagination Section.
$wp_customize->add_section( 'bloglog_pagination_section',
	array(
	'title'      => esc_html__( 'Pagination Settings', 'bloglog' ),
	'priority'   => 20,
	'capability' => 'edit_theme_options',
	'panel'		 => 'theme_option_panel',
	)
);

// Pagination Layout Settings
$wp_customize->add_setting( 'bloglog_pagination_layout',
	array(
	'default'           => $bloglog_default['bloglog_pagination_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'bloglog_pagination_layout',
	array(
	'label'       => esc_html__( 'Pagination Method', 'bloglog' ),
	'section'     => 'bloglog_pagination_section',
	'type'        => 'select',
	'choices'     => array(
		'next-prev' => esc_html__('Next/Previous Method','bloglog'),
		'numeric' => esc_html__('Numeric Method','bloglog'),
		'load-more' => esc_html__('Ajax Load More Button','bloglog'),
		'auto-load' => esc_html__('Ajax Auto Load','bloglog'),
	),
	)
);