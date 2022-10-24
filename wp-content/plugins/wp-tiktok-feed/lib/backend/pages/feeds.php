<?php
use QUADLAYERS\TIKTOK\Api\Tiktok\User\Load as Api_Tiktok_User;
use QUADLAYERS\TIKTOK\Frontend\Load as Frontend;
use QUADLAYERS\TIKTOK\Models\Account\Load as Models_Account;
?>

<div class="wrap about-wrap full-width-layout">
	<form method="post">
		<p class="submit">
			<?php submit_button( esc_html__( '+ Feed', 'btn-tiktok' ), 'primary', 'submit', false, array( 'id' => 'qlttf-add-feed' ) ); ?>
		</p>
		<table id="qlttf_feeds_table" class="form-table widefat striped">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Image', 'wp-tiktok-feed' ); ?></th>
					<th><?php esc_html_e( 'Source', 'wp-tiktok-feed' ); ?></th>
					<th><?php esc_html_e( 'Name', 'wp-tiktok-feed' ); ?></th>
					<th><?php esc_html_e( 'Layout', 'wp-tiktok-feed' ); ?></th>
					<th><?php esc_html_e( 'Shortcode', 'wp-tiktok-feed' ); ?></th>
					<th><?php esc_html_e( 'Actions', 'wp-tiktok-feed' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$position = 1;
			$index    = 0;

			foreach ( $feeds as $id => $feed ) {

				if ( ! isset( $feed['source'] ) ) {
					continue;
				}
				$is_valid      = false;
				$account_model = new Models_Account();
				$account       = $account_model->get_account( $feed['open_id'] );

				$frontend = new Frontend();

				$profile_info = $frontend::get_feed_profile( $feed );

				?>
				<tr style= "<?php echo ! $profile_info['is_valid'] ? 'pointer-events:none;opacity:0.5;' : ''; ?>" data-feed_id="<?php echo esc_attr( $id ); ?>" data-feed_open_id="<?php echo esc_attr( $profile_info['open_id'] ); ?>" data-feed_position="<?php echo esc_attr( $position ); ?>">
					<td width="1%">
						<img class="qlttf-avatar" src="<?php echo esc_url( $profile_info['avatar_url'] ); ?>" />
					</td>
					<td width="1%">
						<?php echo esc_html( ucwords( $feed['source'] ) ); ?>
					</td>
					<td width="1%">
						<?php echo esc_html( $profile_info['display_name'] ); ?>
					</td>
					<td>
						<?php echo esc_html( ucfirst( $feed['layout'] ) ); ?>
					</td>
					<td>
						<input id="<?php echo esc_attr( $id ); ?>-feed-shortcode" type="text" value='[tiktok-feed id="<?php echo esc_attr( $id ); ?>"]' readonly />
						<a href="javascript:;" data-qlttf-copy-feed-shortcode="#<?php echo esc_attr( $id ); ?>-feed-shortcode" class="button button-secondary">
						<i class="dashicons dashicons-edit"></i><?php esc_html_e( 'Copy', 'wp-tiktok-feed' ); ?>
						</a>
					</td>
					<td>
						<a href="javascript:;" class="qlttf_edit_feed button button-primary" title="<?php esc_html_e( 'Edit feed', 'wp-tiktok-feed' ); ?>"><?php esc_html_e( 'Edit' ); ?></a>
						<a href="javascript:;" class="qlttf_clear_cache button button-secondary" title="<?php esc_html_e( 'Clear feed cache', 'wp-tiktok-feed' ); ?>"><i class="dashicons dashicons dashicons-update"></i><?php esc_html_e( 'Cache', 'wp-tiktok-feed' ); ?></a>
						<a href="javascript:;" class="qlttf_delete_feed" title="<?php esc_html_e( 'Delete feed', 'wp-tiktok-feed' ); ?>"><?php esc_html_e( 'Delete' ); ?></a>
						<span class="spinner"></span>
					</td>
				</tr>
				<?php
				$position++;
				$index++;
			}
			unset( $i );
			?>
			</tbody>
		</table>
	</form>
</div>

<?php require_once 'modals/template-scripts-feed.php'; ?>
