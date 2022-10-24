<?php
/**
* Preloader Options.
*
* @package bloglog
*/

$bloglog_default = bloglog_get_default_theme_options();

$wp_customize->add_section( 'preloader_setting',
	array(
	'title'      => esc_html__( 'Preloader Settings', 'bloglog' ),
	'priority'   => 10,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

$wp_customize->add_setting('ed_preloader',
    array(
        'default' => $bloglog_default['ed_preloader'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_preloader',
    array(
        'label' => esc_html__('Enable Preloader', 'bloglog'),
        'section' => 'preloader_setting',
        'type' => 'checkbox',
    )
);


// Cursor Section.
$wp_customize->add_section('cursor_section',
    array(
        'title'      => esc_html__('Cursor Options', 'bloglog'),
        'priority'   => 10,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting ed_cursor_option.
$wp_customize->add_setting('ed_cursor_option',
    array(
        'default' => $bloglog_default['ed_cursor_option'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_cursor_option',
    array(
        'label' => esc_html__('Enable Custom Cursor', 'bloglog'),
        'section' => 'cursor_section',
        'type' => 'checkbox',
    )
);


