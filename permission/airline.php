<?php

register_activation_hook( __FILE__ , 'flight_plugin_active' );

register_deactivation_hook( __FILE__ , 'flight_plugin_deactivate' );

function flight_plugin_active() {
	$caps = [
		'read'         => true,
		'create_posts' => true,
		'edit_posts'   => true,
		'upload_files' => true,
	];
	add_role( 'flights_manager', __('Flights manager', 'airport_flights'), $caps );
}

function flight_plugin_deactivate() {
	remove_role( 'flights_manager' );
}

add_action('admin_init','add_role_custom_caps');
function add_role_custom_caps() {
	flight_plugin_active();
	$roles = array('flights_manager', 'administrator');
	foreach($roles as $the_role) {
		$role = get_role($the_role);
		if($role == null) continue;
		$role->add_cap( 'read' );
		$role->add_cap( 'read_flights');
		$role->add_cap( 'read_private_flights' );
		$role->add_cap( 'edit_flights' );
		$role->add_cap( 'edit_others_flights' );
		$role->add_cap( 'edit_published_flights' );
		$role->add_cap( 'publish_flights' );
		$role->add_cap( 'delete_others_flights' );
		$role->add_cap( 'delete_private_flights' );
		$role->add_cap( 'delete_published_flights' );
		$role->add_cap( 'manage_airlines' );
		$role->add_cap( 'manage_places' );
		$role->add_cap( 'manage_gates' );
		$role->add_cap( 'manage_statuses' );
	}
}
