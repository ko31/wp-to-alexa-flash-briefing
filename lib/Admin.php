<?php

namespace Wp_To_Alexa_Flash_Briefing;

class Admin {

	function activate() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_init', [ $this, 'admin_init' ] );
	}

	function admin_menu() {
		add_options_page(
			__( 'WP to Alexa Flash Briefing', 'wp-to-alexa-flash-briefing' ),
			__( 'WP to Alexa Flash Briefing', 'wp-to-alexa-flash-briefing' ),
			'manage_options',
			__( 'WP to Alexa Flash Briefing', 'wp-to-alexa-flash-briefing' ),
			[ $this, "display" ]
		);
	}

	function admin_init() {
		register_setting(
			'wp-to-alexa-flash-briefing',
			'wp-to-alexa-flash-briefing'
		);

		add_settings_section(
			'basic_settings',
			__( 'Basic Settings', 'wp-to-alexa-flash-briefing' ),
			null,
			'wp-to-alexa-flash-briefing'
		);

		add_settings_field(
			'endpoint',
			__( 'Endpoint URL', 'wp-to-alexa-flash-briefing' ),
			[ $this, 'endpoint_callback' ],
			'wp-to-alexa-flash-briefing',
			'basic_settings'
		);
	}

	function endpoint_callback() {
		?>
		<p><code><?php echo esc_url( get_rest_url( null, 'w2afb/v1/briefings' ) ); ?></code></p>
		<?php
		if ( ! is_ssl() ) {
			?>
			<p>
				<span class="dashicons dashicons-warning" aria-hidden="true"></span>
				<?php _e( 'SSL is recommended for endpoints.', 'wp-to-alexa-flash-briefing' ); ?>
			</p>
			<?php
		}
	}

	function display() {
		?>
		<h1><?php _e( 'WP to Alexa Flash Briefing', 'wp-to-alexa-flash-briefing' ); ?></h1>
		<?php
		settings_fields( 'wp-to-alexa-flash-briefing' );
		do_settings_sections( 'wp-to-alexa-flash-briefing' );
		?>
		<?php
	}
}
