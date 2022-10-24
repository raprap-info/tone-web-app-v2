<?php
/**
* Sidebar Metabox.
*
* @package Bloglog
*/
 
add_action( 'add_meta_boxes', 'bloglog_metabox' );

if( ! function_exists( 'bloglog_metabox' ) ):


    function  bloglog_metabox() {
        
        add_meta_box(
            'bloglog-custom-metabox',
            esc_html__( 'Layout Settings', 'bloglog' ),
            'bloglog_post_metafield_callback',
            'post', 
            'normal', 
            'high'
        );
        add_meta_box(
            'bloglog-custom-metabox',
            esc_html__( 'Layout Settings', 'bloglog' ),
            'bloglog_post_metafield_callback',
            'page',
            'normal', 
            'high'
        ); 
    }

endif;

$bloglog_post_sidebar_fields = array(
    'global-sidebar' => array(
                    'id'        => 'post-global-sidebar',
                    'value' => 'global-sidebar',
                    'label' => esc_html__( 'Global sidebar', 'bloglog' ),
                ),
    'right-sidebar' => array(
                    'id'        => 'post-left-sidebar',
                    'value' => 'right-sidebar',
                    'label' => esc_html__( 'Right sidebar', 'bloglog' ),
                ),
    'left-sidebar' => array(
                    'id'        => 'post-right-sidebar',
                    'value'     => 'left-sidebar',
                    'label'     => esc_html__( 'Left sidebar', 'bloglog' ),
                ),
    'no-sidebar' => array(
                    'id'        => 'post-no-sidebar',
                    'value'     => 'no-sidebar',
                    'label'     => esc_html__( 'No sidebar', 'bloglog' ),
                ),
);

