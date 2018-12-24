<?php

namespace Alexa_Flash_Briefing_Feed;

class Admin {

	function activate() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_init', [ $this, 'admin_init' ] );
	}

	function admin_menu() {
		add_options_page(
			__( 'Alexa_Flash_Briefing_Feed', 'alexa-flash-briefing-feed' ),
			__( 'Alexa_Flash_Briefing_Feed', 'alexa-flash-briefing-feed' ),
			'manage_options',
			__( 'Alexa_Flash_Briefing_Feed', 'alexa-flash-briefing-feed' ),
			[ $this, "display" ]
		);
	}

	function admin_init() {
		register_setting(
			'alexa-flash-briefing-feed',
			'alexa-flash-briefing-feed'
		);

		add_settings_section(
			'basic_settings',
			__( 'Basic Settings', 'alexa-flash-briefing-feed' ),
			null,
			'alexa-flash-briefing-feed'
		);

		add_settings_field(
			'endpoint',
			__( 'Endpoint URL', 'alexa-flash-briefing-feed' ),
			[ $this, 'endpoint_callback' ],
			'alexa-flash-briefing-feed',
			'basic_settings'
		);
	}

	function endpoint_callback() {
		if ( empty( get_option( 'permalink_structure' ) ) ) {
			$endpoint = home_url ('?rest_route=/afbf/v1/briefings');
		} else {
			$endpoint = home_url ('/wp-json/afbf/v1/briefings');
		}
		?>
		<code><?php echo esc_url( $endpoint ); ?></code>
		<?php
	}

	function display() {
		?>
		<h1><?php _e( 'Alexa_Flash_Briefing_Feed', 'alexa-flash-briefing-feed' ); ?></h1>
		<?php
		settings_fields( 'alexa-flash-briefing-feed' );
		do_settings_sections( 'alexa-flash-briefing-feed' );
		?>
		<?php
	}
}
