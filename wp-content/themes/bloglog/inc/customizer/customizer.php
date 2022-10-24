<?php
/**
 * Bloglog Theme Customizer
 *
 * @package Bloglog
 */

/** Sanitize Functions. **/
	require get_template_directory() . '/inc/customizer/default.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if (!function_exists('bloglog_customize_register')) :

function bloglog_customize_register( $wp_customize ) {

	require get_template_directory() . '/inc/customizer/custom-classes.php';
	require get_template_directory() . '/inc/customizer/sanitize.php';
	require get_template_directory() . '/inc/customizer/header.php';
	require get_template_directory() . '/inc/customizer/banner.php';
	require get_template_directory() . '/inc/customizer/front-homepage.php';
	require get_template_directory() . '/inc/customizer/pagination.php';
	require get_template_directory() . '/inc/customizer/preloader.php';
	require get_template_directory() . '/inc/customizer/archive.php';
	require get_template_directory() . '/inc/customizer/post.php';
	require get_template_directory() . '/inc/customizer/single.php';
	require get_template_directory() . '/inc/customizer/footer.php';
	require get_template_directory() . '/inc/customizer/color-scheme.php';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_section( 'colors' )->panel = 'theme_colors_panel';
	$wp_customize->get_section( 'colors' )->title = esc_html__('Color Options','bloglog');
	$wp_customize->get_section( 'title_tagline' )->panel = 'theme_general_settings';
	$wp_customize->get_section( 'background_image' )->panel = 'theme_general_settings';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'bloglog_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'bloglog_customize_partial_blogdescription',
		) );
	}

	// Theme Options Panel.
	$wp_customize->add_panel( 'theme_option_panel',
		array(
			'title'      => esc_html__( 'Theme Options', 'bloglog' ),
			'priority'   => 150,
			'capability' => 'edit_theme_options',
		)
	);

	$wp_customize->add_panel( 'theme_general_settings',
		array(
			'title'      => esc_html__( 'General Settings', 'bloglog' ),
			'priority'   => 10,
			'capability' => 'edit_theme_options',
		)
	);

	$wp_customize->add_panel( 'theme_colors_panel',
		array(
			'title'      => esc_html__( 'Color Settings', 'bloglog' ),
			'priority'   => 15,
			'capability' => 'edit_theme_options',
		)
	);

	// Theme Options Panel.
	$wp_customize->add_panel( 'theme_footer_option_panel',
		array(
			'title'      => esc_html__( 'Footer Setting', 'bloglog' ),
			'priority'   => 150,
			'capability' => 'edit_theme_options',
		)
	);

	// Template Options
	$wp_customize->add_panel( 'theme_template_pannel',
		array(
			'title'      => esc_html__( 'Template Settings', 'bloglog' ),
			'priority'   => 150,
			'capability' => 'edit_theme_options',
		)
	);

	$wp_customize->add_setting('logo_width_range',
	    array(
	        'default'           => $bloglog_default['logo_width_range'],
	        'capability'        => 'edit_theme_options',
	        'sanitize_callback' => 'bloglog_sanitize_number_range',
	    )
	);
	$wp_customize->add_control('logo_width_range',
	    array(
	        'label'       => esc_html__('Logo With', 'bloglog'),
	        'description'       => esc_html__( 'Define logo size min-200 to max-700 (step-20)', 'bloglog' ),
	        'section'     => 'title_tagline',
	        'type'        => 'range',
	        'input_attrs' => array(
				           'min'   => 200,
				           'max'   => 700,
				           'step'   => 20,
			        	),
	    )
	);
	// Register custom section types.
	$wp_customize->register_section_type( 'Bloglog_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new Bloglog_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'Bloglog Pro', 'bloglog' ),
				'pro_text' => esc_html__( 'Purchase', 'bloglog' ),
				'pro_url'  => esc_url('https://www.themeinwp.com/theme/bloglog-pro/'),
				'priority'  => 1,
			)
		)
	);

}

endif;
add_action( 'customize_register', 'bloglog_customize_register' );

/**
 * Customizer Enqueue scripts and styles.
 */

if (!function_exists('bloglog_customizer_scripts')) :

    function bloglog_customizer_scripts(){   
    	
    	wp_enqueue_script('jquery-ui-button');
    	wp_enqueue_style('bloglog-repeater', get_template_directory_uri() . '/assets/lib/custom/css/repeater.css');
    	wp_enqueue_style('bloglog-customizer', get_template_directory_uri() . '/assets/lib/custom/css/customizer.css');
        wp_enqueue_script('bloglog-customizer', get_template_directory_uri() . '/assets/lib/custom/js/customizer.js', array('jquery','customize-controls'), '', 1);
        wp_enqueue_script('bloglog-repeater', get_template_directory_uri() . '/assets/lib/custom/js/repeater.js', array('jquery','customize-controls'), '', 1);

        $bloglog_post_category_list = bloglog_post_category_list();

	    $cat_option = '';

	    if( $bloglog_post_category_list ){
		    foreach( $bloglog_post_category_list as $key => $cats ){
		    	$cat_option .= "<option value='". esc_attr( $key )."'>". esc_html( $cats )."</option>";
		    }
		}

	    wp_localize_script( 
	        'bloglog-repeater', 
	        'bloglog_repeater',
	        array(
	           	'categories'   => $cat_option,
	            'upload_image'   =>  esc_html__('Choose Image','bloglog'),
	            'use_image'   =>  esc_html__('Select','bloglog'),
	         )
	    );

        $ajax_nonce = wp_create_nonce('bloglog_ajax_nonce');
        wp_localize_script( 
		    'bloglog-customizer', 
		    'bloglog_customizer',
		    array(
		        'ajax_url'   => esc_url( admin_url( 'admin-ajax.php' ) ),
		        'ajax_nonce' => $ajax_nonce,
		     )
		);
    }

endif;

add_action('customize_controls_enqueue_scripts', 'bloglog_customizer_scripts');
add_action('customize_controls_init', 'bloglog_customizer_scripts');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */

if (!function_exists('bloglog_customize_partial_blogname')) :

	function bloglog_customize_partial_blogname() {
		bloginfo( 'name' );
	}
endif;

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */

if (!function_exists('bloglog_customize_partial_blogdescription')) :

	function bloglog_customize_partial_blogdescription() {
		bloginfo( 'description' );
	}

endif;


add_action('wp_ajax_bloglog_customizer_font_weight', 'bloglog_customizer_font_weight_callback');
add_action('wp_ajax_nopriv_bloglog_customizer_font_weight', 'bloglog_customizer_font_weight_callback');

// Recommendec Post Ajax Call Function.
function bloglog_customizer_font_weight_callback() {

    if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( wp_unslash( $_POST['_wpnonce'] ), 'bloglog_ajax_nonce' ) && isset( $_POST['currentfont'] ) && sanitize_text_field( wp_unslash( $_POST['currentfont'] ) ) ) {

       $currentfont = sanitize_text_field( wp_unslash( $_POST['currentfont'] ) );
       $headings_fonts_property = Bloglog_Fonts::bloglog_get_fonts_property( $currentfont );

       foreach( $headings_fonts_property['weight'] as $key => $value ){
       		echo '<option value="'.esc_attr( $key ).'">'.esc_html( $value ).'</option>';
       }
    }
    wp_die();
}