/**
 * Callback function for post option.
*/
if( ! function_exists( 'bloglog_post_metafield_callback' ) ):
    
	function bloglog_post_metafield_callback() {
		global $post, $bloglog_post_sidebar_fields;
        $post_type = get_post_type($post->ID);
		wp_nonce_field( basename( __FILE__ ), 'bloglog_post_meta_nonce' ); ?>
        
        <div class="metabox-main-block">

            <div class="metabox-navbar">
                <ul>

                    <li>
                        <a id="metabox-navbar-general" class="metabox-navbar-active" href="javascript:void(0)">

                            <?php esc_html_e('General Settings', 'bloglog'); ?>

                        </a>
                    </li>

                    <?php if( $post_type == 'post' ): ?>
                        <li>
                            <a id="metabox-navbar-appearance" href="javascript:void(0)">

                                <?php esc_html_e('Appearance Settings', 'bloglog'); ?>

                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if( $post_type == 'post' && class_exists('Booster_Extension_Class') ): ?>
                        <li>
                            <a id="twp-tab-booster" href="javascript:void(0)">

                                <?php esc_html_e('Booster Extension Settings', 'bloglog'); ?>

                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

            <div class="twp-tab-content">

                <div id="metabox-navbar-general-content" class="metabox-content-wrap metabox-content-wrap-active">

                    <div class="metabox-opt-panel">

                        <h3 class="meta-opt-title"><?php esc_html_e('Sidebar Layout','bloglog'); ?></h3>

                        <div class="metabox-opt-wrap metabox-opt-wrap-alt">

                            <?php
                            $bloglog_post_sidebar = esc_html( get_post_meta( $post->ID, 'bloglog_post_sidebar_option', true ) ); 
                            if( $bloglog_post_sidebar == '' ){ $bloglog_post_sidebar = 'global-sidebar'; }

                            foreach ( $bloglog_post_sidebar_fields as $bloglog_post_sidebar_field) { ?>

                                <label class="description">

                                    <input type="radio" name="bloglog_post_sidebar_option" value="<?php echo esc_attr( $bloglog_post_sidebar_field['value'] ); ?>" <?php if( $bloglog_post_sidebar_field['value'] == $bloglog_post_sidebar ){ echo "checked='checked'";} if( empty( $bloglog_post_sidebar ) && $bloglog_post_sidebar_field['value']=='right-sidebar' ){ echo "checked='checked'"; } ?>/>&nbsp;<?php echo esc_html( $bloglog_post_sidebar_field['label'] ); ?>

                                </label>

                            <?php } ?>

                        </div>

                    </div>

                    <div class="metabox-opt-panel">

                        <h3 class="meta-opt-title"><?php esc_html_e('Navigation Setting','bloglog'); ?></h3>

                        <?php $twp_disable_ajax_load_next_post = esc_attr( get_post_meta($post->ID, 'twp_disable_ajax_load_next_post', true) ); ?>
                        <div class="metabox-opt-wrap metabox-opt-wrap-alt">

                            <label><b><?php esc_html_e( 'Navigation Type','bloglog' ); ?></b></label>

                            <select name="twp_disable_ajax_load_next_post">

                                <option <?php if( $twp_disable_ajax_load_next_post == '' || $twp_disable_ajax_load_next_post == 'global-layout' ){ echo 'selected'; } ?> value="global-layout"><?php esc_html_e('Global Layout','bloglog'); ?></option>
                                <option <?php if( $twp_disable_ajax_load_next_post == 'no-navigation' ){ echo 'selected'; } ?> value="no-navigation"><?php esc_html_e('Disable Navigation','bloglog'); ?></option>
                                <option <?php if( $twp_disable_ajax_load_next_post == 'norma-navigation' ){ echo 'selected'; } ?> value="norma-navigation"><?php esc_html_e('Next Previous Navigation','bloglog'); ?></option>
                                <option <?php if( $twp_disable_ajax_load_next_post == 'ajax-next-post-load' ){ echo 'selected'; } ?> value="ajax-next-post-load"><?php esc_html_e('Ajax Load Next 3 Posts Contents','bloglog'); ?></option>

                            </select>

                        </div>
                    </div>

                </div>

                <?php if( $post_type == 'post' ): ?>

                    <div id="metabox-navbar-appearance-content" class="metabox-content-wrap">

                        <div class="metabox-opt-panel">

                            <h3 class="meta-opt-title"><?php esc_html_e('Feature Image Setting','bloglog'); ?></h3>

                                <?php
                                $bloglog_ed_feature_image = esc_html( get_post_meta( $post->ID, 'bloglog_ed_feature_image', true ) ); ?>

                            <div class="metabox-opt-wrap twp-checkbox-wrap">

                                <input type="checkbox" id="bloglog-ed-feature-image" name="bloglog_ed_feature_image" value="1" <?php if( $bloglog_ed_feature_image ){ echo "checked='checked'";} ?>/>
                                <label for="bloglog-ed-feature-image"><?php esc_html_e( 'Disable Feature Image','bloglog' ); ?></label>

                            </div>

                        </div>

                        <div class="metabox-opt-panel">

                            <h3 class="meta-opt-title"><?php esc_html_e('Video Aspect Ration Setting','bloglog'); ?></h3>

                            <?php $twp_aspect_ratio = esc_attr( get_post_meta($post->ID, 'twp_aspect_ratio', true) ); ?>
                            <div class="metabox-opt-wrap metabox-opt-wrap-alt">

                                <label><b><?php esc_html_e( 'Video Aspect Ratio','bloglog' ); ?></b></label>

                                <select name="twp_aspect_ratio">

                                    <option <?php if( $twp_aspect_ratio == '' || $twp_aspect_ratio == 'default' ){ echo 'selected'; } ?> value="default"><?php esc_html_e('Default','bloglog'); ?></option>

                                    <option <?php if( $twp_aspect_ratio == 'square' ){ echo 'selected'; } ?> value="square"><?php esc_html_e('Square','bloglog'); ?></option>

                                    <option <?php if( $twp_aspect_ratio == 'portrait' ){ echo 'selected'; } ?> value="portrait"><?php esc_html_e('  Portrait','bloglog'); ?></option>

                                    <option <?php if( $twp_aspect_ratio == 'landscape' ){ echo 'selected'; } ?> value="landscape"><?php esc_html_e('Landscape','bloglog'); ?></option>

                                </select>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>

                <?php if( $post_type == 'post' && class_exists('Booster_Extension_Class') ):

                    
                    $bloglog_ed_post_views = esc_html( get_post_meta( $post->ID, 'bloglog_ed_post_views', true ) );
                    $bloglog_ed_post_read_time = esc_html( get_post_meta( $post->ID, 'bloglog_ed_post_read_time', true ) );
                    $bloglog_ed_post_like_dislike = esc_html( get_post_meta( $post->ID, 'bloglog_ed_post_like_dislike', true ) );
                    $bloglog_ed_post_author_box = esc_html( get_post_meta( $post->ID, 'bloglog_ed_post_author_box', true ) );
                    $bloglog_ed_post_social_share = esc_html( get_post_meta( $post->ID, 'bloglog_ed_post_social_share', true ) );
                    $bloglog_ed_post_reaction = esc_html( get_post_meta( $post->ID, 'bloglog_ed_post_reaction', true ) );
                    $bloglog_ed_post_rating = esc_html( get_post_meta( $post->ID, 'bloglog_ed_post_rating', true ) );
                    ?>

                    <div id="twp-tab-booster-content" class="metabox-content-wrap">

                        <div class="metabox-opt-panel">

                            <h3 class="meta-opt-title"><?php esc_html_e('Booster Extension Plugin Content','bloglog'); ?></h3>

                            <div class="metabox-opt-wrap twp-checkbox-wrap">

                                <input type="checkbox" id="bloglog-ed-post-views" name="bloglog_ed_post_views" value="1" <?php if( $bloglog_ed_post_views ){ echo "checked='checked'";} ?>/>
                                <label for="bloglog-ed-post-views"><?php esc_html_e( 'Disable Post Views','bloglog' ); ?></label>

                            </div>

                            <div class="metabox-opt-wrap twp-checkbox-wrap">

                                <input type="checkbox" id="bloglog-ed-post-read-time" name="bloglog_ed_post_read_time" value="1" <?php if( $bloglog_ed_post_read_time ){ echo "checked='checked'";} ?>/>
                                <label for="bloglog-ed-post-read-time"><?php esc_html_e( 'Disable Post Read Time','bloglog' ); ?></label>

                            </div>

                            <div class="metabox-opt-wrap twp-checkbox-wrap">

                                <input type="checkbox" id="bloglog-ed-post-like-dislike" name="bloglog_ed_post_like_dislike" value="1" <?php if( $bloglog_ed_post_like_dislike ){ echo "checked='checked'";} ?>/>
                                <label for="bloglog-ed-post-like-dislike"><?php esc_html_e( 'Disable Post Like Dislike','bloglog' ); ?></label>

                            </div>

                            <div class="metabox-opt-wrap twp-checkbox-wrap">

                                <input type="checkbox" id="bloglog-ed-post-author-box" name="bloglog_ed_post_author_box" value="1" <?php if( $bloglog_ed_post_author_box ){ echo "checked='checked'";} ?>/>
                                <label for="bloglog-ed-post-author-box"><?php esc_html_e( 'Disable Post Author Box','bloglog' ); ?></label>

                            </div>

                            <div class="metabox-opt-wrap twp-checkbox-wrap">

                                <input type="checkbox" id="bloglog-ed-post-social-share" name="bloglog_ed_post_social_share" value="1" <?php if( $bloglog_ed_post_social_share ){ echo "checked='checked'";} ?>/>
                                <label for="bloglog-ed-post-social-share"><?php esc_html_e( 'Disable Post Social Share','bloglog' ); ?></label>

                            </div>

                            <div class="metabox-opt-wrap twp-checkbox-wrap">

                                <input type="checkbox" id="bloglog-ed-post-reaction" name="bloglog_ed_post_reaction" value="1" <?php if( $bloglog_ed_post_reaction ){ echo "checked='checked'";} ?>/>
                                <label for="bloglog-ed-post-reaction"><?php esc_html_e( 'Disable Post Reaction','bloglog' ); ?></label>

                            </div>

                            <div class="metabox-opt-wrap twp-checkbox-wrap">

                                <input type="checkbox" id="bloglog-ed-post-rating" name="bloglog_ed_post_rating" value="1" <?php if( $bloglog_ed_post_rating ){ echo "checked='checked'";} ?>/>
                                <label for="bloglog-ed-post-rating"><?php esc_html_e( 'Disable Post Rating','bloglog' ); ?></label>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>
                
            </div>

        </div>  
            
    <?php }
