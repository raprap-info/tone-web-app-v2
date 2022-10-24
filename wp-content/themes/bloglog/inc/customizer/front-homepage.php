<?php
/**
* Slider Section
*
* @package Bloglog
*/

$bloglog_default = bloglog_get_default_theme_options();
$bloglog_post_category_list = bloglog_post_category_list();

// Homepage Options Panel.
$wp_customize->add_panel( 'homepage_option_panel',
    array(
        'title'      => esc_html__( 'HomePage Options', 'bloglog' ),
        'priority'   => 150,
        'capability' => 'edit_theme_options',
    )
);

// Slider Section.
$wp_customize->add_section( 'bloglog_carousel_section',
	array(
	'title'      => esc_html__( 'Slider Section Setting', 'bloglog' ),
	'capability' => 'edit_theme_options',
    'priority'   => 15,
    'panel'      => 'homepage_option_panel',
	)
);

$wp_customize->add_setting('ed_carousel_section',
    array(
        'default' => $bloglog_default['ed_carousel_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_carousel_section',
    array(
        'label' => esc_html__('Enable Slider Section', 'bloglog'),
        'section' => 'bloglog_carousel_section',
        'type' => 'checkbox',
    )
);

$wp_customize->add_setting('mg_carousel_section_cat',
    array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_select',
    )
);
$wp_customize->add_control('mg_carousel_section_cat',
    array(
        'label' => esc_html__('Enable Slider Section', 'bloglog'),
        'section' => 'bloglog_carousel_section',
        'type' => 'select',
        'choices' => $bloglog_post_category_list,
    )
);

$wp_customize->add_setting('ed_carousel_autoplay',
    array(
        'default' => $bloglog_default['ed_carousel_autoplay'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_carousel_autoplay',
    array(
        'label' => esc_html__('Enable Autoplay', 'bloglog'),
        'section' => 'bloglog_carousel_section',
        'type' => 'checkbox',
    )
);

$wp_customize->add_setting('ed_carousel_arrow',
    array(
        'default' => $bloglog_default['ed_carousel_arrow'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_carousel_arrow',
    array(
        'label' => esc_html__('Enable Arrow', 'bloglog'),
        'section' => 'bloglog_carousel_section',
        'type' => 'checkbox',
    )
);

$wp_customize->add_setting('ed_carousel_dots',
    array(
        'default' => $bloglog_default['ed_carousel_dots'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_carousel_dots',
    array(
        'label' => esc_html__('Enable Dots', 'bloglog'),
        'section' => 'bloglog_carousel_section',
        'type' => 'checkbox',
    )
);



// Homepage About section settings.
$wp_customize->add_section( 'homepage_about_Section',
    array(
    'title'      => esc_html__( 'About Section Settings', 'bloglog' ),
    'capability' => 'edit_theme_options',
    'panel'      => 'homepage_option_panel',
    )
);

$wp_customize->add_setting('ed_about_section',
    array(
        'default' => $bloglog_default['ed_about_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_about_section',
    array(
        'label' => esc_html__('Enable About Section', 'bloglog'),
        'section' => 'homepage_about_Section',
        'type' => 'checkbox',
    )
);


$wp_customize->add_setting('about_section_title',
    array(
        'default'           => $bloglog_default['about_section_title'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('about_section_title',
    array(
        'label'       => esc_html__('About Section Title', 'bloglog'),
        'section'     => 'homepage_about_Section',
        'type'        => 'text',
    )
);

$wp_customize->add_setting( 'select_page_for_about', array(
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'bloglog_sanitize_dropdown_pages',
) );

$wp_customize->add_control( 'select_page_for_about', array(
    'label'             => __( 'Select About Page', 'bloglog' ) ,
    'section'           => 'homepage_about_Section',
    'type'              => 'dropdown-pages',
    'allow_addition' => true,
    )
);


$wp_customize->add_setting('twp_about_signature_image',
    array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    )
);
$wp_customize->add_control( new WP_Customize_Image_Control(
    $wp_customize,
    'twp_about_signature_image',
        array(
            'label'      => esc_html__( 'About Page Signature', 'bloglog' ),
            'section'    => 'homepage_about_Section',
        )
    )
);

$wp_customize->add_setting('twp_about_background_image',
    array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    )
);
$wp_customize->add_control( new WP_Customize_Image_Control(
    $wp_customize,
    'twp_about_background_image',
        array(
            'label'      => esc_html__( 'About Page Image', 'bloglog' ),
            'section'    => 'homepage_about_Section',
        )
    )
);

// Article Log Section.
$wp_customize->add_section( 'bloglog_article_log_section',
    array(
    'title'      => esc_html__( 'Article Log Section Setting', 'bloglog' ),
    'capability' => 'edit_theme_options',
    'priority'   => 20,
    'panel'      => 'homepage_option_panel',
    )
);

$wp_customize->add_setting('ed_article_log_section',
    array(
        'default' => $bloglog_default['ed_article_log_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_article_log_section',
    array(
        'label' => esc_html__('Enable Article Log Section', 'bloglog'),
        'section' => 'bloglog_article_log_section',
        'type' => 'checkbox',
    )
);

$wp_customize->add_setting( 'article_log_section_title',
    array(
    'default'           => $bloglog_default['article_log_section_title'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control( 'article_log_section_title',
    array(
    'label'    => esc_html__( 'Section Title', 'bloglog' ),
    'section'  => 'bloglog_article_log_section',
    'type'     => 'text',
    )
);


$wp_customize->add_setting('ed_article_log_by_year',
    array(
        'default' => $bloglog_default['ed_article_log_by_year'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_article_log_by_year',
    array(
        'label' => esc_html__('Enable Article Log By Year', 'bloglog'),
        'section' => 'bloglog_article_log_section',
        'type' => 'checkbox',
    )
);


$wp_customize->add_setting('ed_article_log_by_month',
    array(
        'default' => $bloglog_default['ed_article_log_by_month'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_article_log_by_month',
    array(
        'label' => esc_html__('Enable Article Log By Month', 'bloglog'),
        'section' => 'bloglog_article_log_section',
        'type' => 'checkbox',
    )
);


$wp_customize->add_setting('ed_article_log_by_category',
    array(
        'default' => $bloglog_default['ed_article_log_by_category'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_article_log_by_category',
    array(
        'label' => esc_html__('Enable Article Log By Category', 'bloglog'),
        'section' => 'bloglog_article_log_section',
        'type' => 'checkbox',
    )
);


$wp_customize->add_setting('ed_article_log_by_tags',
    array(
        'default' => $bloglog_default['ed_article_log_by_tags'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_article_log_by_tags',
    array(
        'label' => esc_html__('Enable Article Log By Tags', 'bloglog'),
        'section' => 'bloglog_article_log_section',
        'type' => 'checkbox',
    )
);


$wp_customize->add_setting('ed_article_log_by_author',
    array(
        'default' => $bloglog_default['ed_article_log_by_author'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'bloglog_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_article_log_by_author',
    array(
        'label' => esc_html__('Enable Article Log By Author', 'bloglog'),
        'section' => 'bloglog_article_log_section',
        'type' => 'checkbox',
    )
);
