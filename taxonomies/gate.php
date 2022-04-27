<?php

add_action('init', function (){
	register_taxonomy('gate','flight',array(
		'hierarchical' => true,
		'labels' => [
			'name' => __( 'Gates', 'airport_flights' ),
			'singular_name' => __( 'Gate', 'airport_flights' ),
			'search_items' =>  __( 'Search gates', 'airport_flights' ),
			'popular_items' => __( 'Popular gates', 'airport_flights' ),
			'all_items' => __( 'All gates', 'airport_flights' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit gate', 'airport_flights' ),
			'update_item' => __( 'Update gate', 'airport_flights' ),
			'add_new_item' => __( 'Add New gate', 'airport_flights' ),
			'new_item_name' => __( 'New Gate Name', 'airport_flights' ),
			'separate_items_with_commas' => __( 'Separate Gates with commas', 'airport_flights' ),
			'add_or_remove_items' => __( 'Add or remove gate', 'airport_flights' ),
			'choose_from_most_used' => __( 'Choose from the most used gates', 'airport_flights' ),
			'menu_name' => __( 'Gates', 'airport_flights' ),
		],
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'gate'),
		'capabilities'     => array(
			'manage_terms' => 'manage_gates',
			'edit_terms' => 'manage_gates',
			'delete_terms' => 'manage_gates',
			'assign_terms' => 'edit_flights'
		),
	));
});