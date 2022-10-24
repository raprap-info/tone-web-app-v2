<?php
use QUADLAYERS\TIKTOK\Api\Tiktok\User\Load as Api_Tiktok_User;
use QUADLAYERS\TIKTOK\Models\Account\Load as Models_Account;
?>
<div class="wrap about-wrap full-width-layout">
	<p>
		<a class="
		<?php
		if ( is_array( $accounts ) && count( $accounts ) ) {
			echo 'qlttf-premium-field';
		}
		?>
		" id="qlttf-generate-token" target="_self" href="<?php echo esc_url( $api_user->get_access_token_link() ); ?>" title="<?php esc_html_e( 'Add Tiktok Account', 'wp-tiktok-feed' ); ?>">
			<?php esc_html_e( 'Add Tiktok Account', 'wp-tiktok-feed' ); ?>
		</a>
			<a 
			id="qlttf-add-token" 
			class="
			<?php
			if ( is_array( $accounts ) && count( $accounts ) ) {
				echo 'qlttf-premium-field';
			}
			?>
			"	href="javascript:;"><?php esc_html_e( 'Button not working?', 'wp-tiktok-feed' ); ?></a>
			<a style="float:right;" href="<?php echo esc_url( QLTTF_DOCUMENTATION_ACCOUNT_URL ); ?>" target="_blank"><?php esc_html_e( 'How to get access token?', 'wp-tiktok-feed' ); ?></a>
			<span class="qlttf-premium-field">
			<span class="description hidden"><small><?php esc_html_e( 'Multiple user accounts are only allowed in the premium version.', 'wp-tiktok-feed' ); ?></small></span>
		</span>
	</p>

	<?php	if ( is_array( $accounts ) && count( $accounts ) ) : ?>
		<table id="qlttf_account_table" class="form-table widefat striped">
			<thead>
			<tr>
				<th><?php esc_html_e( 'Image', 'wp-tiktok-feed' ); ?></th>
				<th><?php esc_html_e( 'User', 'wp-tiktok-feed' ); ?></th>
				<th><?php esc_html_e( 'Open Id', 'wp-tiktok-feed' ); ?></th>
				<th><?php esc_html_e( 'Refresh Token', 'wp-tiktok-feed' ); ?></th>
				<th><?php esc_html_e( 'Expires(UTC+0)', 'wp-tiktok-feed' ); ?></th>
				<th><?php esc_html_e( 'Action', 'wp-tiktok-feed' ); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ( $accounts as $account_id => $account ) {
				$api_user = new Api_Tiktok_User( $account_id );
				$profile  = $api_user->get_profile_data();

				?>
				<tr data-account_id="<?php echo esc_attr( $account_id ); ?>">
				<td width="1%">
					<img class="qlttf-avatar" src="<?php echo esc_url( $profile['avatar_url'] ); ?>" />
				</td>
				<td>
					<?php echo esc_html( $profile['display_name'] ); ?>
				</td>
				<td>
					<?php echo esc_html( $account['open_id'] ); ?>
				</td>
				<td style="width: 300px;">
					<input type="hidden" name="account_id" value="<?php echo esc_attr( $account_id ); ?>">
					<input id="<?php echo esc_attr( $account_id ); ?>-access-token" type="text" value="<?php echo esc_attr( $account['refresh_token'] ); ?>" readonly />
					<a href="javascript:;" data-qlttf-copy-token="#<?php echo esc_attr( $account_id ); ?>-access-token" class="button button-primary">
					<i class="dashicons dashicons-admin-page"></i>
					</a>
				</td>
				<td>
				<!-- <?php echo sprintf( '%s (%s)', esc_html( date( 'Y-m-d', (int) $account['access_token_expiration_date'] ) ), esc_html__( 'Autorenew', 'wp-tiktok-feed' ) ); ?> -->

					<?php if ( ( ! Models_Account::access_token_renew_attemps_exceded( $account ) ) ) : ?>						
						<?php echo sprintf( '%s (%s)', esc_html( date( 'Y-m-d', (int) $account['access_token_expiration_date'] ) ), esc_html__( 'Autorenew', 'wp-tiktok-feed' ) ); ?>
					<?php else : ?>
						<?php echo sprintf( esc_html__( 'Autorenew fail! %s attemps.' ), $account['access_token_renew_atemps'] ); ?>
					<?php endif; ?>
				</td>
				<td>
				<?php if ( ( Models_Account::access_token_renew_attemps_exceded( $account ) ) ) : ?>
					<a href="javascript:;" data-qlttf-renew-token="<?php echo esc_attr( $account_id ); ?>" class="button button-error">
						<i class="dashicons dashicons-image-rotate"></i>
					</a>
					<?php endif; ?>
					<a href="javascript:;" data-qlttf-delete-token="<?php echo esc_attr( $account_id ); ?>" class="button button-secondary">
					<i class="dashicons dashicons-trash"></i>
					</a>
					<span class="spinner"></span>
				</td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
	<?php endif; ?>
</div>

<?php require_once 'modals/template-scripts-account.php'; ?>
