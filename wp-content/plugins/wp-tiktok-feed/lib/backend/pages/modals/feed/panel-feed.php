<?php use QUADLAYERS\TIKTOK\Api\Tiktok\User\Load as Api_Tiktok_User; ?>

<div id="tab_panel_feed" class="panel qlttf_options_panel <# if (data.panel != 'tab_panel_feed') { #>hidden<# } #>">
	<div class="options_group">
		<p class="form-field">
			<label><?php esc_html_e( 'Source', 'wp-tiktok-feed' ); ?></label>
			<span>
				<input type="radio" class="media-modal-render-panels" name="source" value="username" <# if(data.source=='username' ) { #>checked="checked"<# } #> />
				<label><?php esc_html_e( 'Username', 'wp-tiktok-feed' ); ?> <span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span></label>
			</span>
			<span class="qlttf-premium-field">
				<input type="radio" class="media-modal-render-panels" name="source" value="trending" <# if(data.source=='trending' ) { #>checked="checked"<# } #> />
				<label><?php esc_html_e( 'Trending', 'wp-tiktok-feed' ); ?></label>
			</span>
			<span class="qlttf-premium-field">
				<input type="radio" class="media-modal-render-panels" name="source" value="hashtag" <# if(data.source=='hashtag' ) { #>checked="checked"<# } #> />
				<label><?php esc_html_e( 'Hashtag', 'wp-tiktok-feed' ); ?></label>
			</span>
		</p>
		<p class="form-field qlttf-premium-field" style="margin-top: -30px;">
			<label></label><span class="description hidden"><small><?php esc_html_e( '(Hashtag & Trending feeds are coming soon for Tiktok Premium.)', 'wp-tiktok-feed' ); ?></small></span>
		</p>
		<# if (data.source!='username' ){ #>
		<p class="form-field qlttf-premium-field-username">
			<span class="notice error" style="margin-left:0; margin-right:0; padding-top: 10px; padding-bottom: 10px; display: flex; justify-content: left; align-items: center;">
			<strong>
				<?php
				echo wp_kses_post(
					sprintf(
						__( 'Unfortunately due to the new API limitations it is not possible to obtain the tag or trending feed videos with the free version. You can get the premium version <a href="%s" target="_blank">here</a>.', 'wp-tiktok-feed' ),
						QLTTF_PURCHASE_URL
					)
				);
				?>
			</strong>
		</span>
		</p>
		<# } #>
	</div>
	<div class="options_group">
		<p class="form-field <# if ( data.source != 'hashtag') {#>hidden<#}#>">
			<label><?php esc_html_e( 'Hashtag', 'wp-tiktok-feed' ); ?></label>
			<input name="hashtag" type="text" <# if ( data.source=='hashtag' ) {#>
				required="required"
				<#}#>
				placeholder="wordpress"
				<# if ( data.hashtag!=='WordPress' ){#>
					value="{{data.hashtag}}" 
				<#}	#>
			<span class="description"><small><?php esc_html_e( 'Please enter TikTok tag', 'wp-tiktok-feed' ); ?></small></span>
		</p>
	</div>
	<# if ( data.source == 'hashtag') { #>
		<div class="options_group">
			<!-- <p class="form-field">
				<label><?php esc_html_e( 'Hashtag ID', 'wp-tiktok-feed' ); ?></label>
				<input name="hashtag_id" type="text" <# if ( data.source=='hashtag_id' ) {#>required="required"<#}#> placeholder="wordpress" value="{{data.hashtag_id}}" />
				<span class="description"><small><?php esc_html_e( 'Please enter the hashtag id', 'wp-tiktok-feed' ); ?></small></span>
			</p> -->
			<!-- <p class="form-field">
				<span class="notice error" style="margin-left:0; margin-right:0; padding-top: 10px; padding-bottom: 10px; display: flex; justify-content: left; align-items: center;">
					<strong>
					<?php
					echo wp_kses_post(
						sprintf(
							__( 'Unfortunately due to the new API limitations the hashtag id is required. You can get it by following this tutorial <a href="%s" target="_blank">here</a>.', 'wp-tiktok-feed' ),
							'https://quadlayers.com/documentation/tiktok-feed/how-to-get-hashtag-id/?utm_source=qlttf_admin'
						)
					);
					?>
					</strong>
				</span>
			</p> -->
		</div>
			<# } #>

			<# if ( data.source == 'username') { #>

			<div class="options_group 
			<?php
			if ( ! count( $accounts ) ) {
				?>
			disabled-feature<?php } ?>"> 
				<p class="form-field">
				<label><?php esc_html_e( 'Account', 'wp-tiktok-feed' ); ?></label>

				<select class="media-modal-render-panels" name="open_id" <# if ( data.open_id=='open_id' ) {#>required="required"<#}#>>
					<?php
					foreach ( $accounts as $account_id => $account ) :
						?>
						<?php
							$api_user     = new Api_Tiktok_User( $account_id );
							$profile_info = $api_user->get_profile_data();
						?>
						<option value="<?php echo esc_attr( $account_id ); ?>" <# if ( data.open_id=='<?php echo $account_id; ?>') {#>selected="selected"<#}#> >
						<?php echo esc_html( $profile_info['display_name'] ); ?>
						</option> 

					<?php endforeach; ?>
			</select>
			<span class="description"><small><?php esc_html_e( 'Please select TikTok account', 'wp-tiktok-feed' ); ?></small></span>
			</p>
		</div>
		<!-- <div class="options_group">
			<p class="form-field <# if ( data.source != 'username') {#>hidden<#}#>">
				<label><?php esc_html_e( 'User', 'wp-tiktok-feed' ); ?></label>
				<input name="username" type="text" <# if ( data.source=='username' ){#>
					required="required"
					<#}	#> 
					placeholder="username"
					<# if ( data.username!=='tiktok' ){#>
						value="{{data.username}}" 
					<#}	#>
					/> 
				<span class="description"><small><?php esc_html_e( 'Please enter TikTok username', 'wp-tiktok-feed' ); ?></small></span>
			</p>
		</div> -->
	<# } #>
	<div class="options_group">
		<div class="form-field">
			<ul class="list-images">
			<li class="media-modal-image <# if ( data.layout == 'masonry') {#>active<#}#>">
				<span>
				<input type="radio" name="layout" value="masonry" <# if (data.layout=='masonry' ){ #>checked<# } #> />
					<label for="insta_layout-masonry"><?php esc_html_e( 'Masonry', 'wp-tiktok-feed' ); ?></label>
					<img src="<?php echo plugins_url( '/assets/backend/img/masonry.png', QLTTF_PLUGIN_FILE ); ?>" />
				</span>
			</li>
			<li class="media-modal-image <# if ( data.layout == 'gallery') {#>active<#}#>">
				<span>
				<input type="radio" name="layout" value="gallery" <# if (data.layout=='gallery' ){ #>checked<# } #> />
					<label for="insta_layout-gallery"><?php esc_html_e( 'Gallery', 'wp-tiktok-feed' ); ?></label>
					<img src="<?php echo plugins_url( '/assets/backend/img/gallery.png', QLTTF_PLUGIN_FILE ); ?>" />
				</span>
			</li>
			<li class="media-modal-image qlttf-premium-field <# if ( data.layout == 'carousel') {#>active<# } #>">
				<span>
					<input type="radio" name="layout" value="carousel" <# if (data.layout== 'carousel'){ #>checked<# } #> />
					<label for="insta_layout-carousel"><?php esc_html_e( 'Carousel', 'wp-tiktok-feed' ); ?></label>
					<span style="text-align:center;width:100%;" class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
					<img src="<?php echo plugins_url( '/assets/backend/img/carousel.png', QLTTF_PLUGIN_FILE ); ?>"/>
				</span>
			</li>
			<li class="media-modal-image qlttf-premium-field <# if ( data.layout == 'carousel-vertical') {#>active<# } #>">
				<span>
				<input type="radio" name="layout" value="carousel-vertical" <# if (data.layout== 'carousel-vertical'){ #>checked<# } #> />
					<label for="insta_layout-carousel-vertical"><?php esc_html_e( 'Carousel Vertical', 'wp-tiktok-feed' ); ?></label>
					<span style="text-align:center;width:100%;" class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
					<img src="<?php echo plugins_url( '/assets/backend/img/carousel-vertical.png', QLTTF_PLUGIN_FILE ); ?>"/>
				</span>
			</li>
			<li class="media-modal-image qlttf-premium-field <# if ( data.layout == 'highlight') {#>active<#}#>">
				<span>
				<input type="radio" name="layout" value="highlight" <# if (data.layout=='highlight' ){ #>checked<# } #> />
					<label for="insta_layout-highlight"><?php esc_html_e( 'Highlight', 'wp-tiktok-feed' ); ?></label>
					<img src="<?php echo plugins_url( '/assets/backend/img/highlight.png', QLTTF_PLUGIN_FILE ); ?>" />
				</span>
			</li>
			<li class="media-modal-image qlttf-premium-field <# if ( data.layout == 'highlight-square') {#>active<#}#>">
				<span>
				<input type="radio" name="layout" value="highlight-square" <# if (data.layout=='highlight-square' ){ #>checked<# } #> />
					<label for="insta_layout-highlight-square"><?php esc_html_e( 'Highlight Square', 'wp-tiktok-feed' ); ?></label>
					<img src="<?php echo plugins_url( '/assets/backend/img/highlight-square.png', QLTTF_PLUGIN_FILE ); ?>" />
				</span>
			</li>
			</ul>
		</div>
	</div>
	<div class="options_group">
		<p class="form-field">
			<label><?php esc_html_e( 'Limit', 'wp-tiktok-feed' ); ?></label>
			<input name="limit" type="number" min="1" 	
			<# if( data.source=='username' ){ #>
				max="20"
				<#
				if(data.limit > 20 || !data.limit) { #>
					value = 20
				<# } else { #>
					value="{{data.limit}}" 
				<# } 
			} else { #>
				max="8"
				<#
				if(data.limit > 8 || !data.limit) { #>
					value = 8
				<# } else { #>
					value="{{data.limit}}" 
				<# } 
			} #>
			/>
			<span class="description"><small><?php esc_html_e( 'Number of videos to display', 'wp-tiktok-feed' ); ?></small></span>
		</p>
		<# if (data.source!='username' ){ #>
		<p class="form-field">
			<span class="notice error" style="margin-left:0; margin-right:0; padding-top: 10px; padding-bottom: 10px; display: flex; justify-content: left; align-items: center;">
			<strong>
				<?php
				echo wp_kses_post(
					sprintf(
						__( 'Unfortunately due to the new API limitations it is not possible to obtain more than eight videos in tag or trending feed videos. You can get more info <a href="%s" target="_blank">here</a>.', 'wp-tiktok-feed' ),
						QLTTF_DOCUMENTATION_API_URL
					)
				);
				?>
			</strong>
		</span>
		</p>
		<# } #>
	</div>
	<div class="options_group <# if(!_.contains(['gallery', 'masonry', 'highlight','highlight-square'], data.layout)) { #>hidden<# } #>">
		<p class="form-field">
			<label><?php esc_html_e( 'Columns', 'wp-tiktok-feed' ); ?></label>
			<input name="columns" type="number" min="1" max="20" value="{{data.columns}}" />
			<span class="description"><small><?php esc_html_e( 'Number of videos in a row', 'wp-tiktok-feed' ); ?></small></span>
		</p>
	</div>
	<div class="options_group <# if(!_.contains(['highlight','highlight-square'], data.layout)) { #>hidden<# } #>">
		<p class="form-field">
			<label><?php esc_html_e( 'Highlight by tag', 'wp-tiktok-feed' ); ?></label>
			<textarea name="highlight[tag]" placeholder="tag1, tag2, tag3">{{data.highlight.tag}}</textarea>
			<span class="description"><small><?php esc_html_e( 'Highlight feeds items with this tags', 'wp-tiktok-feed' ); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
		</p>
		<p class="form-field">
			<label><?php esc_html_e( 'Highlight by id', 'wp-tiktok-feed' ); ?></label>
			<textarea name="highlight[id]" placeholder="101010110101010">{{data.highlight.id}}</textarea>
			<span class="description"><small><?php esc_html_e( 'Highlight feeds items with this ids', 'wp-tiktok-feed' ); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
		</p>
		<p class="form-field">
			<label><?php esc_html_e( 'Highlight by position', 'wp-tiktok-feed' ); ?></label>
			<textarea name="highlight[position]" placeholder="1, 5, 7">{{data.highlight.position}}</textarea>
			<span class="description"><small><?php esc_html_e( 'Highlight feeds items in this positions', 'wp-tiktok-feed' ); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
		</p>
	</div>
</div>
