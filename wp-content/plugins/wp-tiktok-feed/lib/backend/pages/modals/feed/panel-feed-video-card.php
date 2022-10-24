<div id="tab_panel_feed_video_card" class="panel qlttf_options_panel <# if (data.panel != 'tab_panel_feed_video_card') { #>hidden<# } #>">

	<div class="options_group qlttf-premium-field"> 
		<p class="form-field"> 
			<label><?php esc_html_e( 'Videos card', 'wp-tiktok-feed' ); ?></label> 
			<input class="media-modal-render-panels" name="card[display]" type="checkbox" value="true" <# if (data.card.display){ #>checked<# } #> />
			<span class="description"><small><?php esc_html_e( 'Display card gallery', 'wp-tiktok-feed' ); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
		</p>
	</div> 

	<div class="options_group qlttf-premium-field <# if (!data.card.display){ #>disabled-field<# } #>">
		<p class="form-field">
			<label><?php esc_html_e( 'Card radius', 'wp-tiktok-feed' ); ?></label> 
			<input name="card[radius]" type="number" min="0" max="1000" value="{{data.card.radius}}"/>
			<span class="description"><small><?php esc_html_e( 'Add radius to the TikTok Feed', 'wp-tiktok-feed' ); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
		</p> 

		<p class="form-field">
			<label><?php esc_html_e( 'Card font size', 'wp-tiktok-feed' ); ?></label> 
			<input name="card[font_size]" type="number" min="8" max="36" value="{{Math.max(data.card.font_size,8)}}"/>
			<span class="description"><small><?php esc_html_e( 'Add font-size to the TikTok Feed', 'wp-tiktok-feed' ); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
		</p> 

		<p class="form-field">
			<label><?php esc_html_e( 'Card background', 'wp-tiktok-feed' ); ?></label> 
			<input class="color-picker" data-alpha="true" name="card[background]" type="link" placeholder="#007aff" value="{{data.card.background}}"/>
			<span class="description"><small><?php esc_html_e( 'Color which is displayed when over video', 'wp-tiktok-feed' ); ?></small></span> 
			<span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
		</p> 

		<p class="form-field">
			<label><?php esc_html_e( 'Card text', 'wp-tiktok-feed' ); ?></label> 
			<input class="color-picker" data-alpha="true" name="card[text_color]" type="link" placeholder="#000000" value="{{data.card.text_color}}"/>
			<span class="description"><small><?php esc_html_e( 'Color text', 'wp-tiktok-feed' ); ?></small></span> 
			<span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
		</p>

		<p class="form-field">
			<label><?php esc_html_e( 'Card padding', 'wp-tiktok-feed' ); ?></label>
			<input name="card[padding]" type="number" min="0" max="50" value="{{data.card.padding}}"/>
			<span class="description"><small><?php esc_html_e( 'Add blank space between videos', 'wp-tiktok-feed' ); ?></small></span>
		</p> 

		<p class="form-field">
			<label><?php esc_html_e( 'Card info', 'wp-tiktok-feed' ); ?></label> 
			<input name="card[info]" type="checkbox" value="true" <# if (data.card.info){ #>checked<# } #> />
			<span class="description"><small><?php esc_html_e( 'Display likes count of videos', 'wp-tiktok-feed' ); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
		</p> 

		<p class="form-field">
			<label><?php esc_html_e( 'Card comments', 'wp-tiktok-feed' ); ?></label> 
			<input name="card[comments]" type="checkbox" value="true" <# if (data.card.comments){ #>checked<# } #> />
			<span class="description"><small><?php esc_html_e( 'Display comments count of videos', 'wp-tiktok-feed' ); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
		</p> 

		<p class="form-field">
			<label><?php esc_html_e( 'Card text', 'wp-tiktok-feed' ); ?></label> 
			<input name="card[text]" type="checkbox" value="true" <# if (data.card.text){ #>checked<# } #> />
			<span class="description"><small><?php esc_html_e( 'Display text of videos', 'wp-tiktok-feed' ); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e( '(This is a premium feature)', 'wp-tiktok-feed' ); ?></small></span>
		</p> 

		<p class="form-field">
			<label><?php esc_html_e( 'Card length', 'wp-tiktok-feed' ); ?></label> 
			<input name="card[length]" type="number" min="5" max="1000" value="{{Math.max(data.card.length,5)}}"/></small></span>
			<span class="description"><small><?php esc_html_e( 'limit the length of the card text', 'wp-tiktok-feed' ); ?></small></span>
		</p>
	</div> 

</div>
