<?php
/**
* Related Posts Functions.
*
* @package Bloglog
*/
if( !function_exists('bloglog_related_posts') ):

	// Single Posts Related Posts.
	function bloglog_related_posts(){

        $bloglog_default = bloglog_get_default_theme_options();

        if( ( is_single() && 'post' === get_post_type() || is_404() ) ){

            if( is_404() ){

                $related_posts_query = new WP_Query( array('post_type' => 'post', 'posts_per_page' => 3,'post__not_in' => get_option("sticky_posts") ) );

            }else{

                $current_id = '';
                $article_wrap_class = '';
                global $post;
                $current_id = $post->ID;
                $cats = get_the_category( $post->ID );
                $category = array();

                if( $cats ){

                    foreach( $cats as $cat ){

                        $category[] = $cat->term_id; 

                    }

                }

                $related_posts_query = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 6, 'post__not_in' => array( $post->ID ), 'category__in' => $category ) );

            }

    		$ed_related_post = absint( get_theme_mod( 'ed_related_post',$bloglog_default['ed_related_post'] ) );

    		if( ( $ed_related_post || is_404() ) && $related_posts_query->have_posts() ): ?>

    			<div class="theme-block related-posts-area">

    	        	<?php $related_post_title = esc_html( get_theme_mod( 'related_post_title',$bloglog_default['related_post_title'] ) ); 
    	        	if( $related_post_title ){ ?>
                        <h3 class="theme-block-title">
                            <?php echo esc_html( $related_post_title ); ?>
                        </h3>
    		        <?php } ?>

    	            <div class="related-posts">

                        <?php
                        while( $related_posts_query->have_posts() ):
                            $related_posts_query->the_post();

                            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium' );
                            $featured_image = isset( $featured_image[0] ) ? $featured_image[0] : ''; ?>

                            <div class="related-post-item">
                                <div class="wrapper-inner wrapper-inner-small">

                                    <?php if( has_post_thumbnail() ): ?>

                                        <div class="column column-3 column-lg-3 column-xxs-12">
                                            <div class="entry-thumbnail">
                                                <a href="<?php the_permalink(); ?>" >
                                                    <span class="data-bg data-bg-small" data-background="<?php echo esc_url( $featured_image ); ?>"> </span>
                                                </a>
                                            </div>
                                        </div>
                                        
                                    <?php endif; ?>

                                    <div class="column column-9 column-lg-9 column-xxs-12">
                                        <div class="post-content">

                                            <div class="entry-meta theme-meta-categories">
                                                <?php bloglog_entry_footer( $cats = true, $tags = false, $edits = false ); ?>
                                            </div>
                                            
                                            <header class="entry-header">
                                                <h3 class="entry-title entry-title-small">
                                                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h3>
                                            </header>

                                            <div class="entry-meta">
                                                <?php
                                                bloglog_posted_by();
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        <?php endwhile; ?>

    	            </div>

    			</div>

    		<?php
    		wp_reset_postdata();
    		endif;

        }

	}

endif;
add_action( 'bloglog_navigation_action','bloglog_related_posts',20 );