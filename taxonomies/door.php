<?php

add_action('init', function (){
	register_taxonomy('door','flight',array(
		'hierarchical' => true,
		'labels' => [
			'name' => __( 'Doors', 'Doors' ),
			'singular_name' => __( 'Door', 'Door' ),
			'search_items' =>  __( 'Search doors' ),
			'popular_items' => __( 'Popular doors' ),
			'all_items' => __( 'All doors' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit door' ),
			'update_item' => __( 'Update door' ),
			'add_new_item' => __( 'Add New door' ),
			'new_item_name' => __( 'New Door Name' ),
			'separate_items_with_commas' => __( 'Separate Doors with commas' ),
			'add_or_remove_items' => __( 'Add or remove doors' ),
			'choose_from_most_used' => __( 'Choose from the most used doors' ),
			'menu_name' => __( 'Doors' ),
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