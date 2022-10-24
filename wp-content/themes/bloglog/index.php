<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bloglog
 * @since 1.0.0
 */
get_header(); ?>
    <div class="theme-block theme-block-masonry">
        <div class="wrapper">
            <div class="wrapper-inner wrapper-inner-small">
                <div class="column column-1 column-md-2 hidden-xxs-screen">
                    <?php
                    $bloglog_default = bloglog_get_default_theme_options();
                    $ed_post_filter = get_theme_mod('ed_post_filter',$bloglog_default['ed_post_filter'] );
                    
                    if( $ed_post_filter && ( is_archive() || ( is_home() && is_front_page() ) ) ){
                        minimal_grid_render_filter();
                    } ?>
                </div>
                            
                <div class="column column-11 column-md-10 column-xxs-12">
                    <div class="theme-panelarea-body">
                        <div class="theme-panelarea theme-panelarea-blocks twp-active-isotope">
            
                            <?php
                            if (!is_front_page()) { ?>
            
                                <div class="theme-panel-blocks theme-header-panel archive-breadcrumb-panel twp-archive-items-main twp-latest-posts-block">
                                    <div class="twp-archive-header">
                                        <?php bloglog_breadcrumb(); ?>
                                        <?php bloglog_archive_title(); ?>
                                    </div>
                                </div>
            
                            <?php }
            
            
                            if (have_posts()):
            
                                $i = 1;
                                while (have_posts()) :
                                    the_post();
            
                                    $twp_be_post_views_count = absint( get_post_meta( get_the_ID(), 'twp_be_post_views_count', true ) );
                                    $twp_be_like_count = absint( get_post_meta( get_the_ID(), 'twp_be_like_count', true ) );
                                    $artical_classes = '';
                                    $categories = get_the_category();
                                    if( $categories ){ foreach( $categories as $category ){ $artical_classes .= ' '.$category->slug; } }
                                    $post_format = get_post_format(get_the_ID());
                                    if( empty( $post_format ) ){ $post_format = 'standard'; }
                                    $artical_classes .= ' '.$post_format; ?>
            
                                    <?php if( $i == 1 ){ ?>
                                        <div class="mg-grid-sizer"></div>
                                    <?php } ?>
            
                                    <div class="theme-panel-blocks article-panel-blocks twp-archive-items-main twp-latest-posts-block <?php echo esc_attr( $artical_classes ); ?>" data-category="<?php echo esc_attr( $artical_classes ); ?>" data-like="<?php echo esc_attr( $twp_be_like_count ); ?>" data-views="<?php echo esc_attr( $twp_be_post_views_count ); ?>">
            
                                        <?php if ( class_exists( 'Booster_Extension_Class' ) ) { ?>
                                            <div style="display: none;" class="twp-post-views"><?php echo $twp_be_post_views_count; ?></div>
                                            <div style="display: none;" class="twp-post-like"><?php echo $twp_be_like_count; ?></div>
                                        <?php } ?>
                                    
                                    <?php
                                    get_template_part('template-parts/content', get_post_format());
            
                                    ?></div><?php
            
                                    $i++;
                                endwhile;
            
                            else :
            
                                get_template_part('template-parts/content', 'none');
            
                            endif; ?>
            
                        </div>
            
                        <?php do_action('bloglog_archive_pagination'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer();
