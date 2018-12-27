<?php

namespace Wp_To_Alexa_Flash_Briefing;

class Api {

	function register() {
		add_action( 'init', [ $this, 'init' ] );
		add_action( 'rest_api_init', [ $this, 'rest_api_init' ] );
	}

	function init() {
		$args = [
			'labels'                => [
				'name'                  => __( 'Briefings', 'wp-to-alexa-flash-briefing' ),
				'singular_name'         => __( 'Briefing', 'wp-to-alexa-flash-briefing' ),
				'all_items'             => __( 'All Briefings', 'wp-to-alexa-flash-briefing' ),
				'archives'              => __( 'Briefing Archives', 'wp-to-alexa-flash-briefing' ),
				'attributes'            => __( 'Briefing Attributes', 'wp-to-alexa-flash-briefing' ),
				'insert_into_item'      => __( 'Insert into Briefing', 'wp-to-alexa-flash-briefing' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Briefing', 'wp-to-alexa-flash-briefing' ),
				'featured_image'        => _x( 'Featured Image', 'briefing', 'wp-to-alexa-flash-briefing' ),
				'set_featured_image'    => _x( 'Set featured image', 'briefing', 'wp-to-alexa-flash-briefing' ),
				'remove_featured_image' => _x( 'Remove featured image', 'briefing', 'wp-to-alexa-flash-briefing' ),
				'use_featured_image'    => _x( 'Use as featured image', 'briefing', 'wp-to-alexa-flash-briefing' ),
				'filter_items_list'     => __( 'Filter Briefings list', 'wp-to-alexa-flash-briefing' ),
				'items_list_navigation' => __( 'Briefings list navigation', 'wp-to-alexa-flash-briefing' ),
				'items_list'            => __( 'Briefings list', 'wp-to-alexa-flash-briefing' ),
				'new_item'              => __( 'New Briefing', 'wp-to-alexa-flash-briefing' ),
				'add_new'               => __( 'Add New', 'wp-to-alexa-flash-briefing' ),
				'add_new_item'          => __( 'Add New Briefing', 'wp-to-alexa-flash-briefing' ),
				'edit_item'             => __( 'Edit Briefing', 'wp-to-alexa-flash-briefing' ),
				'view_item'             => __( 'View Briefing', 'wp-to-alexa-flash-briefing' ),
				'view_items'            => __( 'View Briefings', 'wp-to-alexa-flash-briefing' ),
				'search_items'          => __( 'Search Briefings', 'wp-to-alexa-flash-briefing' ),
				'not_found'             => __( 'No Briefings found', 'wp-to-alexa-flash-briefing' ),
				'not_found_in_trash'    => __( 'No Briefings found in trash', 'wp-to-alexa-flash-briefing' ),
				'parent_item_colon'     => __( 'Parent Briefing:', 'wp-to-alexa-flash-briefing' ),
				'menu_name'             => __( 'Briefings', 'wp-to-alexa-flash-briefing' ),
			],
			'public'                => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
			'menu_icon'             => 'dashicons-controls-volumeon',
			'show_in_rest'          => true,
			'rest_base'             => 'briefing',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		];

		/**
		 * Filters the post type arguments
		 *
		 * @param array $args
		 */
		$args = apply_filters( 'w2afb_register_post_type_args', $args );

		register_post_type( 'w2afb_briefing', $args );

		$args = [
			'label'        => __( 'Category', 'wp-to-alexa-flash-briefing' ),
			'hierarchical' => true,
			'show_in_rest' => true,
		];

		/**
		 * Filters the taxonomy arguments
		 *
		 * @param array $args
		 */
		$args = apply_filters( 'w2afb_register_taxonomy_args', $args );

		register_taxonomy( 'w2afb_briefing_cat', 'w2afb_briefing', $args );

	}

	function rest_api_init() {
		register_rest_route( 'w2afb/v1', '/briefings/', [
			'methods'  => 'GET',
			'callback' => [ $this, 'callback_api' ],
		] );
	}

	function callback_api( $request ) {
		$args = [
			'post_type'   => 'w2afb_briefing',
			'post_status' => 'publish',
			'numberposts' => 5,
		];

		if ( ! empty( $request['category'] ) ) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'w2afb_briefing_cat',
					'field'    => 'slug',
					'terms'    => $request['category'],
				]
			];
		}

		/**
		 * Filters the get posts arguments
		 *
		 * @param array $args
		 */
		$args = apply_filters( 'w2afb_get_posts_args', $args );

		$posts = get_posts( $args );

		if ( empty( $posts ) ) {
			return new \WP_REST_Response();
		}

		$response = [];

		foreach ( $posts as $post ) {
			$mainText = wp_strip_all_tags( strip_shortcodes( $post->post_content, true ) );

			$data = [
				'uid'            => sprintf( 'urn:uuid:%s', wp_generate_uuid4( get_permalink( $post ) ) ),
				'updateDate'     => get_post_modified_time( 'Y-m-d\TH:i:s.\0\Z', true, $post ),
				'titleText'      => $post->post_title,
				'redirectionUrl' => get_permalink( $post ),
			];

			$pattern = "/(https:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/";
			if ( preg_match_all( $pattern, $mainText, $matches ) ) {
				$data['mainText']  = '';
				$data['streamUrl'] = esc_url_raw( $matches[0][0] );
			} else {
				$data['mainText'] = $mainText;
			}

			/**
			 * Filters the response data
			 *
			 * @param array $data
			 * @param WP_Post $post
			 */
			$data = apply_filters( 'w2afb_response_data', $data, $post );

			$response[] = $data;
		}

		return new \WP_REST_Response( $response );
	}
}
