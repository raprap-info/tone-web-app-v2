<div id="tab_panel_feed_button" class="panel qlttf_options_panel <# if (data.panel != 'tab_panel_feed_button') { #>hidden<# } #>">
	<div class="options_group">
		<p class="form-field">
			<label><?php esc_html_e( 'TikTok button', 'wp-tiktok-feed' ); ?></label>
			<input class="media-modal-render-panels" name="button[display]" type="checkbox" value="true" <# if (data.button.display){ #>checked<# } #>/>
				<span class="description"><small><?php esc_html_e( 'Display the button to open TikTok site link', 'wp-tiktok-feed' ); ?></small></span>
		</p>
		<p class="form-field <# if (!data.button.display){ #>disabled-field<# } #>">
			<label><?php esc_html_e( 'TikTok button text', 'wp-tiktok-feed' ); ?></label>
			<input name="button[text]" type="text" placeholder="TikTok" value="{{data.button.text}}" />
			<span class="description"><small><?php esc_html_e( 'TikTok button text here', 'wp-tiktok-feed' ); ?></small></span>
	</div>

	<div class="options_group">
		<p class="form-field <# if ( data.source != 'username') {#>hidden<#}#>">
			<label><?php esc_html_e( 'Username', 'wp-tiktok-feed' ); ?></label>
			<input name="username" type="text" placeholder="username" value="{{data.username}}" /> 
			<span class="description"><small><?php esc_html_e( 'Please enter TikTok username', 'wp-tiktok-feed' ); ?></small></span>
		</p>
	</div>

	<div class="options_group <# if (!data.button.display){ #>disabled-field<# } #> ">
		<p class="form-field">
			<label><?php esc_html_e( 'TikTok button background', 'wp-tiktok-feed' ); ?></label>
			<input class="color-picker" data-alpha="true" name="button[background]" type="text" placeholder="#c32a67" value="{{data.button.background}}" />
			<span class="description"><small><?php esc_html_e( 'Color which is displayed on button background', 'wp-tiktok-feed' ); ?></small></span>
		</p>
		<p class="form-field">
			<label><?php esc_html_e( 'TikTok button hover background', 'wp-tiktok-feed' ); ?></label>
			<input class="color-picker" data-alpha="true" name="button[background_hover]" type="text" placeholder="#da894a" value="{{data.button.background_hover}}" />
			<span class="description"><small><?php esc_html_e( 'Color which is displayed when hovered over button', 'wp-tiktok-feed' ); ?></small></span>
		</p>
	</div>

</div>
