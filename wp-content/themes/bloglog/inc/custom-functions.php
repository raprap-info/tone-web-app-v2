<?php
/**
 * Custom Functions.
 *
 * @package Bloglog
 */

if( !function_exists( 'bloglog_fonts_url' ) ) :

    //Google Fonts URL
    function bloglog_fonts_url(){

        $font_families = array(
            'Inter:wght@100;200;300;400;500;600;700;800;900',
            'Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700'

        );

        $fonts_url = add_query_arg( array(
            'family' => implode( '&family=', $font_families ),
            'display' => 'swap',
        ), 'https://fonts.googleapis.com/css2' );

        return esc_url_raw($fonts_url);

    }

endif;

if( !function_exists('bloglog_read_more_render') ):

    function bloglog_read_more_render(){ ?>
         <div class="entry-meta">
             <div class="entry-meta-link">
                 <a href="<?php the_permalink(); ?>">
                     <?php esc_html_e('Read More','bloglog'); ?>
                 </a>
             </div>
         </div>

    <?php
    }

endif;

if( !function_exists( 'bloglog_social_menu_icon' ) ) :

    function bloglog_social_menu_icon( $item_output, $item, $depth, $args ) {

        // Add Icon
        if ( 'bloglog-social-menu' === $args->theme_location ) {

            $svg = Bloglog_SVG_Icons::get_theme_svg_name( $item->url );

            if ( empty( $svg ) ) {
                $svg = bloglog_the_theme_svg( 'link',$return = true );
            }

            $item_output = str_replace( $args->link_after, '</span>' . $svg, $item_output );
        }

        return $item_output;
    }
    
endif;

add_filter( 'walker_nav_menu_start_el', 'bloglog_social_menu_icon', 10, 4 );

if( !function_exists( 'bloglog_add_sub_toggles_to_main_menu' ) ) :

    function bloglog_add_sub_toggles_to_main_menu( $args, $item, $depth ) {

        // Add sub menu toggles to the Expanded Menu with toggles.
        if( isset( $args->show_toggles ) && $args->show_toggles ){

            // Wrap the menu item link contents in a div, used for positioning.
            $args->before = '<div class="submenu-wrapper">';
            $args->after  = '';

            // Add a toggle to items with children.
            if( in_array( 'menu-item-has-children', $item->classes, true ) ){

                $toggle_target_string = '.menu-item.menu-item-' . $item->ID . ' > .sub-menu';
                // Add the sub menu toggle.
                $args->after .= '<button class="toggle submenu-toggle" data-toggle-target="' . $toggle_target_string . '" data-toggle-type="slidetoggle" data-toggle-duration="250" aria-expanded="false"><span class="btn__content" tabindex="-1"><span class="screen-reader-text">' . __( 'Show sub menu', 'bloglog' ) . '</span>' . bloglog_the_theme_svg( 'chevron-down',$return = true ) . '</span></button>';

            }

            // Close the wrapper.
            $args->after .= '</div><!-- .submenu-wrapper -->';

            // Add sub menu icons to the primary menu without toggles.
        }elseif( 'bloglog-primary-menu' === $args->theme_location ){

            if( in_array( 'menu-item-has-children', $item->classes, true ) ){

                $args->after = '<span class="icon">'.bloglog_the_theme_svg('chevron-down',true).'</span>';

            }else{

                $args->after = '';

            }
        }

        return $args;

    }

endif;

add_filter( 'nav_menu_item_args', 'bloglog_add_sub_toggles_to_main_menu', 10, 3 );

if( !function_exists( 'bloglog_sanitize_sidebar_option_meta' ) ) :

    // Sidebar Option Sanitize.
    function bloglog_sanitize_sidebar_option_meta( $input ){

        $metabox_options = array( 'global-sidebar','left-sidebar','right-sidebar','no-sidebar' );
        if( in_array( $input,$metabox_options ) ){

            return $input;

        }else{

            return '';

        }
    }

endif;

if( !function_exists( 'bloglog_page_lists' ) ) :

    // Page List.
    function bloglog_page_lists(){

        $page_lists = array();
        $page_lists[''] = esc_html__( '-- Select Page --','bloglog' );
        $pages = get_pages();
        foreach( $pages as $page ){

            $page_lists[$page->ID] = $page->post_title;

        }
        return $page_lists;
    }

endif;

if( !function_exists( 'bloglog_sanitize_post_layout_option_meta' ) ) :

    // Sidebar Option Sanitize.
    function bloglog_sanitize_post_layout_option_meta( $input ){

        $metabox_options = array( 'global-layout','layout-1','layout-2' );
        if( in_array( $input,$metabox_options ) ){

            return $input;

        }else{

            return '';

        }

    }

endif;

if( !function_exists( 'bloglog_sanitize_header_overlay_option_meta' ) ) :

    // Sidebar Option Sanitize.
    function bloglog_sanitize_header_overlay_option_meta( $input ){

        $metabox_options = array( 'global-layout','enable-overlay' );
        if( in_array( $input,$metabox_options ) ){

            return $input;

        }else{

            return '';

        }

    }

endif;

/**
 * Bloglog SVG Icon helper functions
 *
 * @package Bloglog
 * @since 1.0.0
 */
