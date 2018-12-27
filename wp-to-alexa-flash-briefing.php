<?php
/**
 * Plugin Name:     WP to Alexa Flash Briefing
 * Plugin URI:      https://github.com/ko31/wp-to-alexa-flash-briefing
 * Description:     This is a plugin to create a feed of Alexa flash briefing skill in WordPress.
 * Author:          ko31
 * Author URI:      https://go-sign.info
 * Text Domain:     wp-to-alexa-flash-briefing
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Wp_To_Alexa_Flash_Briefing
 */

namespace Wp_To_Alexa_Flash_Briefing;

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

register_activation_hook( __FILE__, function () {
	flush_rewrite_rules();
} );

add_action( 'plugins_loaded', function () {

	load_plugin_textdomain(
		'wp-to-alexa-flash-briefing',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);

	if ( is_admin() ) {
		$admin = new Admin();
		$admin->activate();
	}
	$api = new Api();
	$api->register();
} );

