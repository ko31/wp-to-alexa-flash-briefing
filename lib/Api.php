<?php

namespace Alexa_Flash_Briefing_Feed;

class Api {

	function register() {
		add_action( 'init', [ $this, 'init' ] );
		add_action( 'rest_api_init', [ $this, 'rest_api_init' ] );
	}

	function init() {
		$args = [
			'labels'                => [
				'name'                  => __( 'Briefings', 'alexa-flash-briefing-feed' ),
				'singular_name'         => __( 'Briefing', 'alexa-flash-briefing-feed' ),
				'all_items'             => __( 'All Briefings', 'alexa-flash-briefing-feed' ),
				'archives'              => __( 'Briefing Archives', 'alexa-flash-briefing-feed' ),
				'attributes'            => __( 'Briefing Attributes', 'alexa-flash-briefing-feed' ),
				'insert_into_item'      => __( 'Insert into Briefing', 'alexa-flash-briefing-feed' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Briefing', 'alexa-flash-briefing-feed' ),
				'featured_image'        => _x( 'Featured Image', 'briefing', 'alexa-flash-briefing-feed' ),
				'set_featured_image'    => _x( 'Set featured image', 'briefing', 'alexa-flash-briefing-feed' ),
				'remove_featured_image' => _x( 'Remove featured image', 'briefing', 'alexa-flash-briefing-feed' ),
				'use_featured_image'    => _x( 'Use as featured image', 'briefing', 'alexa-flash-briefing-feed' ),
				'filter_items_list'     => __( 'Filter Briefings list', 'alexa-flash-briefing-feed' ),
				'items_list_navigation' => __( 'Briefings list navigation', 'alexa-flash-briefing-feed' ),
				'items_list'            => __( 'Briefings list', 'alexa-flash-briefing-feed' ),
				'new_item'              => __( 'New Briefing', 'alexa-flash-briefing-feed' ),
				'add_new'               => __( 'Add New', 'alexa-flash-briefing-feed' ),
				'add_new_item'          => __( 'Add New Briefing', 'alexa-flash-briefing-feed' ),
				'edit_item'             => __( 'Edit Briefing', 'alexa-flash-briefing-feed' ),
				'view_item'             => __( 'View Briefing', 'alexa-flash-briefing-feed' ),
				'view_items'            => __( 'View Briefings', 'alexa-flash-briefing-feed' ),
				'search_items'          => __( 'Search Briefings', 'alexa-flash-briefing-feed' ),
				'not_found'             => __( 'No Briefings found', 'alexa-flash-briefing-feed' ),
				'not_found_in_trash'    => __( 'No Briefings found in trash', 'alexa-flash-briefing-feed' ),
				'parent_item_colon'     => __( 'Parent Briefing:', 'alexa-flash-briefing-feed' ),
				'menu_name'             => __( 'Briefings', 'alexa-flash-briefing-feed' ),
			],
			'public'                => true,
//			'hierarchical'          => false,
//			'show_ui'               => true,
//			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
//			'rewrite'               => true,
//			'query_var'             => true,
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
		$args = apply_filters( 'afbf_post_type_args', $args );

		register_post_type( 'briefing', $args );

		register_taxonomy(
			'briefing-cat',
			'briefing',
			array(
				'label'        => __( 'Category', 'alexa-flash-briefing-feed' ),
				'hierarchical' => true,
			)
		);

	}

	function rest_api_init() {
		register_rest_route( 'afbf/v1', '/briefings/', [
			'methods'  => 'GET',
			'callback' => [ $this, 'callback_api' ],
		] );
	}

	function callback_api( $request ) {
		$args = [
			'post_type'   => 'briefing',
			'post_status' => 'publish',
			'numberposts' => 5,
		];

		if ( ! empty( $request['category'] ) ) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'briefing-cat',
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
		$args = apply_filters( 'afbf_get_posts_args', $args );

		$posts = get_posts( $args );

		if ( empty( $posts ) ) {
			return new \WP_REST_Response();
		}

		$response = [];

		foreach ( $posts as $post ) {
			$mainText = wp_strip_all_tags( strip_shortcodes( $post->post_content, true ) );

			$data       = [
				'uid'            => sprintf( 'urn:uuid:%s', wp_generate_uuid4( get_permalink( $post ) ) ),
				'updateDate'     => get_post_modified_time( 'Y-m-d\TH:i:s.\0\Z', true, $post ),
				'titleText'      => $post->post_title,
				'mainText'       => $mainText,
				'streamUrl'      => '',
				'redirectionUrl' => get_permalink( $post ),
			];
			$response[] = $data;
		}

		return new \WP_REST_Response( $response );
	}
}
