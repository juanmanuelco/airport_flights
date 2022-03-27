<?php

/*
Plugin Name: Airport Flights
description: All you need for Airport flights management
Version: 0.0.1
Author: JUAN CUÑEZ
*/

//* Don't access this file directly
defined( 'ABSPATH' ) or die();

add_action( 'admin_menu', function(){
	add_menu_page(
		'Flights Management',
		'Flights Management',
		'manage_airlines',
		'flights_management?',
		'flightManagementLayout',
		plugins_url().'/AirportFlights/assets/images/airplane.png',
		'2'
	);
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
include_once ('taxonomies/door.php');
include_once ('taxonomies/status.php');
include_once ('permission/airline.php');
include_once ('general/footer.php');
include_once ('shortcodes/menu.php');
include_once ('api/flights.php');


function lang_init() {
	load_plugin_textdomain( 'airport_flights', false,  dirname( plugin_basename( __FILE__ ) ) . '/languages'  );
}
add_action( 'init', 'lang_init' );