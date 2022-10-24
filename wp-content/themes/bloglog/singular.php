<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bloglog
 * @since 1.0.0
 */
get_header();
    global $post;
    $bloglog_ed_post_rating = esc_html( get_post_meta( $post->ID, 'bloglog_ed_post_rating', true ) );
    $sidebar = bloglog_get_sidebar();
    if( $sidebar == 'left-sidebar' || $sidebar == 'right-sidebar' ){
        $class_1 = 'column-8';

        if( $sidebar == 'left-sidebar' ){
            $class_2 = 'order-2';
            $class_3 = 'order-1';
        }else{
            $class_2 = 'order-1';
            $class_3 = 'order-2';
        }
        
    }else{
        $class_1 = 'column-12';
        $class_2 = '';
        $class_3 = '';
    } ?>

    <div class="wrapper">
        <div class="wrapper-inner">

            <div class="theme-panelarea-primary column <?php echo $class_1; ?> <?php echo $class_2; ?> column-md-12">
                <main id="main" class="site-main <?php if( $bloglog_ed_post_rating ){ echo 'bloglog-no-comment'; } ?>" role="main">

                    <?php
                    if( have_posts() ): ?>

                        <div class="article-wraper">


                            <?php while (have_posts()) :
                                the_post();

                                get_template_part('template-parts/content', 'single');

                                /**
                                 *  Output comments wrapper if it's a post, or if comments are open,
                                 * or if there's a comment number – and check for password.
                                **/

                                if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && !post_password_required() ) { ?>

                                    <div class="comments-wrapper">
                                        <?php comments_template(); ?>
                                    </div><!-- .comments-wrapper -->

                                <?php
                                }

                            endwhile; ?>

                        </div>

                    <?php
                    else :

                        get_template_part('template-parts/content', 'none');

                    endif;

                    /**
                     * Navigation
                     *
                     * @hooked bloglog_post_floating_nav - 10
                     * @hooked bloglog_related_posts - 20
                     * @hooked bloglog_single_post_navigation - 30
                    */

                    do_action('bloglog_navigation_action'); ?>

                </main>
            </div>

            <?php if( $sidebar != 'no-sidebar' ){ ?>
                <div class="theme-panelarea-secondary column column-4 column-md-12 <?php echo $class_3; ?>">
                    <?php get_sidebar(); ?>
                </div>
            <?php } ?>

        </div>
    </div>

<?php
get_footer();
