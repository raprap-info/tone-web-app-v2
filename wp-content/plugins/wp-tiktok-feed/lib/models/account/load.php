<?php

namespace QUADLAYERS\TIKTOK\Models\Account;

use QUADLAYERS\TIKTOK\Models\Base as Model;

/**
 * Account Model Class
 */
class Load extends Model {

	/**
	 * Table - Table string name.
	 *
	 * @var string
	 */
	protected $table = 'tiktok_feed_accounts';

	protected static $access_token_max_renew_attemps = 3;

	/**
	 * Function get_args() - return defaults args.
	 *
	 * @return object
	 */
	public function get_args() {
		return array(
			'open_id'                       => '', // Unique public user code.
			'account_type'                  => '',
			'username'                      => '',
			'profile_picture_url'           => '',
			'access_token'                  => '', // Private user access_token.
			'access_token_expiration_date'  => 0,  // Date when access_token expires.
			'access_token_renew_atemps'     => 0,
			'refresh_token'                 => '', // Private user refresh_token to update access_token.
			'refresh_token_expiration_date' => 0,  // Date when refresh_token expires.
		);
	}

	public function get_defaults() {
		return array();
	}

	public function get_account( $id ) {

		$accounts = $this->get_accounts();

		if ( ! isset( $accounts[ $id ] ) ) {
			return false;
		}

		if ( ! isset( $accounts[ $id ]['access_token_expiration_date'] ) ) {
			return $accounts[ $id ];
		}

		$is_access_token_expired = $this->is_access_token_expired( $accounts [ $id ] );

		if ( ! $is_access_token_expired ) {
			return $accounts[ $id ];
		}

		/**
		 * If access_token is renewed return updated account
		 */
		if ( $this->validate_access_token( $accounts[ $id ] ) ) {
			$accounts = $this->get_accounts();
		}

		return $accounts[ $id ];
	}

	/**
	 * Function: renew_access_token():
	 * renew all user data querying from tiktok
	 *
	 * @param string $refresh_token - user refresh_token.
	 * @return object
	 */
	public function renew_access_token( $refresh_token ) {

		$args = array(
			'redirect_url'  => 'admin.php?page=qlttf_account',
			'refresh_token' => $refresh_token,
		);

		$new_user_data = wp_remote_post(
			'https://tiktokfeed.quadlayers.com/refreshToken',
			array(
				'method'  => 'POST',
				'timeout' => 45,
				'body'    => json_encode( $args ),
			)
		);
		$new_user_data = json_decode( $new_user_data['body'] );

		return $new_user_data;
	}

	public function access_token_renew_attemps_increase( $account ) {
		$account['access_token_renew_atemps'] = intval( $account['access_token_renew_atemps'] ) + 1;
		$this->update_account( $account );
	}

	public static function access_token_renew_attemps_exceded( $account ) {
		if ( intval( $account['access_token_renew_atemps'] ) > self::$access_token_max_renew_attemps ) {
			return true;
		}
		return false;
	}

	public function validate_access_token( $account ) {

		/**
		 * Checks if $account has already reached maximum attempts possible.
		 */
		if ( self::access_token_renew_attemps_exceded( $account ) ) {
			return false;
		}

		$response = $this->renew_access_token( $account['refresh_token'] );

		/**
		 *  Checks if $response has setted error, access_token_expires_in and access_token.
		 */

		if ( isset( $response->error ) || ! isset( $response->access_token_expires_in ) || ! isset( $response->access_token ) ) {
			$this->access_token_renew_attemps_increase( $account );
			return false;
		}

		// Checks if $account['access_token'] has expired.
		if ( $account['access_token_expiration_date'] >= $this->calculate_expiration_date( $response->access_token_expires_in ) ) {
			return false;
		}

		$account['access_token_renew_atemps']     = 0;
		$account['access_token']                  = $response->access_token;
		$account['refresh_token']                 = $response->refresh_token;
		$account['access_token_expiration_date']  = $this->calculate_expiration_date( $response->access_token_expires_in );
		$account['refresh_token_expiration_date'] = $this->calculate_expiration_date( $response->refresh_token_expires_in );
		$account                                  = $this->update_account( $account );

		if ( $account ) {
			return $account;
		}

		return false;
	}

	public function is_access_token_expired( $account ) {
		if ( $account['access_token_expiration_date'] - strtotime( current_time( 'mysql' ) ) < 0 ) {
			return true;
		}
		return false;
	}

