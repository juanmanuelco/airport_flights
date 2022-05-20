<?php

/*
Plugin Name: Airport Flights
description: All you need for Airport flights management
Version: 0.0.2
Author: JUAN CUÑEZ
*/

//* Don't access this file directly
defined( 'ABSPATH' ) or die();

add_action( 'admin_menu', function(){
	add_menu_page(
		'Flights Management',
		'Flights Management',
		'manage_airlines',
		'flights_management',
		'flightManagementLayout',
		plugins_url().'/AirportFlights/assets/images/airplane.png',
		'2'
	);

	add_submenu_page(
		'flights_management',
		'Flights',
		'Flights',
		'manage_airlines',
		'edit.php?post_type=flight');

	add_submenu_page(
		'flights_management',
		'Airlines',
		'Airlines',
		'manage_airlines',
		'edit-tags.php?taxonomy=airline&post_type=flight');

	add_submenu_page(
		'flights_management',
		'Gates',
		'Gates',
		'manage_airlines',
		'edit-tags.php?taxonomy=gate&post_type=flight');

	add_submenu_page(
		'flights_management',
		'Places',
		'Places',
		'manage_airlines',
		'edit-tags.php?taxonomy=place&post_type=flight');

	add_submenu_page(
		'flights_management',
		'Statuses',
		'Statuses',
		'manage_airlines',
		'edit-tags.php?taxonomy=status&post_type=flight');
});




function vueScript() {
	if ( ! did_action( 'wp_enqueue_media' ) ) wp_enqueue_media();
	wp_enqueue_script( 'vueScript',  plugins_url( '/AirportFlights/assets/js/vue.js'), array('jquery'), null, false );
}
add_action( 'admin_enqueue_scripts', 'vueScript' );


include_once ('panel.php');

include_once ('post_types/flight.php');
include_once ('taxonomies/airline.php');
include_once( 'taxonomies/place.php' );
include_once( 'taxonomies/gate.php' );
include_once ('taxonomies/status.php');
include_once ('permission/airline.php');
include_once ('general/footer.php');
include_once ('shortcodes/menu.php');
include_once ('api/flights.php');


function lang_init() {
	load_plugin_textdomain( 'airport_flights', false,  dirname( plugin_basename( __FILE__ ) ) . '/languages'  );
}
add_action( 'init', 'lang_init' );