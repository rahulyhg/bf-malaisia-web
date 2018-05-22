<?php

namespace BFTheme;

/**
 * Class UTM
 *
 * record full_utm and campaign ID, in order to track the customer
 *
 * @package BFTheme
 *
 * @author Hoang Phan <vu-hoang.phan@bfoxint.com>
 */
class UTM {

	private $_request_uri;

	const UTM_CAMPAIGN = 'utm_campaign';
	const UTM_SOURCE   = 'utm_source';
	const COMPAIGN_ID  = 'campaignid';
	const FULL_UTM     = 'full_utm';

	private function create_cookie() {
		$uri = $this->_request_uri;
		parse_str( substr( $uri, 2 ), $params );
		$has_cam_id     = isset( $params[ self::COMPAIGN_ID ] ) && $params[ self::COMPAIGN_ID ];

		$has_utm_cam    = isset( $params[ self::UTM_CAMPAIGN ] ) && $params[ self::UTM_CAMPAIGN ];

		$has_utm_source = isset( $params[ self::UTM_SOURCE ] ) && $params[ self::UTM_SOURCE ];

		if ( $has_cam_id && ( $has_utm_cam || $has_utm_source ) ) {
			$cookie_value = $params[self::COMPAIGN_ID];
			setcookie(self::COMPAIGN_ID, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

			$uri          = str_replace( ['/','?'], '', $uri );
			$cam_id_part  = 'campaignid=' . $params[ self::COMPAIGN_ID ];
			$uri          = str_replace( $cam_id_part, '', $uri );
			$uri          = ltrim( $uri, '&' );
			$uri          = '?' . $uri;

			$cookie_value = $uri;
			setcookie(self::FULL_UTM, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
		} elseif ($has_utm_cam || $has_utm_source) {
			$uri          = str_replace( ['/'], '', $uri );
			$cookie_value = $uri;
			setcookie(self::FULL_UTM, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
		} elseif ($has_cam_id) {
			$cookie_value = $params[self::COMPAIGN_ID];
			setcookie(self::COMPAIGN_ID, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
		}



	}

	public function __construct($request_uri) {
		$this->_request_uri = $request_uri;
		$this->create_cookie();
		$this->exec();
	}

	private function exec() {
		add_action( 'user_register', [$this, 'attact_campaign_id_with_user'] );
		add_action('woocommerce_checkout_create_order', [$this, 'before_checkout_create_order'], 20, 2);
	}

	public function attact_campaign_id_with_user($user_id) {
		$campaign_id = isset($_COOKIE[self::COMPAIGN_ID]) ? $_COOKIE[self::COMPAIGN_ID] : '';
		$full_utm    = isset($_COOKIE[self::FULL_UTM]) ? $_COOKIE[self::FULL_UTM] : '';
		update_user_meta($user_id, 'campaign_id', $campaign_id);
		update_user_meta($user_id, 'full_utm', $full_utm);
	}

	public function before_checkout_create_order( $order, $data ) {
		$campaign_id = isset($_COOKIE[self::COMPAIGN_ID]) ? $_COOKIE[self::COMPAIGN_ID] : '';
		$full_utm    = isset($_COOKIE[self::FULL_UTM]) ? $_COOKIE[self::FULL_UTM] : '';
		$order->update_meta_data( 'campaign_id', $campaign_id );
		$order->update_meta_data( 'full_utm', $full_utm );
		$this->remove_cookies();
	}

	private function remove_cookies() {
		unset($_COOKIE[self::COMPAIGN_ID]);
		unset($_COOKIE[self::FULL_UTM]);
		setcookie(self::COMPAIGN_ID, '', time() - 3600);
		setcookie(self::FULL_UTM, '', time() - 3600);
	}
}
