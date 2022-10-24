<?php
/**
 * Default Values.
 *
 * @package Bloglog
 */

if ( ! function_exists( 'bloglog_get_default_theme_options' ) ) :

    /**
     * Get default theme options
     *
     * @since 1.0.0
     *
     * @return array Default theme options.
     */
    function bloglog_get_default_theme_options() {

        $bloglog_defaults = array();
        // Options.
        $bloglog_defaults['logo_width_range']                       = 230;
        $bloglog_defaults['heade_banner_height_range']              = 400;
        $bloglog_defaults['bloglog_pagination_layout']      = 'numeric';
        $bloglog_defaults['footer_column_layout']                       = 3;
        $bloglog_defaults['footer_copyright_text']                      = esc_html__( 'All rights reserved.', 'bloglog' );
        $bloglog_defaults['ed_header_search']                           = 1;
        $bloglog_defaults['ed_image_content_inverse']                   = 0;
        $bloglog_defaults['ed_related_post']                            = 1;
        $bloglog_defaults['related_post_title']                         = esc_html__('Related Post','bloglog');
        $bloglog_defaults['twp_navigation_type']                        = 'norma-navigation';
        $bloglog_defaults['ed_post_author']                             = 1;
        $bloglog_defaults['ed_post_date']                               = 1;
        $bloglog_defaults['ed_post_category']                           = 1;
        $bloglog_defaults['ed_post_tags']                               = 1;
        $bloglog_defaults['ed_floating_next_previous_nav']               = 1;
        $bloglog_defaults['ed_footer_copyright']                        = 1;

        // Default Color
        $bloglog_defaults['background_color']          = 'ffffff';
        $bloglog_defaults['bloglog_primary_color']          = '#000000';
        $bloglog_defaults['bloglog_secondary_color']        = '#0027ff';
        $bloglog_defaults['bloglog_general_color']        = '#000000';

        // Simple Color
        $bloglog_defaults['bloglog_primary_color_dark']          = '#007CED';
        $bloglog_defaults['bloglog_secondary_color_dark']        = '#fb7268';
        $bloglog_defaults['bloglog_general_color_dark']        = '#ffffff';

        // Fancy Color
        $bloglog_defaults['bloglog_primary_color_fancy']          = '#017eff';
        $bloglog_defaults['bloglog_secondary_color_fancy']        = '#fc9285';
        $bloglog_defaults['bloglog_general_color_fancy']        = '#455d58';


        $bloglog_defaults['ed_open_link_new_tab']                       = 0;
        $bloglog_defaults['ed_header_banner']                           = 0;
        $bloglog_defaults['bloglog_color_schema']           = 'default';
        $bloglog_defaults['ed_desktop_menu']            = 0;
        $bloglog_defaults['ed_post_excerpt']            = 1;
        $bloglog_defaults['recent_post_title_search']                 = esc_html__('Recent Post','bloglog');

        $bloglog_defaults['about_section_title']                 = esc_html__('Know Me','bloglog');
        $bloglog_defaults['ed_about_section']                 = 1;

        $bloglog_defaults['ed_article_log_section']            = 1;
        $bloglog_defaults['article_log_section_title']             = esc_html__('Select Archive ','bloglog');
        $bloglog_defaults['ed_article_log_by_year']            = 1;
        $bloglog_defaults['ed_article_log_by_month']            = 1;
        $bloglog_defaults['ed_article_log_by_category']            = 1;
        $bloglog_defaults['ed_article_log_by_tags']            = 1;
        $bloglog_defaults['ed_article_log_by_author']            = 1;


        $bloglog_defaults['top_category_title_search']                 = esc_html__('Top Category','bloglog');
        $bloglog_defaults['ed_header_search_recent_posts']             = 1;
        $bloglog_defaults['ed_header_search_top_category']             = 1;
        $bloglog_defaults['ed_day_night_mode_switch']             = 1;
        $bloglog_defaults['ed_carousel_section']             = 1;
        $bloglog_defaults['ed_carousel_autoplay']             = 1;
        $bloglog_defaults['ed_carousel_arrow']             = 1;
        $bloglog_defaults['ed_carousel_dots']             = 0;
        $bloglog_defaults['ed_post_filter']             = 0;

        $bloglog_defaults['ed_preloader']             = 1;
        $bloglog_defaults['ed_cursor_option']             = 1;
        
        $bloglog_defaults['ed_autoplay']             = 'autoplay-disable';
        $bloglog_defaults['global_sidebar_layout']             = 'right-sidebar';
        $bloglog_defaults['post_video_aspect_ration']             = 'default';
        
        // Pass through filter.
        $bloglog_defaults = apply_filters( 'bloglog_filter_default_theme_options', $bloglog_defaults );

        return $bloglog_defaults;

    }

endif;
