<?php
/**
* Body Classes.
*
* @package Bloglog
*/
 
 if (!function_exists('bloglog_body_classes')) :

    function bloglog_body_classes($classes) {

        $bloglog_default = bloglog_get_default_theme_options();
        $bloglog_color_schema = get_theme_mod( 'bloglog_color_schema',$bloglog_default['bloglog_color_schema'] );
        $ed_desktop_menu = get_theme_mod( 'ed_desktop_menu',$bloglog_default['ed_desktop_menu'] );
        global $post;
        
        // Adds a class of hfeed to non-singular pages.
        if ( !is_singular() ) {
            $classes[] = 'hfeed';
        }
        if( $ed_desktop_menu ){

            $classes[] = 'enabled-desktop-menu';

        }else{

            $classes[] = 'disabled-desktop-menu';

        }

        $classes[] = 'color-scheme-'.esc_attr( $bloglog_color_schema );

        return $classes;
    }

endif;

add_filter('body_class', 'bloglog_body_classes');