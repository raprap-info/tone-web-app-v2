<?php use QUADLAYERS\TIKTOK\Frontend\Load as Frontend; ?>
<div id="<?php echo esc_attr( $item_selector ); ?>" class="tiktok-feed-feed tiktok-feed-square" data-feed="<?php echo htmlentities( json_encode( $feed ), ENT_QUOTES, 'UTF-8' ); ?>" data-feed_layout="gallery">
	<?php
	if ( ! empty( $feed['box']['profile'] ) && ( $template_file = Frontend::template_path( 'parts/profile.php' ) ) ) {
		include $template_file;
	}
	?>
	<div class="tiktok-feed-list">
	</div>
	<?php require Frontend::template_path( 'parts/spinner.php' ); ?>
	<?php require Frontend::template_path( 'parts/actions.php' ); ?>
</div>
