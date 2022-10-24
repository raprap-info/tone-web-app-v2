<?php

use QUADLAYERS\TIKTOK\Frontend\Load as Frontend;
?>
<div class="tiktok-feed-video-wrap">
  <a class="tiktok-feed-link" href="<?php echo esc_url( $item['link'] ); ?>" target="_blank">
	<img alt="TikTok" class="tiktok-feed-video" src="<?php echo esc_url( $image ); ?>" />
	<?php if ( $feed['mask']['display'] ) : ?>
		<?php require Frontend::template_path( 'item/item-video-mask.php' ); ?>
	<?php endif; ?>
  </a>
  <span class="tiktok-feed-icon tiktok-feed-video-play">
	<svg width="56" height="56" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
	  <path d="M12.3171 7.57538C12.6317 7.77102 12.6317 8.22898 12.3171 8.42462L4.01401 13.5871C3.68095 13.7942 3.25 13.5547 3.25 13.1625V2.83747C3.25 2.44528 3.68095 2.20577 4.01401 2.41285L12.3171 7.57538Z" stroke="white" stroke-width="1.5"></path>
	</svg>
  </span>
  <a class="tiktok-feed-icon tiktok-feed-video-play-count" href="<?php echo esc_url( $item['link'] ); ?>" target="_blank">
	<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
	  <path d="M12.3171 7.57538C12.6317 7.77102 12.6317 8.22898 12.3171 8.42462L4.01401 13.5871C3.68095 13.7942 3.25 13.5547 3.25 13.1625V2.83747C3.25 2.44528 3.68095 2.20577 4.01401 2.41285L12.3171 7.57538Z" stroke="white" stroke-width="1.5"></path>
	</svg>
	<span>
	  <?php echo Frontend::qlttf_thousands_roud( $item['play_count'] ); ?>
	</span>
  </a>
</div>