if ( ! function_exists( 'bloglog_the_theme_svg' ) ):
    /**
     * Output and Get Theme SVG.
     * Output and get the SVG markup for an icon in the Bloglog_SVG_Icons class.
     *
     * @param string $svg_name The name of the icon.
     * @param string $group The group the icon belongs to.
     * @param string $color Color code.
     */
    function bloglog_the_theme_svg( $svg_name, $return = false ) {

        if( $return ){

            return bloglog_get_theme_svg( $svg_name ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in bloglog_get_theme_svg();.

        }else{

            echo bloglog_get_theme_svg( $svg_name ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in bloglog_get_theme_svg();.
            
        }
    }

endif;

if ( ! function_exists( 'bloglog_get_theme_svg' ) ):

    /**
     * Get information about the SVG icon.
     *
     * @param string $svg_name The name of the icon.
     * @param string $group The group the icon belongs to.
     * @param string $color Color code.
     */
    function bloglog_get_theme_svg( $svg_name ) {

        // Make sure that only our allowed tags and attributes are included.
        $svg = wp_kses(
            Bloglog_SVG_Icons::get_svg( $svg_name ),
            array(
                'svg'     => array(
                    'class'       => true,
                    'xmlns'       => true,
                    'width'       => true,
                    'height'      => true,
                    'viewbox'     => true,
                    'aria-hidden' => true,
                    'role'        => true,
                    'focusable'   => true,
                ),
                'path'    => array(
                    'fill'      => true,
                    'fill-rule' => true,
                    'd'         => true,
                    'transform' => true,
                ),
                'polygon' => array(
                    'fill'      => true,
                    'fill-rule' => true,
                    'points'    => true,
                    'transform' => true,
                    'focusable' => true,
                ),
            )
        );
        if ( ! $svg ) {
            return false;
        }
        return $svg;

    }

endif;


if( !function_exists( 'bloglog_post_category_list' ) ) :

    // Post Category List.
    function bloglog_post_category_list( $select_cat = true ){

        $post_cat_lists = get_categories(
            array(
                'hide_empty' => '0',
                'exclude' => '1',
            )
        );

        $post_cat_cat_array = array();
        if( $select_cat ){

            $post_cat_cat_array[''] = esc_html__( '-- Select Category --','bloglog' );

        }

        foreach ( $post_cat_lists as $post_cat_list ) {

            $post_cat_cat_array[$post_cat_list->slug] = $post_cat_list->name;

        }

        return $post_cat_cat_array;
    }

endif;

if( !function_exists('bloglog_sanitize_meta_pagination') ):

    /** Sanitize Enable Disable Checkbox **/
    function bloglog_sanitize_meta_pagination( $input ) {

        $valid_keys = array('global-layout','no-navigation','norma-navigation','ajax-next-post-load');
        if ( in_array( $input , $valid_keys ) ) {
            return $input;
        }
        return '';

    }

endif;

if( !function_exists('bloglog_disable_post_views') ):

    /** Disable Post Views **/
    function bloglog_disable_post_views() {

        add_filter('booster_extension_filter_views_ed', function ( ) {
            return false;
        });

    }

endif;

if( !function_exists('bloglog_disable_post_read_time') ):

    /** Disable Read Time **/
    function bloglog_disable_post_read_time() {

        add_filter('booster_extension_filter_readtime_ed', function ( ) {
            return false;
        });

    }

endif;

if( !function_exists('bloglog_disable_post_like_dislike') ):

    /** Disable Like Dislike **/
    function bloglog_disable_post_like_dislike() {

        add_filter('booster_extension_filter_like_ed', function ( ) {
            return false;
        });

    }

endif;

if( !function_exists('bloglog_disable_post_author_box') ):

    /** Disable Author Box **/
    function bloglog_disable_post_author_box() {

        add_filter('booster_extension_filter_ab_ed', function ( ) {
            return false;
        });

    }

endif;


add_filter('booster_extension_filter_ss_ed', function ( ) {
    return false;
});

if( !function_exists('bloglog_disable_post_reaction') ):

    /** Disable Reaction **/
    function bloglog_disable_post_reaction() {

        add_filter('booster_extension_filter_reaction_ed', function ( ) {
            return false;
        });

    }

endif;

if( !function_exists('bloglog_post_floating_nav') ):

    function bloglog_post_floating_nav(){

        $bloglog_default = bloglog_get_default_theme_options();
        $ed_floating_next_previous_nav = get_theme_mod( 'ed_floating_next_previous_nav',$bloglog_default['ed_floating_next_previous_nav'] );

        if( 'post' === get_post_type() && $ed_floating_next_previous_nav ){

            $next_post = get_next_post();
            $prev_post = get_previous_post();

            if( isset( $prev_post->ID ) ){

                $prev_link = get_permalink( $prev_post->ID );?>

                <div class="floating-post-navigation floating-navigation-prev">
                    <?php if( get_the_post_thumbnail( $prev_post->ID,'medium' ) ){ ?>
                            <?php echo wp_kses_post( get_the_post_thumbnail( $prev_post->ID,'medium' ) ); ?>
                    <?php } ?>
                    <a href="<?php echo esc_url( $prev_link ); ?>">
                        <span class="floating-navigation-label"><?php echo esc_html__('Previous post', 'bloglog'); ?></span>
                        <span class="floating-navigation-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></span>
                    </a>
                </div>

            <?php }

            if( isset( $next_post->ID ) ){

                $next_link = get_permalink( $next_post->ID );?>

                <div class="floating-post-navigation floating-navigation-next">
                    <?php if( get_the_post_thumbnail( $next_post->ID,'medium' ) ){ ?>
                        <?php echo wp_kses_post( get_the_post_thumbnail( $next_post->ID,'medium' ) ); ?>
                    <?php } ?>
                    <a href="<?php echo esc_url( $next_link ); ?>">
                        <span class="floating-navigation-label"><?php echo esc_html__('Next post', 'bloglog'); ?></span>
                        <span class="floating-navigation-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></span>
                    </a>
                </div>

            <?php
            }

        }

    }

endif;

add_action( 'bloglog_navigation_action','bloglog_post_floating_nav',10 );

if( !function_exists('bloglog_single_post_navigation') ):

    function bloglog_single_post_navigation(){

        $bloglog_default = bloglog_get_default_theme_options();
        $twp_navigation_type = esc_attr( get_post_meta( get_the_ID(), 'twp_disable_ajax_load_next_post', true ) );
        $current_id = '';
        $article_wrap_class = '';
        global $post;
        $current_id = $post->ID;
        if( $twp_navigation_type == '' || $twp_navigation_type == 'global-layout' ){
            $twp_navigation_type = get_theme_mod('twp_navigation_type', $bloglog_default['twp_navigation_type']);
        }


        if( $twp_navigation_type != 'no-navigation' && 'post' === get_post_type() ){

            if( $twp_navigation_type == 'norma-navigation' ){ ?>

                <div class="theme-block navigation-wrapper">
                    <?php
                    // Previous/next post navigation.
                    the_post_navigation(array(
                        'prev_text' => '<span class="arrow" aria-hidden="true">' . bloglog_the_theme_svg('arrow-left',$return = true ) . '</span><span class="screen-reader-text">' . __('Previous post:', 'bloglog') . '</span><h4 class="entry-title entry-title-small">%title</h4>',
                        'next_text' => '<span class="arrow" aria-hidden="true">' . bloglog_the_theme_svg('arrow-right',$return = true ) . '</span><span class="screen-reader-text">' . __('Next post:', 'bloglog') . '</span><h4 class="entry-title entry-title-small">%title</h4>',
                    )); ?>
                </div>
                <?php

            }else{

                $next_post = get_next_post();
                if( isset( $next_post->ID ) ){

                    $next_post_id = $next_post->ID;
                    echo '<div loop-count="1" next-post="' . absint( $next_post_id ) . '" class="twp-single-infinity"></div>';

                }
            }

        }

    }

endif;

add_action( 'bloglog_navigation_action','bloglog_single_post_navigation',30 );

if ( ! function_exists( 'bloglog_header_toggle_search' ) ):

    /**
     * Header Search
     **/
    function bloglog_header_toggle_search() {

        $bloglog_default = bloglog_get_default_theme_options();
        $ed_header_search = get_theme_mod( 'ed_header_search', $bloglog_default['ed_header_search'] );
        $ed_header_search_top_category = get_theme_mod( 'ed_header_search_top_category', $bloglog_default['ed_header_search_top_category'] );
        $ed_header_search_recent_posts = absint( get_theme_mod( 'ed_header_search_recent_posts',$bloglog_default['ed_header_search_recent_posts'] ) );
        
        if( $ed_header_search ){ ?>

            <div class="header-searchbar">
                <div class="header-searchbar-inner">
                    <div class="wrapper">

                        <div class="header-searchbar-area">

                            <a href="javascript:void(0)" class="skip-link-search-start"></a>
                            
                            <?php get_search_form(); ?>

                        </div>

                        <?php if( $ed_header_search_recent_posts || $ed_header_search_top_category ){ ?>

                            <div class="search-content-area">
                                  
                                <?php if( $ed_header_search_recent_posts ){ ?>

                                    <div class="search-recent-posts">
                                        <?php bloglog_recent_posts_search(); ?>
                                    </div>

                                <?php } ?>

                                <?php if( $ed_header_search_top_category ){ ?>

                                    <div class="search-popular-categories">
                                        <?php bloglog_header_search_top_cat_content(); ?>
                                    </div>

                                <?php } ?>

                            </div>

                        <?php } ?>

                        <button type="button" id="search-closer" class="exit-search">
                            <?php bloglog_the_theme_svg('cross'); ?>
                        </button>

                        <a href="javascript:void(0)" class="skip-link-search-end"></a>

                    </div>
                </div>
            </div>

        <?php
        }

    }

endif;

if( !function_exists('bloglog_recent_posts_search') ):

    // Single Posts Related Posts.
    function bloglog_recent_posts_search(){

        $bloglog_default = bloglog_get_default_theme_options();
        $related_posts_query = new WP_Query( array('post_type' => 'post', 'posts_per_page' => 5,'post__not_in' => get_option("sticky_posts") ) );

        if( $related_posts_query->have_posts() ): ?>

            <div class="related-search-posts">

                <div class="theme-block-heading">
                    <?php
                    $recent_post_title_search = esc_html( get_theme_mod( 'recent_post_title_search',$bloglog_default['recent_post_title_search'] ) );

                    if( $recent_post_title_search ){ ?>
                        <h2 class="theme-block-title">

                            <?php echo esc_html( $recent_post_title_search ); ?>

                        </h2>
                    <?php } ?>
                </div>

                <div class="theme-list-group recent-list-group">

                    <?php
                    while( $related_posts_query->have_posts() ):
                        $related_posts_query->the_post(); ?>

                        <div class="search-recent-article-list">
                            <header class="entry-header">
                                <h3 class="entry-title entry-title-small">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                            </header>
                        </div>

                    <?php 
                    endwhile; ?>

                </div>

            </div>

            <?php
            wp_reset_postdata();

        endif;

    }

endif;


if( !function_exists( 'bloglog_header_banner_section' ) ) :

    function bloglog_header_banner_section(){
        $bloglog_default = bloglog_get_default_theme_options();
        $ed_header_banner = get_theme_mod( 'ed_header_banner', $bloglog_default['ed_header_banner'] );

        if ($ed_header_banner) {
            $header_banner_title = get_theme_mod( 'header_banner_title' );
            $header_banner_sub_title = get_theme_mod( 'header_banner_sub_title');
            $header_banner_description = get_theme_mod( 'header_banner_description');
            $header_banner_button_label = get_theme_mod( 'header_banner_button_label');
            $header_banner_button_link = get_theme_mod( 'header_banner_button_link');
            $header_image_url = get_header_image()
            ?>

            <div class='theme-header-banner data-bg theme-image-overlay' data-background = '<?php echo esc_url($header_image_url); ?>'>
                <div class="wrapper">
                    <div class="wrapper-inner">
                        <div class="column column-12">
                            <div class="header-banner-content">
                                <h2 class="entry-title entry-title-large">
                                    <!-- header banner title -->
                                    <?php echo esc_html($header_banner_title); ?>
                                </h2>

                                <h2 class="entry-title entry-title-small">
                                    <!-- header banner sub-title -->
                                    <?php echo esc_html($header_banner_sub_title); ?>
                                </h2>

                                <p>
                                    <!-- header description -->
                                    <?php echo esc_html($header_banner_description); ?>
                                </p>

                                <a href = '<?php echo esc_html($header_banner_button_link); ?>' class = 'theme-btn-link'>
                                    <?php echo esc_html($header_banner_button_label); ?>
                                </a>    
                                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }
    }

endif;

if( !function_exists('bloglog_carousel_section') ):

    // Single Posts Related Posts.
    function bloglog_carousel_section(){

        $bloglog_default = bloglog_get_default_theme_options();
        $ed_carousel_section = get_theme_mod( 'ed_carousel_section',$bloglog_default['ed_carousel_section'] );

        if( $ed_carousel_section ){

            $mg_carousel_section_cat = get_theme_mod( 'mg_carousel_section_cat' );
            $ed_carousel_autoplay = get_theme_mod( 'ed_carousel_autoplay',$bloglog_default['ed_carousel_autoplay'] );
            $ed_carousel_arrow = get_theme_mod( 'ed_carousel_arrow',$bloglog_default['ed_carousel_arrow'] );
            $ed_carousel_dots = get_theme_mod( 'ed_carousel_dots',$bloglog_default['ed_carousel_dots'] );

            if( $ed_carousel_autoplay ){
                $autoplay = 'true';
            }else{
                $autoplay = 'false';
            }
            if( $ed_carousel_arrow ){
                $arrow = 'true';
            }else{
                $arrow = 'false';
            }
            if( $ed_carousel_dots ){
                $dots = 'true';
            }else{
                $dots = 'false';
            }
            if( is_rtl() ){
                $rtl = 'true';
            }else{
                $rtl = 'false';
            }

            $carousel_posts_query = new WP_Query( array('post_type' => 'post', 'posts_per_page' => 5,'category_name' => $mg_carousel_section_cat,'post__not_in' => get_option("sticky_posts") ) );
            $count = 1;
            if( $carousel_posts_query->have_posts() ): ?>

                <div class="theme-block theme-block-carousel">
                    <div class="wrapper">
                        <div class="wrapper-inner wrapper-inner-nospace">
                            <div class="column column-12">
                                <div class="mg-carousel-action" data-slick='{ "arrows": <?php echo esc_attr($arrow); ?>, "rtl": <?php echo esc_attr($rtl); ?>}'>
    
                                    <?php
                                    while ($carousel_posts_query->have_posts()):
                                        $carousel_posts_query->the_post(); ?>
    
                                        <article id="post-<?php the_ID(); ?>" <?php post_class('theme-carousel-article'); ?>>
                                            <div class="entry-wrapper">
    
                                                <?php
                                                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium_large');
                                                $featured_image = isset($featured_image[0]) ? $featured_image[0] : ''; ?>
    
                                                <div class="wrapper-inner wrapper-inner-nospace">
                                                    <div class="column column-6 column-sm-12">
                                                        <div class="entry-thumbnail">
                                                            <a href="<?php the_permalink(); ?>" class="data-bg data-bg-large" data-background="<?php echo esc_url( $featured_image ); ?>">
                                                            </a>
        
                                                            <?php
                                                            $format = get_post_format(get_the_ID()) ?: 'standard';
                                                            $icon = minimal_grid_post_format_icon($format);
                                                            if (!empty($icon)) { ?>
                                                                <div class="post-format-icon"><?php echo minimal_grid_svg_escape($icon); ?></div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
    
                                                    <div class="column column-6 column-sm-12">
                                                        <div class="post-content">
        
                                                            <div class="entry-meta theme-meta-categories">
        
                                                                <?php bloglog_entry_footer($cats = true, $tags = false, $edits = false); ?>
        
                                                            </div>
        
                                                            <header class="entry-header">
        
                                                                <h2 class="entry-title entry-title-large">
        
                                                                    <a href="<?php the_permalink(); ?>" class = ' line-clamp-3 line-clamp-sm-2'>
        
                                                                        <?php the_title(); ?>
        
                                                                    </a>
                                                                </h2>
        
                                                            </header>
        
                                                            <div class="entry-meta">
        
                                                                <?php
                                                                bloglog_posted_by();
                                                                ?>
        
                                                            </div>
        
                                                        </div>

                                                        <div class="post-index-number">
                                                            <div class="index-number"> <?php echo $count++; echo esc_html(' / 5');?> </div>
                                                            <div class="slider-progress">
                                                                <div class="progress"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    
    
    
                                            </div>
                                        </article>
    
                                    <?php
                                    endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                wp_reset_postdata();

            endif;

        }

    }

endif;



if( !function_exists( 'bloglog_about_section' ) ) :

    function bloglog_about_section(){
        $bloglog_default = bloglog_get_default_theme_options();
        $ed_about_section = get_theme_mod( 'ed_about_section', $bloglog_default['ed_about_section'] );
        $twp_about_signature_image = get_theme_mod( 'twp_about_signature_image');
        $twp_about_background_image = get_theme_mod( 'twp_about_background_image');
        $homepage_about_title = get_theme_mod( 'about_section_title',$bloglog_default['about_section_title'] );
        if ($ed_about_section) {
        $bloglog_about_page = esc_attr(get_theme_mod('select_page_for_about'));
        if (!empty($bloglog_about_page)) {
            $bloglog_about_page_args = array(
                'post_type' => 'page',
                'page_id' => $bloglog_about_page,
            );
        }
        if (!empty($bloglog_about_page_args)) {
            $bloglog_about_page_query = new WP_Query($bloglog_about_page_args);
            while ($bloglog_about_page_query->have_posts()): $bloglog_about_page_query->the_post();
                if (has_post_thumbnail()) { 
                    $url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                    $url = isset($url[0]) ? $url[0] : ''; 
                }
                ?>
                <div class="theme-about-us data-bg theme-image-overlay theme-block" data-background='<?php echo esc_url($twp_about_background_image); ?>'>
                    <div class="wrapper">
                        
                        <div class="wrapper-inner">
                            <div class="column column-5 column-sm-6 column-xxs-12">
                                <div class="about-us-image">
                                    <div class="data-bg data-bg-custom" data-background='<?php echo esc_url($url); ?>'></div>
                
                                    <div class="image-overlay-position">
                                        <div class="data-bg data-bg-custom" data-background = '<?php echo esc_url($url); ?>'></div>
                                    </div>

                                    <div class="about-us-signature">
                                        <div class="data-bg" data-background = '<?php echo esc_url($twp_about_signature_image); ?>'></div>
                                    </div>
                                </div>

                            </div>


                            <div class="column column-7 column-sm-6 column-xxs-12">
                                <div class="about-us-content">
                                    <h2 class="entry-title entry-title-big"><?php the_title(); ?> </h2>
                                     <?php the_excerpt(); ?>
                                    <a href="<?php the_permalink(); ?>" class="theme-btn-link">  <?php echo esc_html__('Read More','bloglog');?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            <?php endwhile;
            wp_reset_postdata();
        }
        }
    }

endif;



if( !function_exists( 'bloglog_archive_log_section' ) ) :

    function bloglog_archive_log_section(){
        $bloglog_default = bloglog_get_default_theme_options();
        $ed_article_log_section = get_theme_mod( 'ed_article_log_section', $bloglog_default['ed_article_log_section'] );
        $ed_article_log_by_year = get_theme_mod( 'ed_article_log_by_year', $bloglog_default['ed_article_log_by_year'] );
        $ed_article_log_by_month = get_theme_mod( 'ed_article_log_by_month', $bloglog_default['ed_article_log_by_month'] );
        $ed_article_log_by_category = get_theme_mod( 'ed_article_log_by_category', $bloglog_default['ed_article_log_by_category'] );
        $ed_article_log_by_tags = get_theme_mod( 'ed_article_log_by_tags', $bloglog_default['ed_article_log_by_tags'] );
        $ed_article_log_by_author = get_theme_mod( 'ed_article_log_by_author', $bloglog_default['ed_article_log_by_author'] );
        $article_log_section_title = get_theme_mod( 'article_log_section_title', $bloglog_default['article_log_section_title'] );

        if ($ed_article_log_section) {
            ?>


            <div class="theme-block-timeline theme-block">
                <div class="wrapper">
                    <div class="wrapper-inner">
                        <div class="column column-12">
                            <div class="theme-panel-header">
                                <div class="theme-panel-title">
                                    <h2 class="entry-title entry-title-big">
                                        <?php echo esc_html($article_log_section_title); ?>
                                    </h2>
                                </div>
                            </div>

                            <div class="theme-panel-body">
                                <div class="wrapper-inner">
                                    <div class="column column-2 column-md-4 column-xxs-12">
                                        <div class="theme-panel-header">
                                            <div class="theme-panel-title">
                                                <h2 class = 'entry-title entry-title-small'>
                                                    By author
                                                </h2>
                                            </div>
                                        </div>

                                        <div class="theme-panel-body">
                                            <ul class='by-author-list theme-timeline-list'>
                                                <?php if ($ed_article_log_by_author) { ?>
                                                <?php
                                                $users = get_users(array('fields' => array('display_name', 'id')));
                                                // Array of stdClass objects.
                                                foreach ($users as $user) { ?>
                                                    <li>
                                                        <a href="<?php echo esc_url(get_author_posts_url($user->id)); ?>">
                                                        <span class="theme-author-image"><img
                                                                    src="<?php echo esc_url(get_avatar_url($user->id, ['size' => '100'])); ?>"
                                                                    alt="<?php echo esc_html($user->display_name); ?>"></span>
                                                            <span class="theme-author-title"><?php echo esc_html($user->display_name); ?></span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                            </ul>

                                            <span class="theme-more-btn">
                                                <a href="">show more</a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="column column-2 column-md-4 column-xxs-12">
                                        <div class="theme-panel-header">
                                            <div class="theme-panel-title">
                                                <h2 class = 'entry-title entry-title-small'>
                                                    By year
                                                </h2>
                                            </div>
                                        </div>

                                        <div class="theme-panel-body">
                                            <ul class='theme-timeline-list'>
                                                <!-- date year -->
                                                <?php if ($ed_article_log_by_year) { ?>
                                                    <?php wp_get_archives(array('type' => 'yearly')); ?>
                                                <?php } ?>
                                            </ul>

                                            <span class="theme-more-btn">
                                                <a href=""> show more </a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="column column-2 column-md-4 column-xxs-12">
                                        <div class="theme-panel-header">
                                            <div class="theme-panel-title">
                                                <h2 class = 'entry-title entry-title-small'>
                                                    By month
                                                </h2>
                                            </div>
                                        </div>

                                        <div class="theme-panel-body">
                                            <!-- date month  year -->
                                            <?php if ($ed_article_log_by_month) { ?>
                                                <ul class="theme-timeline-list">
                                                    <?php wp_get_archives('monthnum'); ?>
                                                </ul>

                                                <span class="theme-more-btn">
                                                    <a href=""> show more </a>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="column column-3 column-md-4 column-xxs-12">
                                        <div class="theme-panel-header">
                                            <div class="theme-panel-title">
                                                <h2 class = 'entry-title entry-title-small'>
                                                    By categories
                                                </h2>
                                            </div>
                                        </div>

                                        <div class="theme-panel-body">
                                            <div class="entry-meta">
                                                <div class="cat-links">
                                                    <!-- category -->
                                                    <?php if ($ed_article_log_by_category) { ?>
                                                        <?php
                                                        $args = array(
                                                            'orderby' => 'id',
                                                            'hide_empty' => 0,
                                                        );
                                                        $categories = get_categories($args);
                                                        foreach ($categories as $cat) { ?>
                                                            <a href='<?php echo esc_url(get_category_link($cat->term_id)); ?>'> <?php echo esc_html($cat->name); ?></a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <span class="theme-more-btn">
                                                <a href=""> show more </a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="column column-3 column-md-4 column-xxs-12">
                                        <div class="theme-panel-header">
                                            <div class="theme-panel-title">
                                                <h2 class = 'entry-title entry-title-small'>
                                                    By tags
                                                </h2>
                                            </div>
                                        </div>

                                        <div class="theme-panel-body">
                                            <!--  taggs -->
                                            <?php if ($ed_article_log_by_tags) { ?>
                                                <div class="entry-meta">
                                                    <div class="cat-links">
                                                        <?php
                                                        $tags = get_tags(array(
                                                            'hide_empty' => false
                                                        ));
                                                        foreach ($tags as $tag) { ?>
                                                            <a
                                                            href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"><?php echo esc_html($tag->name); ?></a>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <span class="theme-more-btn">
                                                    <a href=""> show more </a>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        <?php
        }
    }

endif;


if( !function_exists('bloglog_header_search_top_cat_content') ):

    function bloglog_header_search_top_cat_content(){

        $top_category = 3;

        $post_cat_lists = get_categories(
            array(
                'hide_empty' => '0',
                'exclude' => '1',
            )
        );

        $slug_counts = array();

        foreach( $post_cat_lists as $post_cat_list ){

            if( $post_cat_list->count >= 1 ){

                $slug_counts[] = array( 
                    'count'         => $post_cat_list->count,
                    'slug'          => $post_cat_list->slug,
                    'name'          => $post_cat_list->name,
                    'cat_ID'        => $post_cat_list->cat_ID,
                    'description'   => $post_cat_list->category_description, 
                );

            }

        }

        if( $slug_counts ){?>

            <div class="popular-search-categories">
                
                <div class="theme-block-heading">
                    <?php
                    $bloglog_default = bloglog_get_default_theme_options();
                    $top_category_title_search = esc_html( get_theme_mod( 'top_category_title_search',$bloglog_default['top_category_title_search'] ) );

                    if( $top_category_title_search ){ ?>
                        <h2 class="theme-block-title">

                            <?php echo esc_html( $top_category_title_search ); ?>

                        </h2>
                    <?php } ?>
                </div>

                <?php
                arsort( $slug_counts ); ?>

                <div class="theme-list-group categories-list-group">
                    <div class="wrapper-inner">

                        <?php
                        $i = 1;
                        foreach( $slug_counts as $key => $slug_count ){

                            if( $i > $top_category){ break; }
                            
                            $cat_link           = get_category_link( $slug_count['cat_ID'] );
                            $cat_name           = $slug_count['name'];
                            $cat_slug           = $slug_count['slug'];
                            $cat_count          = $slug_count['count'];
                            $twp_term_image = get_term_meta( $slug_count['cat_ID'], 'twp-term-featured-image', true ); ?>

                            <div class="column column-4 column-sm-12">
                                <article id="post-<?php the_ID(); ?>" <?php post_class('theme-grid-article'); ?>>
                                        <div class="entry-wrapper">
                                            <?php if ($twp_term_image) { ?>
                                                <div class="entry-thumbnail">
                                                    <a href="<?php echo esc_url($cat_link); ?>" class="data-bg data-bg-medium" data-background="<?php echo esc_url($twp_term_image); ?>"></a>
                                                </div>
                                            <?php } ?>

                                            <div class="post-content">
                                                <header class="entry-header">
                                                    <h3 class="entry-title">
                                                        <a href="<?php echo esc_url($cat_link); ?>">
                                                            <?php echo esc_html($cat_name); ?>
                                                        </a>
                                                    </h3>
                                                </header>
                                            </div>
                                        </div>
                                </article>
                            </div>

                            <?php
                            $i++;

                        } ?>

                    </div>
                </div>

            </div>
        <?php
        }

    }

endif;

add_action( 'bloglog_before_footer_content_action','bloglog_header_toggle_search',10 );

if( !function_exists('bloglog_content_offcanvas') ):

    // Offcanvas Contents
    function bloglog_content_offcanvas(){ ?>

        <div id="offcanvas-menu">
            <div class="offcanvas-wraper">

                <div class="close-offcanvas-menu">
                    <div class="offcanvas-close">

                        <a href="javascript:void(0)" class="skip-link-menu-start"></a>

                        <button type="button" class="button-offcanvas-close">
                            <?php bloglog_the_theme_svg('close'); ?>
                        </button>

                    </div>
                </div>

                <div id="primary-nav-offcanvas" class="offcanvas-item offcanvas-main-navigation">
                    <nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e('Horizontal', 'bloglog'); ?>" role="navigation">
                        <ul class="primary-menu">

                            <?php
                            if( has_nav_menu('bloglog-primary-menu') ){

                                wp_nav_menu(
                                    array(
                                        'container' => '',
                                        'items_wrap' => '%3$s',
                                        'theme_location' => 'bloglog-primary-menu',
                                        'show_toggles' => true,
                                    )
                                );

                            }else{
                                
                                wp_list_pages(
                                    array(
                                        'match_menu_classes' => true,
                                        'show_sub_menu_icons' => false,
                                        'title_li' => false,
                                        'show_toggles' => true,
                                        'walker' => new Bloglog_Walker_Page(),
                                    )
                                );
                            } ?>

                        </ul>
                    </nav><!-- .primary-menu-wrapper -->
                </div>

                <?php if( has_nav_menu('bloglog-social-menu') ){ ?>

                    <div id="social-nav-offcanvas" class="offcanvas-item offcanvas-social-navigation">

                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'bloglog-social-menu',
                            'link_before' => '<span class="screen-reader-text">',
                            'link_after' => '</span>',
                            'container' => 'div',
                            'container_class' => 'social-menu',
                            'depth' => 1,
                        )); ?>

                    </div>

                <?php } ?>

                <a href="javascript:void(0)" class="skip-link-menu-end"></a>

            </div>
        </div>

    <?php
    }

endif;

add_action( 'bloglog_before_footer_content_action','bloglog_content_offcanvas',30 );

if( !function_exists('bloglog_footer_content_widget') ):

    function bloglog_footer_content_widget(){

        $bloglog_default = bloglog_get_default_theme_options();
        if( is_active_sidebar('bloglog-footer-widget-0') || 
            is_active_sidebar('bloglog-footer-widget-1') || 
            is_active_sidebar('bloglog-footer-widget-2') ):

            $x = 1;
            $footer_sidebar = 0;
            do {
                if ($x == 3 && is_active_sidebar('bloglog-footer-widget-2')) {
                    $footer_sidebar++;
                }
                if ($x == 2 && is_active_sidebar('bloglog-footer-widget-1')) {
                    $footer_sidebar++;
                }
                if ($x == 1 && is_active_sidebar('bloglog-footer-widget-0')) {
                    $footer_sidebar++;
                }
                $x++;
            } while ($x <= 3);
            if ($footer_sidebar == 1) {
                $footer_sidebar_class = 12;
            } elseif ($footer_sidebar == 2) {
                $footer_sidebar_class = 6;
            } else {
                $footer_sidebar_class = 4;
            }
            $footer_column_layout = absint(get_theme_mod('footer_column_layout', $bloglog_default['footer_column_layout'])); ?>

            <div class="footer-widgetarea">
                <div class="wrapper">
                    <div class="wrapper-inner">

                        <?php if (is_active_sidebar('bloglog-footer-widget-0')): ?>
                            <div class="column <?php echo 'column-' . absint($footer_sidebar_class); ?> column-sm-12">
                                <?php dynamic_sidebar('bloglog-footer-widget-0'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (is_active_sidebar('bloglog-footer-widget-1')): ?>
                            <div class="column <?php echo 'column-' . absint($footer_sidebar_class); ?> column-sm-12">
                                <?php dynamic_sidebar('bloglog-footer-widget-1'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (is_active_sidebar('bloglog-footer-widget-2')): ?>
                            <div class="column <?php echo 'column-' . absint($footer_sidebar_class); ?> column-sm-12">
                                <?php dynamic_sidebar('bloglog-footer-widget-2'); ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        <?php
        endif;

    }

endif;

add_action( 'bloglog_footer_content_action','bloglog_footer_content_widget',10 );


if( !function_exists('bloglog_footer_content_info') ):

    /**
     * Footer Copyright Area
    **/
    function bloglog_footer_content_info(){

        $bloglog_default = bloglog_get_default_theme_options(); ?>
        <div class="footer-credits">
            <div class="wrapper">
                <div class="wrapper-inner">

                    <div class="column column-10">

                        <div class="footer-copyright">

                            <?php
                            $ed_footer_copyright = wp_kses_post(get_theme_mod('ed_footer_copyright', $bloglog_default['ed_footer_copyright']));
                            $footer_copyright_text = wp_kses_post(get_theme_mod('footer_copyright_text', $bloglog_default['footer_copyright_text']));

                            echo esc_html__('Copyright ', 'bloglog') . '&copy ' . absint(date('Y')) . ' <a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name', 'display')) . '" ><span>' . esc_html(get_bloginfo('name', 'display')) . '. </span></a> ' . esc_html($footer_copyright_text);

                            if ($ed_footer_copyright) {

//                                 echo '<br>';
//                                 echo esc_html__('Theme: ', 'bloglog') . 'Bloglog ' . esc_html__('By ', 'bloglog') . '<a href="' . esc_url('https://www.themeinwp.com/theme/bloglog') . '"  title="' . esc_attr__('Themeinwp', 'bloglog') . '" target="_blank" rel="author"><span>' . esc_html__('Themeinwp. ', 'bloglog') . '</span></a>';

//                                 echo esc_html__('Powered by ', 'bloglog') . '<a href="' . esc_url('https://wordpress.org') . '" title="' . esc_attr__('WordPress', 'bloglog') . '" target="_blank"><span>' . esc_html__('WordPress.', 'bloglog') . '</span></a>';

                            } ?>

                        </div>

                    </div>

                    <div class="column column-2">
                        <?php bloglog_footer_go_to_top(); ?>
                    </div>

                </div>
            </div>
        </div>
    <?php
    }

endif;

add_action( 'bloglog_footer_content_action','bloglog_footer_content_info',20 );


if( !function_exists('bloglog_footer_go_to_top') ):

    // Scroll to Top render content
    function bloglog_footer_go_to_top(){ ?>

        <a class="to-the-top theme-action-control" href="#site-header">
            <span class="action-control-trigger" tabindex="-1">
                <span class="to-the-top-long">
                    <?php printf(esc_html__('To the Top %s', 'bloglog'), '<span class="arrow" aria-hidden="true">&uarr;</span>'); ?>
                </span>
                <span class="to-the-top-short">
                    <?php printf(esc_html__('Up %s', 'bloglog'), '<span class="arrow" aria-hidden="true">&uarr;</span>'); ?>
                </span>
            </span>
        </a>
    
    <?php
    }

endif;

if( !function_exists('bloglog_color_schema_color') ):

    function bloglog_color_schema_color( $current_color ){

        $bloglog_default = bloglog_get_default_theme_options();

        $colors_schema = array(

            'default' => array(

                'background_color' => '#f5f6f8',
                'bloglog_primary_color' => $bloglog_default['bloglog_primary_color'],
                'bloglog_secondary_color' => $bloglog_default['bloglog_secondary_color'],
                'bloglog_general_color' => $bloglog_default['bloglog_general_color'],

            ),
            'dark' => array(

                'background_color' => '#222222',
                'bloglog_primary_color' => $bloglog_default['bloglog_primary_color_dark'],
                'bloglog_secondary_color' => $bloglog_default['bloglog_secondary_color_dark'],
                'bloglog_general_color' => $bloglog_default['bloglog_general_color_dark'],

            ),
            'fancy' => array(

                'background_color' => '#faf7f2',
                'bloglog_primary_color' => $bloglog_default['bloglog_primary_color_fancy'],
                'bloglog_secondary_color' => $bloglog_default['bloglog_secondary_color_fancy'],
                'bloglog_general_color' => $bloglog_default['bloglog_general_color_fancy'],

            ),

        );

        if( isset( $colors_schema[$current_color] ) ){
            
            return $colors_schema[$current_color];

        }

        return;

    }

endif;



if ( ! function_exists( 'bloglog_color_schema_color_action' ) ) :
    
    function bloglog_color_schema_color_action() {

        if( isset( $_POST['currentColor'] ) && sanitize_text_field( wp_unslash( $_POST['currentColor'] ) ) ){
         
            $current_color = sanitize_text_field( wp_unslash( $_POST['currentColor'] ) );

            $color_schemes = bloglog_color_schema_color( $current_color );

            if ( $color_schemes ) {
                echo json_encode( $color_schemes );
            }
        }
    
        wp_die();

    }

endif;

add_action( 'wp_ajax_nopriv_bloglog_color_schema_color', 'bloglog_color_schema_color_action' );
add_action( 'wp_ajax_bloglog_color_schema_color', 'bloglog_color_schema_color_action' );

if( ! function_exists( 'bloglog_iframe_escape' ) ):
    
    /** Escape Iframe **/
    function bloglog_iframe_escape( $input ){

        $all_tags = array(
            'iframe'=>array(
                'width'=>array(),
                'height'=>array(),
                'src'=>array(),
                'frameborder'=>array(),
                'allow'=>array(),
                'allowfullscreen'=>array(),
            ),
            'video'=>array(
                'width'=>array(),
                'height'=>array(),
                'src'=>array(),
                'style'=>array(),
                'controls'=>array(),
            )
        );

        return wp_kses($input,$all_tags);
        
    }

endif;

if( class_exists( 'Booster_Extension_Class' ) ){

    add_filter('booster_extemsion_content_after_filter','bloglog_after_content_pagination');

}

if( !function_exists('bloglog_after_content_pagination') ):

    function bloglog_after_content_pagination($after_content){

        $pagination_single = wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bloglog' ),
                    'after'  => '</div>',
                    'echo' => false
                ) );

        $after_content =  $pagination_single.$after_content;

        return $after_content;

    }

endif;

if( !function_exists('bloglog_excerpt_content') ):

    function bloglog_excerpt_content(){ 

        $bloglog_default = bloglog_get_default_theme_options();
        $ed_post_excerpt = get_theme_mod( 'ed_post_excerpt',$bloglog_default['ed_post_excerpt'] );

        if( $ed_post_excerpt ){ ?>
                    
            <div class="entry-content entry-content-muted">

                <?php
                if( has_excerpt() ){

                    the_excerpt();

                }else{

                    echo esc_html( wp_trim_words( get_the_content(), 25, '...' ) );

                } ?>

            </div>

        <?php }
    }

endif;

if( !function_exists('bloglog_video_content_render') ):

    function bloglog_video_content_render( $class1 = '', $class2 = '', $class3 = '', $ratio_value = 'default', $video_autoplay = 'autoplay-disable' ){

        $image_size = 'medium_large'; ?>


        <article id="post-<?php the_ID(); ?>" <?php post_class('twp-archive-items'); ?>>
            <div class="entry-wrapper">
                <?php
                if( $video_autoplay == 'autoplay-enable' ){
                    $autoplay_class = 'pause';
                    $play_pause_text = esc_html__('Pause','bloglog');
                }else{
                    $autoplay_class = 'play';
                    $play_pause_text = esc_html__('Play','bloglog');
                }

                add_filter('booster_extension_filter_like_ed', function ( ) {
                    return false;
                });

                $content = apply_filters( 'the_content', get_the_content() );
                $video = false;

                // Only get video from the content if a playlist isn't present.
                if ( false === strpos( $content, 'wp-playlist-script' ) ) {

                    $video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );

                }

                if ( ! empty( $video ) ) { ?>

                    <div class="entry-content-media">
                        <div class="twp-content-video">

                            <?php
                            foreach ( $video as $video_html ) { ?>

                                <div class="entry-video theme-ratio-<?php echo esc_attr( $ratio_value ); ?>">
                                    <div class="twp-video-control-buttons hide-no-js">

                                        <button attr-id="<?php echo esc_attr( $class2 ); ?>-<?php echo absint( get_the_ID() ); ?>" class="theme-video-control theme-action-control twp-pause-play <?php echo esc_attr( $autoplay_class ); ?>">
                                            <span class="action-control-trigger">
                                                <span class="twp-video-control-action">
                                                    <?php bloglog_the_theme_svg( $autoplay_class ); ?>
                                                </span>

                                                <span class="screen-reader-text">
                                                    <?php echo $play_pause_text; ?>
                                                </span>
                                            </span>
                                        </button>

                                        <button attr-id="<?php echo esc_attr( $class2 ); ?>-<?php echo absint( get_the_ID() ); ?>" class="theme-video-control theme-action-control twp-mute-unmute unmute">
                                            <span class="action-control-trigger">
                                                <span class="twp-video-control-action">
                                                    <?php bloglog_the_theme_svg('mute'); ?>
                                                </span>

                                                <span class="screen-reader-text">
                                                    <?php esc_html_e('Unmute','bloglog'); ?>
                                                </span>
                                            </span>
                                        </button>

                                    </div>

                                    <div class="theme-video-panel <?php echo esc_attr( $class3 ); ?>" data-autoplay="<?php echo esc_attr( $video_autoplay ); ?>" data-id="<?php echo esc_attr( $class2 ); ?>-<?php echo absint( get_the_ID() ); ?>">
                                        <?php echo bloglog_iframe_escape( $video_html ); ?>
                                    </div>

                                </div>

                                <?php
                                break;

                            } ?>

                            <?php
                            $format = get_post_format(get_the_ID()) ?: 'standard';
                            $icon = minimal_grid_post_format_icon($format);
                            if (!empty($icon)) { ?>
                                <div class="post-format-icon"><?php echo minimal_grid_svg_escape($icon); ?></div>
                            <?php } ?>
                
                        </div>
                    </div>

                <?php
                }else{


                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium_large' );
                    $featured_image = isset( $featured_image[0] ) ? $featured_image[0] : '';
                    if( $featured_image ){ ?>

                    <div class="entry-thumbnail">

                        <a href="<?php the_permalink(); ?>">
                            <img class="entry-responsive-thumbnail" src="<?php echo esc_url( $featured_image ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                        </a>

                        <?php
                        $format = get_post_format(get_the_ID()) ?: 'standard';
                        $icon = minimal_grid_post_format_icon($format);
                        if (!empty($icon)) { ?>
                            <div class="post-format-icon"><?php echo minimal_grid_svg_escape($icon); ?></div>
                        <?php } ?>

                    </div>

                <?php
                }

                } ?>

                <div class="post-content">

                    <div class="entry-meta theme-meta-categories">

                        <?php bloglog_entry_footer($cats = true, $tags = false, $edits = false); ?>

                    </div>

                    <header class="entry-header">

                        <h2 class="entry-title entry-title-small">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                    </header>

                    <div class="entry-meta">
                        <?php
                        bloglog_posted_by();
                        ?>
                    </div>

                    <div class="entry-content entry-content-muted entry-content-small">

                        <?php
                        if( has_excerpt() ){

                            the_excerpt();

                        }else{

                            echo '<p>';
                            echo esc_html( wp_trim_words( get_the_content(),25,'...' ) );
                            echo '</p>';

                        } ?>

                    </div>

                    <?php bloglog_read_more_render(); ?>

                </div>
            </div>
        </article>
    
    <?php
    }

endif;

if( !function_exists('bloglog_get_sidebar') ):

    function bloglog_get_sidebar(){

        $bloglog_default = bloglog_get_default_theme_options();
        $bloglog_post_sidebar_option = esc_attr( get_post_meta( get_the_ID(), 'bloglog_post_sidebar_option', true ) );
        if( $bloglog_post_sidebar_option == '' || $bloglog_post_sidebar_option == 'global-sidebar' ){

            $global_sidebar_layout = get_theme_mod( 'global_sidebar_layout',$bloglog_default['global_sidebar_layout'] );    
            $sidebar = $global_sidebar_layout;
        }else{
            $sidebar = $bloglog_post_sidebar_option;
        }

        if ( ! is_active_sidebar( 'sidebar-1' ) ) {
            $sidebar = 'no-sidebar';
        }
        return $sidebar;

    }

endif;

if (!function_exists('minimal_grid_post_format_icon')):

    // Post Format Icon.
    function minimal_grid_post_format_icon($format)
    {

        if( $format == 'video' ){
            $icon = bloglog_get_theme_svg( 'video' );
        }elseif( $format == 'audio' ){
            $icon = bloglog_get_theme_svg( 'audio' );
        }elseif( $format == 'gallery' ){
            $icon = bloglog_get_theme_svg( 'gallery' );
        }elseif( $format == 'quote' ){
            $icon = bloglog_get_theme_svg( 'quote' );
        }elseif( $format == 'image' ){
            $icon = bloglog_get_theme_svg( 'image' );
        }else{
            $icon = '';
        }

        return $icon;
        
    }

endif;

if ( ! function_exists( 'minimal_grid_svg_escape' ) ):

    /**
     * Get information about the SVG icon.
     *
     * @param string $svg_name The name of the icon.
     * @param string $group The group the icon belongs to.
     * @param string $color Color code.
     */
    function minimal_grid_svg_escape( $input ) {

        // Make sure that only our allowed tags and attributes are included.
        $svg = wp_kses(
            $input,
            array(
                'svg'     => array(
                    'class'       => true,
                    'xmlns'       => true,
                    'width'       => true,
                    'height'      => true,
                    'viewbox'     => true,
                    'aria-hidden' => true,
                    'role'        => true,
                    'focusable'   => true,
                ),
                'path'    => array(
                    'fill'      => true,
                    'fill-rule' => true,
                    'd'         => true,
                    'transform' => true,
                ),
                'polygon' => array(
                    'fill'      => true,
                    'fill-rule' => true,
                    'points'    => true,
                    'transform' => true,
                    'focusable' => true,
                ),
            )
        );

        if ( ! $svg ) {
            return false;
        }

        return $svg;

    }

endif;

if ( ! function_exists( 'minimal_grid_render_filter' ) ):

    function minimal_grid_render_filter(  ) {

        $bloglog_post_category_list = bloglog_post_category_list(false); ?>

                <div class="theme-panelarea-header">
                    <div class="article-filter-bar">

                        <?php if ( class_exists( 'Booster_Extension_Class' ) ) { ?>

                        <div class="article-filter-area filter-area-left">

                            <div class="article-filter-label">
                                <span><?php bloglog_the_theme_svg('sort'); ?></span>
                                <span><?php esc_html_e('Sort By:','bloglog'); ?></span>
                            </div>

                            <div data-filter-group="popularity" class="article-filter-type article-views-filter">
                                <button class="theme-button theme-button-filters theme-action-control twp-most-liked">
                                    <span class="action-control-trigger" tabindex="-1">
                                        <?php esc_html_e('Most Liked','bloglog'); ?>
                                    </span>
                                </button>
                                <button class="theme-button theme-button-filters theme-action-control twp-most-viewed">
                                    <span class="action-control-trigger" tabindex="-1">
                                        <?php esc_html_e('Most Viewed','bloglog'); ?>
                                    </span>
                                </button>
                            </div>

                        </div>

                        <?php } ?>

                        <div class="article-filter-area filter-area-right">
                            <div class="article-filter-item">
                                <div class="article-filter-label">
                                    <span><?php bloglog_the_theme_svg('filter'); ?></span>
                                    <span><?php esc_html_e('Filter By:', 'bloglog'); ?></span>
                                </div>

                                <div data-filter-group="category" class="article-filter-type article-categories-filter">

                                    <div class="theme-categories-multiselect">
                                        <button class="theme-categories-selection theme-button theme-button-filters theme-action-control" data-filter=".">
                                            <span class="action-control-trigger" tabindex="-1">
                                                <?php esc_html_e('Select Category', 'bloglog'); ?>
                                                <span class="theme-filter-icon dropdown-select-arrow"><?php bloglog_the_theme_svg('chevron-down'); ?></span>
                                            </span>
                                        </button>
                                        <span class="theme-categories-selected"></span>
                                    </div>

                                    <div class="theme-categories-dropdown">
                                        <?php if ($bloglog_post_category_list) {

                                            foreach ($bloglog_post_category_list as $key => $category) {
                                                if ($category) { ?>

                                                    <div class="cat-filter-item">
                                                        <button class="twp-filter-<?php echo esc_attr($key); ?> theme-button theme-button-filters theme-action-control" data-filter=".<?php echo esc_attr($key); ?>">
                                                            <span class="action-control-trigger" tabindex="-1">
                                                                <?php echo esc_html($category); ?>
                                                            </span>
                                                        </button>
                                                    </div>

                                                <?php }
                                            }
                                        } ?>
                                    </div>

                                </div>
                            </div>

                            <div class="article-filter-item">
                                <div class="article-filter-label">
                                    <span><?php bloglog_the_theme_svg('settings'); ?></span>
                                    <span><?php esc_html_e('Post Format:','bloglog'); ?></span>
                                </div>

                                <div data-filter-group="" class="article-filter-type article-format-filter">
                                    <button class="theme-button theme-button-filters theme-action-control" data-filter=".standard">
                                        <span class="action-control-trigger theme-filter-icon" tabindex="-1">
                                            <?php bloglog_the_theme_svg('standard'); ?>
                                        </span>
                                    </button>

                                    <button class="theme-button theme-button-filters theme-action-control" data-filter=".gallery">
                                        <span class="action-control-trigger theme-filter-icon" tabindex="-1">
                                            <?php bloglog_the_theme_svg('gallery'); ?>
                                        </span>
                                    </button>

                                    <button class="theme-button theme-button-filters theme-action-control" data-filter=".video">
                                        <span class="action-control-trigger theme-filter-icon" tabindex="-1">
                                            <?php bloglog_the_theme_svg('video'); ?>
                                        </span>
                                    </button>

                                    <button class="theme-button theme-button-filters theme-action-control" data-filter=".quote">
                                        <span class="action-control-trigger theme-filter-icon" tabindex="-1">
                                            <?php bloglog_the_theme_svg('quote'); ?>
                                        </span>
                                    </button>

                                    <button class="theme-button theme-button-filters theme-action-control" data-filter=".audio">
                                        <span class="action-control-trigger theme-filter-icon" tabindex="-1">
                                            <?php bloglog_the_theme_svg('audio'); ?>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div class="article-filter-item article-filter-clear">
                                <button class="theme-button theme-button-filters theme-action-control">
                                    <span class="action-control-trigger" tabindex="-1">
                                        <span class="theme-filter-icon filter-clear-icon"><?php bloglog_the_theme_svg('cross'); ?></span>
                                        <?php esc_html_e('Reset', 'bloglog'); ?>
                                    </span>
                                </button>

                            </div>

                        </div>
                    </div>
                </div>
    <?php
    }

endif;