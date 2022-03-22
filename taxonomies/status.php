<?php


add_action( 'init', function () {
	register_taxonomy( 'status', 'flight', array(
		'hierarchical'      => true,
		'labels'            => [
			'name'                       => __( 'Statuses', 'Statuses' ),
			'singular_name'              => __( 'Status', 'Status' ),
			'search_items'               => __( 'Search statuses' ),
			'popular_items'              => __( 'Popular statuses' ),
			'all_items'                  => __( 'All statuses' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit status' ),
			'update_item'                => __( 'Update status' ),
			'add_new_item'               => __( 'Add New status' ),
			'new_item_name'              => __( 'New status Name' ),
			'separate_items_with_commas' => __( 'Separate statuses with commas' ),
			'add_or_remove_items'        => __( 'Add or remove statuses' ),
			'choose_from_most_used'      => __( 'Choose from the most used statuses' ),
			'menu_name'                  => __( 'Statuses' ),
		],
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'status' ),
		'capabilities'      => array(
			'manage_terms' => 'manage_statuses',
			'edit_terms'   => 'manage_statuses',
			'delete_terms' => 'manage_statuses',
			'assign_terms' => 'edit_flights'
		),
	) );
} );