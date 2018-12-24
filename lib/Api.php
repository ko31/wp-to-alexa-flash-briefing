<?php

namespace Alexa_Flash_Briefing_Feed;

class Api {

	function register() {
		add_action( 'init', array( $this, 'init' ) );
	}

	function init() {
		$args = [
			'labels'                => [
				'name'                  => __( 'Briefings', 'afbf' ),
				'singular_name'         => __( 'Briefing', 'afbf' ),
				'all_items'             => __( 'All Briefings', 'afbf' ),
				'archives'              => __( 'Briefing Archives', 'afbf' ),
				'attributes'            => __( 'Briefing Attributes', 'afbf' ),
				'insert_into_item'      => __( 'Insert into Briefing', 'afbf' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Briefing', 'afbf' ),
				'featured_image'        => _x( 'Featured Image', 'briefing', 'afbf' ),
				'set_featured_image'    => _x( 'Set featured image', 'briefing', 'afbf' ),
				'remove_featured_image' => _x( 'Remove featured image', 'briefing', 'afbf' ),
				'use_featured_image'    => _x( 'Use as featured image', 'briefing', 'afbf' ),
				'filter_items_list'     => __( 'Filter Briefings list', 'afbf' ),
				'items_list_navigation' => __( 'Briefings list navigation', 'afbf' ),
				'items_list'            => __( 'Briefings list', 'afbf' ),
				'new_item'              => __( 'New Briefing', 'afbf' ),
				'add_new'               => __( 'Add New', 'afbf' ),
				'add_new_item'          => __( 'Add New Briefing', 'afbf' ),
				'edit_item'             => __( 'Edit Briefing', 'afbf' ),
				'view_item'             => __( 'View Briefing', 'afbf' ),
				'view_items'            => __( 'View Briefings', 'afbf' ),
				'search_items'          => __( 'Search Briefings', 'afbf' ),
				'not_found'             => __( 'No Briefings found', 'afbf' ),
				'not_found_in_trash'    => __( 'No Briefings found in trash', 'afbf' ),
				'parent_item_colon'     => __( 'Parent Briefing:', 'afbf' ),
				'menu_name'             => __( 'Briefings', 'afbf' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
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
	}
}
