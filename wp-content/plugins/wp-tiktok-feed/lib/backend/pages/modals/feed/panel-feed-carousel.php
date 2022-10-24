<div id="tab_panel_feed" class="panel qlttf_options_panel qlttf-premium-field <# if (data.panel != 'tab_panel_carousel') { #>hidden<# } #>" > 

	<div class="options_group"> 
		<p class="form-field"> 
			<label><?php esc_html_e('Slides per view', 'wp-tiktok-feed'); ?></label> 
			<input name="carousel[slidespv]" type="number" min="1" max="10" value="{{data.carousel.slidespv}}" />
			<span class="description"><small><?php esc_html_e('Number of videos per slide', 'wp-tiktok-feed'); ?></small> </span>
		</p>
	</div>
	<div class="options_group"> 
		<p class="form-field"> 
			<label><?php esc_html_e('Autoplay', 'wp-tiktok-feed'); ?></label> 
			<input class="media-modal-render-panels" name="carousel[autoplay]" type="checkbox" value="true" <# if (data.carousel.autoplay){ #>checked<# } #> />
			<span class="description"><small><?php esc_html_e('Autoplay carousel items', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>
	<div class="options_group <# if (!data.carousel.autoplay){ #>disabled-field<# } #>"> 
		<p class="form-field"> 
			<label><?php esc_html_e('Autoplay Interval', 'wp-tiktok-feed'); ?></label> 
			<input name="carousel[autoplay_interval]" type="number" min="1000" max="300000" step="100" value="{{data.carousel.autoplay_interval}}" />
			<span class="description"><small><?php esc_html_e('Moves to next picture after specified time interval', 'wp-tiktok-feed'); ?></small></span>
	</div>
	<div class="options_group"> 
		<p class="form-field">
			<label><?php esc_html_e('Navigation', 'wp-tiktok-feed'); ?></label> 
			<input name="carousel[navarrows]" type="checkbox" value="true" <# if (data.carousel.navarrows){ #>checked<# } #> />
			<span class="description"><small><?php esc_html_e('Display navigation arrows', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>
	<div class="options_group"> 
		<p class="form-field">
			<label><?php esc_html_e('Navigation color', 'wp-tiktok-feed'); ?></label> 
			<input class="color-picker" data-alpha="true" name="carousel[navarrows_color]" type="text" placeholder="#c32a67" value="{{data.carousel.navarrows_color}}" />
			<span class="description"><small><?php esc_html_e('Change navigation arrows color', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>
	<div class="options_group"> 
		<p class="form-field"> 
			<label><?php esc_html_e('Pagination', 'wp-tiktok-feed'); ?></label>
			<input name="carousel[pagination]" type="checkbox" value="true" <# if (data.carousel.pagination){ #>checked<# } #> />
			<span class="description"><small><?php esc_html_e('Display pagination dots', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>
	<div class="options_group"> 
		<p class="form-field"> 
			<label><?php esc_html_e('Pagination color', 'wp-tiktok-feed'); ?></label> 
			<input class="color-picker" data-alpha="true" name="carousel[pagination_color]" type="text" placeholder="#c32a67" value="{{data.carousel.pagination_color}}" /> 
			<span class="description"><small><?php esc_html_e('Change pagination dotts color', 'wp-tiktok-feed'); ?></small></span>
		</p>
	</div>

</div>