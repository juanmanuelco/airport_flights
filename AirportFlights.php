<?php

/*
Plugin Name: Airport Flights
description: All you need for Airport flights management
Version: 0.0.1
Author: JUAN CUÑEZ
*/

include_once ('includes/funtions.php');

add_action( 'admin_menu', function(){
	add_menu_page(
		'Flights Management',
		'Flights Management',
		'edit_airlines',
		'flights_management?',
		'flightManagementLayout',
		plugins_url().'/AirportFlights/assets/airplane.png',
		'2'
	);
});

function flightManagementLayout(){

}

add_action('init', function (){
	add_role( 'flights_manager', 'Flights Manager');
	register_post_type( 'airline',
		array(
			'labels' => array(
				'name' => __( 'Airlines' ),
				'singular_name' => __( 'Airline' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'airline'),
			'show_in_rest' => true,
			'map_meta_cap'    => true,
			'capability_type' => 'airlines',
			'supports'            => array( 'title', 'thumbnail' ),
			'capabilities' => setCapabilities('airline'),
			'show_in_menu' => 'flights_management',
		)
	);
});

function addOrRemoveCapability($isAdd = true) {
	$flightManager = get_role('flights_manager');
	$administrator = get_role( 'administrator' );

	foreach( getCapabilities('airline') as $cap ) {
		if($isAdd){
			$flightManager->add_cap( $cap );
			$administrator->add_cap( $cap );
		}else{
			$flightManager->remove_cap( $cap );
			$administrator->remove_cap( $cap );
		}

	}
}


register_activation_hook( __FILE__, function (){
	addOrRemoveCapability();
} );

register_deactivation_hook( __FILE__, function (){
	addOrRemoveCapability(false);
} );
