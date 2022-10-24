<?php

/**
 * Bloglog About Page
 * @package Bloglog
 *
*/

if( !class_exists('Bloglog_About_page') ):

	class Bloglog_About_page{

		function __construct(){

			add_action('admin_menu', array($this, 'bloglog_backend_menu'),999);

		}

		// Add Backend Menu
        function bloglog_backend_menu(){

            add_theme_page(esc_html__( 'Bloglog Options','bloglog' ), esc_html__( 'Bloglog Options','bloglog' ), 'activate_plugins', 'bloglog-about', array($this, 'bloglog_main_page'));

        }

        // Settings Form
        function bloglog_main_page(){

            require get_template_directory() . '/classes/about-render.php';

        }

	}

	new Bloglog_About_page();

endif;