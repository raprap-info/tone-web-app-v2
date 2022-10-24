<?php
/**
* Footer Settings.
*
* @package Bloglog
*/

$bloglog_default = bloglog_get_default_theme_options();


$wp_customize->add_section( 'footer_widget_area',
	array(
	'title'      => esc_html__( 'Footer Setting', 'bloglog' ),
	'priority'   => 200,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);


$wp_customize->add_setting( 'footer_column_layout',
	array(
	'default'           => $bloglog_default['footer_column_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'bloglog_sanitize_select',
	)
);
$wp_customize->add_control( 'footer_column_layout',
	array(
	'label'       => esc_html__( 'Top Footer Column Layout', 'bloglog' ),
	'section'     => 'footer_widget_area',
	'type'        => 'select',
	'choices'               => array(
		'1' => esc_html__( 'One Column', 'bloglog' ),
		'2' => esc_html__( 'Two Column', 'bloglog' ),
		'3' => esc_html__( 'Three Column', 'bloglog' ),
	    ),
	)
);

$wp_customize->add_setting( 'footer_copyright_text',
	array(
	'default'           => $bloglog_default['footer_copyright_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'footer_copyright_text',
	array(
	'label'    => esc_html__( 'Footer Copyright Text', 'bloglog' ),
	'section'  => 'footer_widget_area',
	'type'     => 'text',
	)
);