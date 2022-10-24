<div class="wrap about-wrap full-width-layout">
	<form id="qlttf-save-settings" method="post">
		<table class="widefat form-table">
			<tbody>
				<tr>
					<td colspan="100%">
					<table>
						<tbody>

						<tr>
							<th><?php esc_html_e( 'Remove data', 'wp-tiktok-feed' ); ?></th>
							<td>
							<input type="checkbox" name="flush" value="1" <?php checked( 1, $settings['flush'] ); ?> />
							<span class="description">
								<?php esc_html_e( 'Check this box to remove all data related to this plugin on uninstall.', 'wp-tiktok-feed' ); ?>
							</span>
							</td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Replace loader', 'wp-tiktok-feed' ); ?></th>
							<td>
							<?php
							$mid   = '';
							$misrc = '';
							if ( isset( $settings['spinner_id'] ) ) {
								$mid   = $settings['spinner_id'];
								$image = wp_get_attachment_image_src( $mid, 'full' );
								if ( $image ) {
									$misrc = $image[0];
								}
							}
							?>
							<input type="hidden" name="spinner_id" value="<?php echo esc_attr( $mid ); ?>" data-misrc="<?php echo esc_attr( $misrc ); ?>" />
							<a href="javascript:;" id="ig-spinner-upload" class="button button-primary"><?php esc_html_e( 'Upload', 'wp-tiktok-feed' ); ?></a>
							<a href="javascript:;" id="ig-spinner-reset" class="button button-secondary"><?php esc_html_e( 'Reset Spinner', 'wp-tiktok-feed' ); ?></a> 
							<p>
								<span class="description">
								<?php esc_html_e( 'Select an image from media library to replace the default loader icon.', 'wp-tiktok-feed' ); ?>
								</span>
							</p>
							</td>
							<td rowspan="2">
							<div class="tiktok-feed-spinner">
							</div>
							</td>
						</tr>
						</tbody>
					</table>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3">
					<span class="spinner"></span>
					<button type="submit" class="button button-primary secondary"><?php esc_html_e( 'Save', 'wp-tiktok-feed' ); ?></button>
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
</div>
