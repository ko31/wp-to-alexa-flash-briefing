<?php
/**
 * Plugin Name:     Alexa Flash Briefing Feed
 * Plugin URI:      https://github.com/ko31/alexa-flash-briefing-feed
 * Description:     This is a plugin to create a feed of Alexa flash briefing skill in WordPress.
 * Author:          ko31
 * Author URI:      https://go-sign.info
 * Text Domain:     alexa-flash-briefing-feed
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Alexa_Flash_Briefing_Feed
 */

namespace Alexa_Flash_Briefing_Feed;

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

register_activation_hook( __FILE__, function () {
	flush_rewrite_rules();
} );

add_action( 'plugins_loaded', function () {

	load_plugin_textdomain(
		'alexa-flash-briefing-feed',
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

