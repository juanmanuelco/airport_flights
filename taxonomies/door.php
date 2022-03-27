<?php

add_action('init', function (){
	register_taxonomy('door','flight',array(
		'hierarchical' => true,
		'labels' => [
			'name' => __( 'Doors', 'airport_flights' ),
			'singular_name' => __( 'Door', 'airport_flights' ),
			'search_items' =>  __( 'Search doors', 'airport_flights' ),
			'popular_items' => __( 'Popular doors', 'airport_flights' ),
			'all_items' => __( 'All doors', 'airport_flights' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit door', 'airport_flights' ),
			'update_item' => __( 'Update door', 'airport_flights' ),
			'add_new_item' => __( 'Add New door', 'airport_flights' ),
			'new_item_name' => __( 'New Door Name', 'airport_flights' ),
			'separate_items_with_commas' => __( 'Separate Doors with commas', 'airport_flights' ),
			'add_or_remove_items' => __( 'Add or remove doors', 'airport_flights' ),
			'choose_from_most_used' => __( 'Choose from the most used doors', 'airport_flights' ),
			'menu_name' => __( 'Doors', 'airport_flights' ),
		],
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'door'),
		'capabilities'     => array(
			'manage_terms' => 'manage_doors',
			'edit_terms' => 'manage_doors',
			'delete_terms' => 'manage_doors',
			'assign_terms' => 'edit_flights'
		),
	));
});