	public function force_refresh_access_token( $account_id ) {
		$accounts = $this->get_accounts();

		$account_to_refresh_access_token = $accounts[ $account_id ];

		$new_account_data = $this->renew_access_token( $account_to_refresh_access_token['refresh_token'] );

		$account_to_refresh_access_token['open_id']                       = $new_account_data->open_id;
		$account_to_refresh_access_token['access_token']                  = $new_account_data->access_token;
		$account_to_refresh_access_token['refresh_token']                 = $new_account_data->refresh_token;
		$account_to_refresh_access_token['access_token_renew_atemps']     = 0;
		$account_to_refresh_access_token['access_token_expiration_date']  = $this->calculate_expiration_date( $new_account_data->access_token_expires_in );
		$account_to_refresh_access_token['refresh_token_expiration_date'] = $this->calculate_expiration_date( $new_account_data->refresh_token_expires_in );

		return $this->update_account( $account_to_refresh_access_token );
	}

	public function get_accounts() {
		$accounts = $this->get_all();
		// make sure each account has all values
		if ( count( $accounts ) ) {
			foreach ( $accounts as $id => $account ) {
				$accounts[ $id ] = array_replace_recursive( $this->get_args(), $accounts[ $id ] );
			}
		}
		return $accounts;
	}

	public function update_account( $account_data ) {
		return $this->save_account( $account_data );
	}

	public function update_accounts( $accounts, $order = 0 ) {
		return $this->save_all( $accounts );
	}

	public function add_account( $account_data ) {

		// if account_data not exist or not set, return error{ error: code, message: 'text'}.
		if ( empty( $account_data ) ) {
			return array(
				'error'   => 404,
				'message' => 'Account data is empty/null',
			);
		}
		// if refresh_token not exist or not set, return error{ error: code, message: 'text'}.
		if ( empty( $account_data['refresh_token'] ) ) {
			return array(
				'error'   => 404,
				'message' => 'refresh_token is empty/null',
			);
		}

		// if all attributes exist, return save_account($account_data).
		if ( isset( $account_data['open_id'] ) &&
		isset( $account_data['access_token'] ) &&
		isset( $account_data['access_token_expires_in'] ) &&
		isset( $account_data['refresh_token'] ) &&
		isset( $account_data['refresh_token_expires_in'] ) &&
		isset( $account_data['access_token_expiration_date'] ) &&
		isset( $account_data['refresh_token_expiration_date'] ) ) {

			return $this->save_account( $account_data );
		}

		// if only exist($account_data['refresh_token']) return renew_access_token($account_data).

			$response = $this->renew_access_token( $account_data['refresh_token'] );

		if ( ! empty( $response->message ) ) {
			// if refresh_token is not valid return error{ error: code, message: 'text'}.
			return array(
				// todo agregar error
				'error'   => 404,
				'message' => $response->data->description,
				// todo agregar error_code
			);
		}

		if ( ! isset( $response->open_id, $response->access_token, $response->refresh_token, $response->access_token_expires_in, $response->refresh_token_expires_in ) ) {
			return array(
				'error'   => 404,
				'message' => 'Unknown error.',
			);
		}

		$account_data['open_id']                       = $response->open_id;
		$account_data['access_token']                  = $response->access_token;
		$account_data['refresh_token']                 = $response->refresh_token;
		$account_data['access_token_renew_atemps']     = 0;
		$account_data['access_token_expiration_date']  = $this->calculate_expiration_date( $response->access_token_expires_in );
		$account_data['refresh_token_expiration_date'] = $this->calculate_expiration_date( $response->refresh_token_expires_in );
		$account_data['access_token_expires_in']       = $response->access_token_expires_in;
		$account_data['refresh_token_expires_in']      = $response->refresh_token_expires_in;

		return $this->save_account( $account_data );
	}

	public function save_account( $account_data = null ) {

		if ( $account_data['open_id'] ) {
			/*
			 if ( isset( $account_data['access_token_expires_in'] ) && isset( $account_data['refresh_token_expires_in'] ) ) {

			} */
			$account_data                         = array_intersect_key( $account_data, $this->get_args() );
			$accounts                             = $this->get_accounts();
			$accounts[ $account_data['open_id'] ] = array_replace_recursive( $this->get_args(), $account_data );
			if ( $this->save_all( $accounts ) ) {
				return $account_data;
			}
		}
	}

	public function delete_account( $id = null ) {
		 $accounts = $this->get_all();
		if ( $accounts ) {
			if ( count( $accounts ) > 0 ) {
				unset( $accounts[ $id ] );
				return $this->save_all( $accounts );
			}
		}
	}

	public function calculate_expiration_date( $expires_in ) {
		return strtotime( current_time( 'mysql' ) ) + $expires_in - 1;
	}
}
