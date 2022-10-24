<ul class="qlttf-tabs">
	<li class="media-modal-tab active">
		<a href="#tab_panel_feed"><span><?php esc_html_e('General', 'wp-tiktok-feed'); ?></span></a>
	</li>
	<# if (data.layout=='carousel' ){ #>
		<li class="media-modal-tab">
			<a href="#tab_panel_carousel"><span><?php esc_html_e('Carousel', 'wp-tiktok-feed'); ?></span></a>
		</li>
	<# } #>
	<# if ( data.layout=='carousel-vertical' ){ #>
		<li class="media-modal-tab">
			<a href="#tab_panel_carousel"><span><?php esc_html_e('Carousel Vertical', 'wp-tiktok-feed'); ?></span></a>
		</li>
	<# } #>
	<li class="media-modal-tab">
		<a href="#tab_panel_feed_box"><span><?php esc_html_e('Box', 'wp-tiktok-feed'); ?></span></a>
	</li>
	<li class="media-modal-tab">
		<a href="#tab_panel_feed_video"><span><?php esc_html_e('Video', 'wp-tiktok-feed'); ?></span></a>
	</li>
	<li class="media-modal-tab">
		<a href="#tab_panel_feed_video_card"><span><?php esc_html_e('Video Card', 'wp-tiktok-feed'); ?></span></a>
	</li>
	<li class="media-modal-tab">
		<a href="#tab_panel_feed_video_popup"><span><?php esc_html_e('Video Popup', 'wp-tiktok-feed'); ?></span></a>
	</li>
	<li class="media-modal-tab">
		<a href="#tab_panel_feed_button"><span><?php esc_html_e('Button', 'wp-tiktok-feed'); ?></span></a>
	</li>
	<li class="media-modal-tab">
		<# if( data.source=='username' ){ #>
		<a href="#tab_panel_feed_button_load"><span><?php esc_html_e('Button Load More', 'wp-tiktok-feed'); ?></span></a>
		<# } #>
	</li>
</ul>