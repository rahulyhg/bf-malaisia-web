<?php

namespace BFOX;

/**
 * Class Protect_Content
 * @package BFOX
 *
 * @author Hoang Phan <hoang.phan@bfoxint.com>
 */
class Protect_Content {

	/**
	 * @var string
	 */
	private $uri;

	/**
	 * Protect_Content constructor.
	 *
	 * @param $uri
	 */
	public function __construct($uri) {
		$this->uri = $uri;
		$this->exec();
	}

	private function exec() {
		if (substr( $this->uri, 0, 13 ) == 'products/page'
		    ||
		    trim( $this->uri, '/' ) == "products"){
			add_action('wp_enqueue_scripts', [$this, 'bf_adding_preventer_scripts']);
		}
	}


	/**
	 * enqueue script
	 */
	public function bf_adding_preventer_scripts() {
		wp_register_script('preventer',plugins_url( 'bf-custom/preventer.js' ) , ['jquery'], '1.1', true);
		wp_enqueue_script('preventer');
	}

}