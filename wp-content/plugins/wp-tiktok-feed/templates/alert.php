<div class="tiktok-feed-alert">
	<b><?php esc_html_e( 'Unable to get results', 'wp-tiktok-feed' ); ?></b>
	<?php if ( $messages ) : ?>
		<ul>
			<?php foreach ( $messages as $id => $message ) : ?>
				<li>
					<?php echo wp_kses_post( $message ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
