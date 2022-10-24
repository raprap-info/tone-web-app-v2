<?php
/**
* Widget FUnctions.
*
* @package Bloglog
*/

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function bloglog_widgets_init(){
    
    register_sidebar( array(
        'name' => esc_html__('Sidebar', 'bloglog'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'bloglog'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    $bloglog_default = bloglog_get_default_theme_options();
    $footer_column_layout = absint( get_theme_mod( 'footer_column_layout',$bloglog_default['footer_column_layout'] ) );

    for( $i = 0; $i < $footer_column_layout; $i++ ){
    	
    	if( $i == 0 ){ $count = esc_html__('One','bloglog'); }
    	if( $i == 1 ){ $count = esc_html__('Two','bloglog'); }
    	if( $i == 2 ){ $count = esc_html__('Three','bloglog'); }

	    register_sidebar( array(
	        'name' => esc_html__('Footer Widget ', 'bloglog').$count,
	        'id' => 'bloglog-footer-widget-'.$i,
	        'description' => esc_html__('Add widgets here.', 'bloglog'),
	        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h2 class="widget-title">',
	        'after_title' => '</h2>',
	    ));
	}

}

add_action('widgets_init', 'bloglog_widgets_init');

/**
 * Widget Base Class.
 */
require get_template_directory() . '/inc/widgets/widget-base-class.php';
/**
 * Recent Post Widget.
 */
require get_template_directory() . '/inc/widgets/recent-post.php';
/**
 * Social Link Widget.
 */
require get_template_directory() . '/inc/widgets/social-link.php';

/**
 * Author Widget.
 */
require get_template_directory() . '/inc/widgets/tab-posts.php';
/**
 * Category Widget.
 */
require get_template_directory() . '/inc/widgets/category.php';