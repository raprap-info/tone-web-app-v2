<?php
if( !function_exists('bloglog_custom_taxonomy_field') ):

	// Add term page
    function bloglog_custom_taxonomy_field(){

        // this will add the custom meta field to the add new term page
        ?>

        <div class="form-field">
            
            <label><?php esc_html_e('Feature Image', 'bloglog'); ?></label>

            <div class="twp-img-fields-wrap">
                <div class="attachment-media-view">
                    <div class="twp-img-fields-wrap">
                        <div class="twp-attachment-media-view">

                            <div class="twp-attachment-child twp-uploader">

                                <button type="button" class="twp-img-upload-button">
                                    <span class="dashicons dashicons-upload twp-icon twp-icon-large"></span>
                                </button>

                                <input class="upload-id" name="twp-term-featured-image" type="hidden"/>

                            </div>

                            <div class="twp-attachment-child twp-thumbnail-image">

                                <button type="button" class="twp-img-delete-button">
                                    <span class="dashicons dashicons-no-alt twp-icon"></span>
                                </button>

                                <div class="twp-img-container">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="form-field">
                
            <label><?php esc_html_e('Category Color', 'bloglog'); ?></label>
            
            <input type="text" name="bloglog-cat-color" id="bloglog-cat-color" value="">

        </div>
    
    <?php
    }

endif;

add_action('category_add_form_fields', 'bloglog_custom_taxonomy_field', 10, 2);


if( !function_exists('bloglog_taxonomy_edit_meta_field') ):

	// Edit term page
    function bloglog_taxonomy_edit_meta_field($term){

        $twp_term_image = get_term_meta( $term->term_id, 'twp-term-featured-image', true );
        $twp_term_color = get_term_meta( $term->term_id, 'bloglog-cat-color', true ); ?>
        <tr>
            
            <th scope="row" valign="top"><label><?php esc_html_e('Feature Image', 'bloglog'); ?></label></th>

            <td>

                <div class="twp-img-fields-wrap">
                    <div class="attachment-media-view">
                        <div class="twp-img-fields-wrap">
                            <div class="twp-attachment-media-view">

                                <div class="twp-attachment-child twp-uploader">

                                    <button type="button" class="twp-img-upload-button">
                                        <span class="dashicons dashicons-upload twp-icon twp-icon-large"></span>
                                    </button>

                                    <input class="upload-id" name="twp-term-featured-image" type="hidden" value="<?php echo esc_url( $twp_term_image ); ?>"/>

                                </div>

                                <div class="twp-attachment-child twp-thumbnail-image">

                                    <button type="button" class="twp-img-delete-button <?php if( $twp_term_image ) { echo 'twp-img-show'; } ?>">
                                        <span class="dashicons dashicons-no-alt twp-icon"></span>
                                    </button>

                                    <div class="twp-img-container">

                                        <?php if( $twp_term_image ){ ?>

                                            <img src="<?php echo esc_url( $twp_term_image ); ?>" style="width:200px;height:auto;">

                                        <?php } ?>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </td>

        </tr>

        <tr>
            
            <td><label><?php esc_html_e('Category Color', 'bloglog'); ?></label></td>

            <td><input type="text" name="bloglog-cat-color" id="bloglog-cat-color" value="<?php echo esc_attr( $twp_term_color ); ?>"></td>

        </tr>

        <?php
    }

endif;

add_action('category_edit_form_fields', 'bloglog_taxonomy_edit_meta_field', 10, 2);


if( !function_exists('save_taxonomy_color_class_meta') ):

	// Save extra taxonomy fields callback function.
    function save_taxonomy_color_class_meta( $term_id ){

        if( isset( $_POST['twp-term-featured-image'] ) ){

            update_term_meta(
                $term_id,
                'twp-term-featured-image',
                esc_url_raw( wp_unslash( $_POST[ 'twp-term-featured-image' ] ) )
            );

        }

        if( isset( $_POST['bloglog-cat-color'] ) ){

            update_term_meta(
                $term_id,
                'bloglog-cat-color',
                sanitize_hex_color( wp_unslash( $_POST[ 'bloglog-cat-color' ] ) )
            );


        }

    }

endif;

add_action('edited_category', 'save_taxonomy_color_class_meta', 10, 2);
add_action('create_category', 'save_taxonomy_color_class_meta', 10, 2);