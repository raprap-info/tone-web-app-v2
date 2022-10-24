<?php
/**
 * Tab Posts Widgets.
 *
 * @package Bloglog
 */

if ( !function_exists('bloglog_tab_posts_widgets') ) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function bloglog_tab_posts_widgets(){
        // Tab Post widget.
        register_widget('Bloglog_Tab_Posts_Widget');

    }
endif;
add_action('widgets_init', 'bloglog_tab_posts_widgets');

/* Tabed widget */
if ( !class_exists('Bloglog_Tab_Posts_Widget') ):

    /**
     * Tabbed widget Class.
     *
     * @since 1.0.0
     */
    class Bloglog_Tab_Posts_Widget extends Bloglog_Widget_Base {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct() {

            $opts = array(
                'classname'   => 'bloglog_widget_tabbed',
                'description' => esc_html__('Tabbed widget.', 'bloglog'),
            );
            $fields = array(
                'popular_heading' => array(
                    'label'          => esc_html__('Popular', 'bloglog'),
                    'type'           => 'heading',
                ),
                'popular_post_title' => array(
                    'label'         => esc_html__('Popular Posts Title', 'bloglog'),
                    'type'          => 'text',
                    'default'          => esc_html__('Popular', 'bloglog'),
                ),
                'popular_number' => array(
                    'label'         => esc_html__('No. of Posts:', 'bloglog'),
                    'type'          => 'number',
                    'css'           => 'max-width:60px;',
                    'default'       => 5,
                    'min'           => 1,
                    'max'           => 10,
                ),
                'select_image_size' => array(
                    'label' => esc_html__('Select Image Size Featured Post:', 'bloglog'),
                    'type' => 'select',
                    'default' => 'medium',
                    'options' => array(
                        'thumbnail' => esc_html__('Thumbnail', 'bloglog'),
                        'medium' => esc_html__( 'Medium', 'bloglog' ),
                        'large' => esc_html__( 'Large', 'bloglog' ),
                        'full' => esc_html__( 'Full', 'bloglog' ),
                        ),
                    
                ),
                'excerpt_length' => array(
                    'label'         => esc_html__('Excerpt Length:', 'bloglog'),
                    'description'   => esc_html__('Number of words', 'bloglog'),
                    'default'       => 10,
                    'css'           => 'max-width:60px;',
                    'min'           => 0,
                    'max'           => 200,
                ),
                'recent_heading' => array(
                    'label'         => esc_html__('Recent', 'bloglog'),
                    'type'          => 'heading',
                ),
                'recent_post_title' => array(
                    'label'         => esc_html__('Recent Posts Title', 'bloglog'),
                    'type'          => 'text',
                    'default'          => esc_html__('Recent', 'bloglog'),
                ),
                'recent_number' => array(
                    'label'        => esc_html__('No. of Posts:', 'bloglog'),
                    'type'         => 'number',
                    'css'          => 'max-width:60px;',
                    'default'      => 5,
                    'min'          => 1,
                    'max'          => 10,
                ),
                'comments_heading' => array(
                    'label'           => esc_html__('Comments', 'bloglog'),
                    'type'            => 'heading',
                ),
                'comments_post_title' => array(
                    'label'         => esc_html__('Comments Posts Title', 'bloglog'),
                    'type'          => 'text',
                    'default'          => esc_html__('Comments', 'bloglog'),
                ),
                'comments_number' => array(
                    'label'          => esc_html__('No. of Comments:', 'bloglog'),
                    'type'           => 'number',
                    'css'            => 'max-width:60px;',
                    'default'        => 5,
                    'min'            => 1,
                    'max'            => 10,
                ),
            );

            parent::__construct( 'bloglog-tabbed', esc_html__( 'MP: Tab Posts Widget', 'bloglog' ), $opts, array(), $fields );

        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget( $args, $instance ) {

            $params = $this->get_params( $instance );
            $tab_id = 'tabbed-'.$this->number;

            echo $args['before_widget'];
            ?>
            <div class="tabbed-container">

                <div class="tab-head">
                     <ul class="twp-nav-tabs clear">

                        <li tab-data="tab-popular" class="tab tab-popular active">
                            <a href="javascript:void(0)">

                                <span class="fire-icon tab-icon">
                                    <?php bloglog_the_theme_svg('popular'); ?>
                                </span>

                                <?php echo esc_html( $params['popular_post_title'] ); ?>

                            </a>
                        </li>

                        <li tab-data="tab-recent" class="tab tab-recent">
                            <a href="javascript:void(0)">

                                <span class="flash-icon tab-icon">
                                    <?php bloglog_the_theme_svg('flash'); ?>
                                </span>

                                <?php echo esc_html( $params['recent_post_title'] ); ?>

                            </a>
                        </li>

                        <li tab-data="tab-comments" class="tab tab-comments">
                            <a href="javascript:void(0)">

                                <span class="comment-icon tab-icon">
                                    <?php bloglog_the_theme_svg('comment-2'); ?>
                                </span>

                                <?php echo esc_html( $params['comments_post_title'] ); ?>

                            </a>
                        </li>

                    </ul>
                </div>

                <div class="tab-content">

                    <div class="tab-pane content-tab-popular active">
                        <?php $this->render_news( 'popular', $params );?>
                    </div>

                    <div class="tab-pane content-tab-recent">
                        <?php $this->render_news('recent', $params );?>
                    </div>

                    <div class="tab-pane content-tab-comments">
                        <?php $this->render_comments( $params );?>
                    </div>

                </div>

            </div>
            <?php

            echo $args['after_widget'];

        }

        /**
         * Render news.
         *
         * @since 1.0.0
         *
         * @param array $type Type.
         * @param array $params Parameters.
         * @return void
         */
        function render_news($type, $params) {

            if ( !in_array( $type, array('popular', 'recent') ) ) {
                return;
            }

            switch ($type) {
                case 'popular':

                    $cat_slug = '';
                    if( isset( $params['tab_cat'] ) ){
                        $cat_slug = $params['tab_cat'];
                    }

                    $qargs = array(
                        'posts_per_page' => $params['popular_number'],
                        'no_found_rows'  => true,
                        'orderby'        => 'comment_count',
                        'category_name'  => $cat_slug,
                    );

                    break;

                case 'recent':

                    $cat_slug = '';
                    if( isset( $params['tab_cat'] ) ){
                        $cat_slug = $params['tab_cat'];
                    }

                    $qargs = array(
                        'posts_per_page' => $params['recent_number'],
                        'no_found_rows'  => true,
                        'category_name'  => $cat_slug,
                    );

                    break;

                default:
                    break;
            }

            $tab_posts_query = new WP_Query( $qargs );

            if ( $tab_posts_query->have_posts() ): ?>
                
                <ul class="theme-widget-list recent-widget-list">
                    
                    <?php
                    while ( $tab_posts_query->have_posts() ):
                        $tab_posts_query->the_post(); ?>

                        <li>
                            <article class="article-list">
                                <div class="wrapper-inner wrapper-inner-small">
                                    
                                    <div class="column column-4">
                                        <div class="entry-thumbnail">
                                            
                                            <?php
                                            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
                                            $featured_image = isset( $featured_image[0] ) ? $featured_image[0] : ''; ?>

                                            <a href="<?php the_permalink(); ?>" class="data-bg data-bg-thumbnail" data-background="<?php echo esc_url( $featured_image); ?>"></a>

                                        </div>
                                    </div>

                                    <div class="column column-8">
                                        <div class="article-body">
                                            
                                            <div class="entry-meta">

                                                <?php
                                                bloglog_posted_by();
                                                ?>

                                            </div>

                                            <h3 class="entry-title entry-title-small">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>

                                </div>
                            </article>
                        </li>

                    <?php endwhile;?>

                </ul><!-- .news-list -->

                <?php wp_reset_postdata();

            endif; 

        }

        /**
         * Render comments.
         *
         * @since 1.0.0
         *
         * @param array $params Parameters.
         * @return void
         */
        function render_comments($params) {

            $cat_slug = '';
            $post_array = array();
            if( !empty( $params['tab_cat'] ) ){

                $cat_slug = $params['tab_cat'];

                $qargs = array(
                    'posts_per_page' => 10,
                    'no_found_rows'  => true,
                    'category_name'  => $cat_slug,
                );

                $tab_posts_query = new WP_Query( $qargs );

                if ( $tab_posts_query->have_posts() ){

                    while ( $tab_posts_query->have_posts() ){
                       $tab_posts_query->the_post();
                        $post_array[] = get_the_ID();
                    }
                    wp_reset_postdata();
                }
            }

            $comment_args = array(
                'number'      => $params['comments_number'],
                'status'      => 'approve',
                'post_status' => 'publish',
                'post__in'  => $post_array,
            );

            $comments = get_comments( $comment_args );
            ?>
            <?php if ( !empty( $comments ) ):?>
                <ul class="theme-widget-list comments-tabbed-list">
                    <?php foreach ( $comments as $key => $comment ):?>
                        <li>
                            <div class="wrapper-inner wrapper-inner-small">
                                <div class="column column-4">
                                    <div class="entry-thumbnail">
                                        <?php $comment_author_url = esc_url( get_comment_author_url( $comment ) ); ?>
                                        <?php if ( !empty( $comment_author_url ) ):

                                        $thumb = get_avatar_url( $comment, array('size'=>100) ); ?>

                                            <a href="<?php echo esc_url( $comment_author_url ); ?>" class="data-bg data-bg-thumbnail" data-background="<?php echo esc_url( $thumb ); ?>"></a>
                                            
                                        <?php  else : ?>
                                            <?php echo wp_kses_post( get_avatar( $comment, 130 ) );?>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="column column-8">
                                    <div class="comments-content">
                                        <?php echo wp_kses_post( get_comment_author_link( $comment ) ); ?>
                                    </div>
                                    <h3 class="entry-title entry-title-small">
                                        <a href="<?php echo esc_url( get_comment_link( $comment ) ); ?>">
                                            <?php echo esc_html( get_the_title( $comment->comment_post_ID ) );?>
                                        </a>
                                    </h3>
                                </div>
                            </div>
                        </li>
                    <?php endforeach;?>
                </ul><!-- .comments-list -->
            <?php endif;?>
            <?php
        }

    }
endif;
