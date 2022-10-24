<div id="tab_panel_feed_box" class="panel qlttf_options_panel <# if (data.panel != 'tab_panel_feed_box') { #>hidden<# } #> ">

	<div class="options_group qlttf-premium-field">
		<p class="form-field">
			<label><?php esc_html_e('Box', 'wp-tiktok-feed'); ?></label>
			<input class="media-modal-render-panels" name="box[display]" type="checkbox" value="true" <# if (data.box.display){ #>checked<# } #> />
				<span class="description"><small><?php esc_html_e('Display the TikTok Feed inside a customizable box', 'wp-tiktok-feed'); ?></small></span>
				<span class="description hidden"><small><?php esc_html_e('(This is a premium feature)', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>

	<div class="options_group qlttf-premium-field <# if (!data.box.display){ #>disabled-field<# } #>">
		<p class="form-field">
			<label><?php esc_html_e('Box padding', 'wp-tiktok-feed'); ?></label>
			<input name="box[padding]" type="number" value="{{data.box.padding}}" min="0" />
			<span class="description"><small><?php esc_html_e('Add padding to the TikTok Feed', 'wp-tiktok-feed'); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e('(This is a premium feature)', 'wp-tiktok-feed'); ?></small></span>
		</p>

		<p class="form-field">
			<label><?php esc_html_e('Box radius', 'wp-tiktok-feed'); ?></label>
			<input name="box[radius]" type="number" value="{{data.box.radius}}" min="0" />
			<span class="description"><small><?php esc_html_e('Add radius to the TikTok Feed', 'wp-tiktok-feed'); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e('(This is a premium feature)', 'wp-tiktok-feed'); ?></small></span>
		</p>

		<p class="form-field">
			<label><?php esc_html_e('Box background', 'wp-tiktok-feed'); ?></label>
			<input data-alpha="true" name="box[background]" type="text" placeholder="#c32a67" value="{{data.box.background}}" class="color-picker" />
			<span class="description"><small><?php esc_html_e('Color which is displayed on box background', 'wp-tiktok-feed'); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e('(This is a premium feature)', 'wp-tiktok-feed'); ?></small></span>

		<p class="form-field">
			<label><?php esc_html_e('Box text color', 'wp-tiktok-feed'); ?></label>
			<input data-alpha="true" name="box[text_color]" type="text" placeholder="#000000" value="{{data.box.text_color}}" class="color-picker" />
			<span class="description"><small><?php esc_html_e('Color which is displayed on box text', 'wp-tiktok-feed'); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e('(This is a premium feature)', 'wp-tiktok-feed'); ?></small></span>
		</p>
		</p>
	</div>

	<div class="options_group qlttf-premium-field <# if (!data.box.display){ #>disabled-field<# } #>">
		<p class="form-field">
			<label><?php esc_html_e('Profile', 'wp-tiktok-feed'); ?></label>
			<input class="media-modal-render-panels" name="box[profile]" type="checkbox" value="true" <# if (data.box.profile){ #>checked<# } #> />
				<span class="description"><small><?php esc_html_e('Display user profile or tag info', 'wp-tiktok-feed'); ?> </small></span>
				<span class="description hidden"><small><?php esc_html_e('(This is a premium feature)', 'wp-tiktok-feed'); ?></small></span>
		</p>
		<p class="form-field <# if (!data.box.profile){ #>disabled-field<# } #>">
			<label><?php esc_html_e('Profile description', 'wp-tiktok-feed'); ?></label>
			<input name="box[desc]" type="text" placeholder="TikTok" value="{{data.box.desc}}" />
			<span class="description"><small><?php esc_html_e('Box description here', 'wp-tiktok-feed'); ?></small></span>
			<span class="description hidden"><small><?php esc_html_e('(This is a premium feature)', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>

</div>