endif;

// Save metabox value.
add_action( 'save_post', 'bloglog_save_post_meta' );

if( ! function_exists( 'bloglog_save_post_meta' ) ):

    function bloglog_save_post_meta( $post_id ) {

        global $post, $bloglog_post_sidebar_fields;

        if( !isset( $_POST[ 'bloglog_post_meta_nonce' ] ) || !wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bloglog_post_meta_nonce'] ) ), basename( __FILE__ ) ) ){

            return;

        }

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){

            return;

        }
            
        if( isset(  $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {  

            if ( !current_user_can( 'edit_page', $post_id ) ){  

                return $post_id;

            }

        }elseif( !current_user_can( 'edit_post', $post_id ) ) {

            return $post_id;

        }

        foreach ( $bloglog_post_sidebar_fields as $bloglog_post_sidebar_field ) {  
            
            $old = esc_attr( get_post_meta( $post_id, 'bloglog_post_sidebar_option', true ) ); 
            $new = sanitize_text_field( wp_unslash( $_POST['bloglog_post_sidebar_option'] ) );

            if ( $new && $new != $old ){

                update_post_meta ( $post_id, 'bloglog_post_sidebar_option', $new );

            }elseif( '' == $new && $old ) {

                delete_post_meta( $post_id,'bloglog_post_sidebar_option', $old );

            }
            
        }

        $twp_disable_ajax_load_next_post_old = esc_attr( get_post_meta( $post_id, 'twp_disable_ajax_load_next_post', true ) ); 

        $twp_disable_ajax_load_next_post_new = '';

        if( isset( $_POST['twp_disable_ajax_load_next_post'] ) ){
            $twp_disable_ajax_load_next_post_new = bloglog_sanitize_meta_pagination( wp_unslash( $_POST['twp_disable_ajax_load_next_post'] ) );
        }

        if( $twp_disable_ajax_load_next_post_new && $twp_disable_ajax_load_next_post_new != $twp_disable_ajax_load_next_post_old ){

            update_post_meta ( $post_id, 'twp_disable_ajax_load_next_post', $twp_disable_ajax_load_next_post_new );

        }elseif( '' == $twp_disable_ajax_load_next_post_new && $twp_disable_ajax_load_next_post_old ) {

            delete_post_meta( $post_id,'twp_disable_ajax_load_next_post', $twp_disable_ajax_load_next_post_old );

        }

        $bloglog_ed_feature_image_old = absint( get_post_meta( $post_id, 'bloglog_ed_feature_image', true ) );

        $bloglog_ed_feature_image_new = '';
        if( isset( $_POST['bloglog_ed_feature_image'] ) ){
            $bloglog_ed_feature_image_new = absint( wp_unslash( $_POST['bloglog_ed_feature_image'] ) );
        }

        if ( $bloglog_ed_feature_image_new && $bloglog_ed_feature_image_new != $bloglog_ed_feature_image_old ){

            update_post_meta ( $post_id, 'bloglog_ed_feature_image', $bloglog_ed_feature_image_new );

        }elseif( '' == $bloglog_ed_feature_image_new && $bloglog_ed_feature_image_old ) {

            delete_post_meta( $post_id,'bloglog_ed_feature_image', $bloglog_ed_feature_image_old );

        }

        $bloglog_ed_post_views_old = absint( get_post_meta( $post_id, 'bloglog_ed_post_views', true ) );

        $bloglog_ed_post_views_new = '';
        if( isset( $_POST['bloglog_ed_post_views'] ) ){

            $bloglog_ed_post_views_new = absint( wp_unslash( $_POST['bloglog_ed_post_views'] ) );

        }

        if( $bloglog_ed_post_views_new && $bloglog_ed_post_views_new != $bloglog_ed_post_views_old ){

            update_post_meta ( $post_id, 'bloglog_ed_post_views', $bloglog_ed_post_views_new );

        }elseif( '' == $bloglog_ed_post_views_new && $bloglog_ed_post_views_old ) {

            delete_post_meta( $post_id,'bloglog_ed_post_views', $bloglog_ed_post_views_old );

        }

        $bloglog_ed_post_read_time_old = absint( get_post_meta( $post_id, 'bloglog_ed_post_read_time', true ) );

        $bloglog_ed_post_read_time_new = '';
        if( isset( $_POST['bloglog_ed_post_read_time'] ) ){

            $bloglog_ed_post_read_time_new = absint( wp_unslash( $_POST['bloglog_ed_post_read_time'] ) );

        }

        if( $bloglog_ed_post_read_time_new && $bloglog_ed_post_read_time_new != $bloglog_ed_post_read_time_old ){

            update_post_meta ( $post_id, 'bloglog_ed_post_read_time', $bloglog_ed_post_read_time_new );

        }elseif( '' == $bloglog_ed_post_read_time_new && $bloglog_ed_post_read_time_old ) {

            delete_post_meta( $post_id,'bloglog_ed_post_read_time', $bloglog_ed_post_read_time_old );

        }

        $bloglog_ed_post_like_dislike_old = absint( get_post_meta( $post_id, 'bloglog_ed_post_like_dislike', true ) );

        $bloglog_ed_post_like_dislike_new = '';
        if( isset( $_POST['bloglog_ed_post_like_dislike'] ) ){

            $bloglog_ed_post_like_dislike_new = absint( wp_unslash( $_POST['bloglog_ed_post_like_dislike'] ) );

        }

        if( $bloglog_ed_post_like_dislike_new && $bloglog_ed_post_like_dislike_new != $bloglog_ed_post_like_dislike_old ){

            update_post_meta ( $post_id, 'bloglog_ed_post_like_dislike', $bloglog_ed_post_like_dislike_new );

        }elseif( '' == $bloglog_ed_post_like_dislike_new && $bloglog_ed_post_like_dislike_old ) {

            delete_post_meta( $post_id,'bloglog_ed_post_like_dislike', $bloglog_ed_post_like_dislike_old );

        }

        $bloglog_ed_post_author_box_old = absint( get_post_meta( $post_id, 'bloglog_ed_post_author_box', true ) );

        $bloglog_ed_post_author_box_new = '';
        if( isset( $_POST['bloglog_ed_post_like_dislike'] ) ){

            $bloglog_ed_post_author_box_new = absint( wp_unslash( $_POST['bloglog_ed_post_like_dislike'] ) );

        }

        if( $bloglog_ed_post_author_box_new && $bloglog_ed_post_author_box_new != $bloglog_ed_post_author_box_old ){

            update_post_meta ( $post_id, 'bloglog_ed_post_author_box', $bloglog_ed_post_author_box_new );

        }elseif( '' == $bloglog_ed_post_author_box_new && $bloglog_ed_post_author_box_old ) {

            delete_post_meta( $post_id,'bloglog_ed_post_author_box', $bloglog_ed_post_author_box_old );

        }

        $bloglog_ed_post_social_share_old = absint( get_post_meta( $post_id, 'bloglog_ed_post_social_share', true ) );

        $bloglog_ed_post_social_share_new = '';
        if( isset( $_POST['bloglog_ed_post_social_share'] ) ){

            $bloglog_ed_post_social_share_new = absint( wp_unslash( $_POST['bloglog_ed_post_social_share'] ) );

        }

        if( $bloglog_ed_post_social_share_new && $bloglog_ed_post_social_share_new != $bloglog_ed_post_social_share_old ){

            update_post_meta ( $post_id, 'bloglog_ed_post_social_share', $bloglog_ed_post_social_share_new );

        }elseif( '' == $bloglog_ed_post_social_share_new && $bloglog_ed_post_social_share_old ) {

            delete_post_meta( $post_id,'bloglog_ed_post_social_share', $bloglog_ed_post_social_share_old );

        }

        $bloglog_ed_post_reaction_old = absint( get_post_meta( $post_id, 'bloglog_ed_post_reaction', true ) );

        $bloglog_ed_post_reaction_new = '';
        if( isset( $_POST['bloglog_ed_post_reaction'] ) ){

            $bloglog_ed_post_reaction_new = absint( wp_unslash( $_POST['bloglog_ed_post_reaction'] ) );

        }

        if( $bloglog_ed_post_reaction_new && $bloglog_ed_post_reaction_new != $bloglog_ed_post_reaction_old ){

            update_post_meta ( $post_id, 'bloglog_ed_post_reaction', $bloglog_ed_post_reaction_new );

        }elseif( '' == $bloglog_ed_post_reaction_new && $bloglog_ed_post_reaction_old ) {

            delete_post_meta( $post_id,'bloglog_ed_post_reaction', $bloglog_ed_post_reaction_old );

        }

        $bloglog_ed_post_rating_old = absint( get_post_meta( $post_id, 'bloglog_ed_post_rating', true ) );

        $bloglog_ed_post_rating_new = '';
        if( isset( $_POST['bloglog_ed_post_rating'] ) ){

            $bloglog_ed_post_rating_new = absint( wp_unslash( $_POST['bloglog_ed_post_rating'] ) );

        }

        if ( $bloglog_ed_post_rating_new && $bloglog_ed_post_rating_new != $bloglog_ed_post_rating_old ){

            update_post_meta ( $post_id, 'bloglog_ed_post_rating', $bloglog_ed_post_rating_new );

        }elseif( '' == $bloglog_ed_post_rating_new && $bloglog_ed_post_rating_old ) {

            delete_post_meta( $post_id,'bloglog_ed_post_rating', $bloglog_ed_post_rating_old );

        }

        $twp_aspect_ratio_old = esc_attr( get_post_meta( $post_id, 'twp_aspect_ratio', true ) );

        $twp_aspect_ratio_new = '';
        if( isset( $_POST['twp_aspect_ratio'] ) ){

            $twp_aspect_ratio_new = esc_attr( wp_unslash( $_POST['twp_aspect_ratio'] ) );

        }

        if( $twp_aspect_ratio_new && $twp_aspect_ratio_new != $twp_aspect_ratio_old ){

            update_post_meta ( $post_id, 'twp_aspect_ratio', $twp_aspect_ratio_new );

        }elseif( '' == $twp_aspect_ratio_new && $twp_aspect_ratio_old ) {

            delete_post_meta( $post_id,'twp_aspect_ratio', $twp_aspect_ratio_old );

        }


    }

endif;   