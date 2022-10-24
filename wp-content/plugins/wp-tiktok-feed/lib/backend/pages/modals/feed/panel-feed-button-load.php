<div id="tab_panel_feed_button_load" class="panel qlttf_options_panel <# if (data.panel != 'tab_panel_feed_button_load') { #>hidden<# } #>" >

	<div class="options_group qlttf-premium-field">
		<p class="form-field">
			<label><?php esc_html_e('TikTok button', 'wp-tiktok-feed'); ?></label>
			<input class="media-modal-render-panels" name="button_load[display]" type="checkbox" value="true" <# if (data.button_load.display){ #>checked<# } #>/>
			<span class="description"><small><?php esc_html_e('Display the button to load more videos', 'wp-tiktok-feed'); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e('(This is a premium feature)', 'wp-tiktok-feed'); ?></small></span>
		</p>
		<p class="form-field <# if (!data.button_load.display){ #>disabled-field<# } #>">
			<label><?php esc_html_e('TikTok button text', 'wp-tiktok-feed'); ?></label>
			<input name="button_load[text]" type="text" placeholder="TikTok" value="{{data.button_load.text}}"/>
			<span class="description"><small><?php esc_html_e('TikTok button text here', 'wp-tiktok-feed'); ?></small></span>
	</div>

	<div class="options_group qlttf-premium-field <# if (!data.button_load.display){ #>disabled-field<# } #>">
		<p class="form-field">
			<label><?php esc_html_e('TikTok button background', 'wp-tiktok-feed'); ?></label>
			<input class="color-picker" data-alpha="true" name="button_load[background]" type="text" placeholder="#c32a67" value="{{data.button_load.background}}"/>
			<span class="description"><small><?php esc_html_e('Color which is displayed on button background', 'wp-tiktok-feed'); ?></small></span>
		</p>
		<p class="form-field">
			<label><?php esc_html_e('TikTok button hover background', 'wp-tiktok-feed'); ?></label>
			<input class="color-picker" data-alpha="true" name="button_load[background_hover]" type="text" placeholder="#da894a" value="{{data.button_load.background_hover}}"/>
			<span class="description"><small><?php esc_html_e('Color which is displayed when hovered over button', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>

</div>