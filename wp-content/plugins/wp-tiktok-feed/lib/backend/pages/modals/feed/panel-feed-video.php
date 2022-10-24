<div id="tab_panel_feed_video" class="panel qlttf_options_panel <# if (data.panel != 'tab_panel_feed_video') { #>hidden<# } #>">

	<div class="options_group">
		<p class="form-field">
			<label><?php esc_html_e('Video type', 'wp-tiktok-feed'); ?></label>
			<select name="video[covers]">
				<option <# if ( data.video.covers=='default' ) { #>selected="selected"<# } #> value="default"><?php esc_html_e('Default', 'wp-tiktok-feed'); ?></option>
				<option <# if ( data.video.covers=='origin' ) { #>selected="selected"<# } #> value="origin"><?php esc_html_e('Origin', 'wp-tiktok-feed'); ?></option>
				<option <# if ( data.video.covers=='dynamic' ) { #>selected="selected"<# } #> value="dynamic"><?php esc_html_e('Dynamic', 'wp-tiktok-feed'); ?></option>
			</select>
		</p>
		<p class="form-field">
			<label><?php esc_html_e('Video lazy load', 'wp-tiktok-feed'); ?></label>
			<input name="lazy" type="checkbox" value="true" <# if (data.lazy){ #>checked<# } #>/>
			<span class="description"><small><?php esc_html_e('Defers feed video lazy', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>

	<div class="options_group">
		<p class="form-field">
			<label><?php esc_html_e('Video spacing', 'wp-tiktok-feed'); ?></label>
			<input name="video[spacing]" min="0" type="number" value="{{data.video.spacing}}" />
			<span class="description"><small><?php esc_html_e('Add blank space between video', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>

	<div class="options_group">
		<p class="form-field">
			<label><?php esc_html_e('Video radius', 'wp-tiktok-feed'); ?></label>
			<input name="video[radius]" type="number" value="{{data.video.radius}}" min="0" />
			<span class="description"><small><?php esc_html_e('Add radius to the TikTok video', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>

	<div class="options_group">
		<p class="form-field">
			<label><?php esc_html_e('Video mask', 'wp-tiktok-feed'); ?></label>
			<input class="media-modal-render-panels" name="mask[display]" type="checkbox" value="true" <# if (data.mask.display){ #>checked<# } #>/>
			<span class="description"><small><?php esc_html_e('Video mouseover effect', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>

	<div class="options_group <# if (!data.mask.display){ #>disabled-field<# } #>">
		<p class="form-field">
			<label><?php esc_html_e('Video mask color', 'wp-tiktok-feed'); ?></label>
			<input data-alpha="true" name="mask[background]" type="text" placeholder="#007aff" value="{{data.mask.background}}" class="color-picker" />
			<span class="description"><small><?php esc_html_e('Color which is displayed when displayed over video', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>

	<div class="options_group <# if (!data.mask.display){ #>disabled-field<# } #>">
		<p class="form-field">
			<label><?php esc_html_e('Video mask likes', 'wp-tiktok-feed'); ?></label>
			<input name="mask[digg_count]" type="checkbox" value="true" <# if (data.mask.digg_count ){ #>checked<# } #>/>
			<span class="description"><small><?php esc_html_e('Display likes count of video', 'wp-tiktok-feed'); ?></small></span>
		</p>

		<p class="form-field">
			<label><?php esc_html_e('Video mask comments', 'wp-tiktok-feed'); ?></label>
			<input name="mask[comment_count]" type="checkbox" value="true" <# if (data.mask.comment_count ){ #>checked<# } #>/>
			<span class="description"><small><?php esc_html_e('Display comments count of video', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>

</div>