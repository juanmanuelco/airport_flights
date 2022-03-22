<?php

function flightPostType(){
	register_post_type( 'flight',
		array(
			'labels'       => array(
				'name'               => __( 'Flights' ),
				'singular_name'      => __( 'Flight' ),
				'add_new'            => __( 'Add New flight' ),
				'add_new_item'       => __( 'Add New flight' ),
				'edit_item'          => __( 'Edit Flight' ),
				'new_item'           => __( 'New Flight' ),
				'all_items'          => __( 'All Flights' ),
				'view_item'          => __( 'View Flights' ),
				'search_items'       => __( 'Search Flights' ),
				'not_found'          => __( 'No flights found' ),
				'not_found_in_trash' => __( 'No flights found in the Trash' ),
				'menu_name'          => 'Flights'
			),
			'public'              => true,
			'capability_type'     => array('flight','flights'),
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'has_archive'         => true,
			'supports'     => array(
				'title'
			),
		) );
}
add_action('init', 'flightPostType');


function flightCustomFields() {
	add_meta_box(
		'wp_flight_type',
		__('Flight details'),
		'wp_flight_type_callback',
		'flight'
	);
}

function wp_flight_type_callback($post){
	$flight_type = get_post_meta( $post->ID, '_wp_flight-type_meta_key', true );
	$flight_route = get_post_meta( $post->ID, '_wp_flight-route_meta_key', true );
	$flight_code = get_post_meta( $post->ID, '_wp_flight-code_meta_key', true );
	$flight_estimate = get_post_meta( $post->ID, '_wp_flight-estimate_meta_key', true );

	$flight_origin = get_post_meta( $post->ID, '_wp_flight-origin_meta_key', true );
	$flight_destination = get_post_meta( $post->ID, '_wp_flight-destination_meta_key', true );

	$places = get_terms( 'place', array( 'hide_empty' => false));
    $places = array_map(function($place){
	    $response = new stdClass();
	    $response->name = $place->name;
	    $response->id = $place->term_id;
        $response->visible = true;
        return $response;
    }, $places)
    ?>

        <div style="display: flex; justify-content: space-between " id="flight_app">
            <div>
                <h3><?php echo __('Flight type', 'Flight type') ?></h3>
                <select required name="flight_type" v-model="flight_type">
                    <option v-for="type in flight_types" v-bind:value="type.value">{{type.label}}</option>
                </select>
            </div>
            <div>
                <h3><?php echo __('Flight route', 'Flight route') ?></h3>
                <select required name="flight_route" v-model="flight_route">
                    <option v-for="route in flight_routes" v-bind:value="route.value">{{route.label}}</option>
                </select>
            </div>
            <div>
                <h3><?php echo __('Flight code', 'Flight code') ?></h3>
                <input type="text" required name="flight_code" minlength="1" maxlength="100" v-model="flight_code" >
            </div>
            <div>
                <h3><?php echo __('Estimate', 'Estimate') ?></h3>
                <input type="datetime-local" required name="flight_estimate" v-model="flight_estimate">
            </div>
            <div v-if="flight_type == 'arrival'">
                <h3><?php echo __('Origin', 'Origin') ?></h3>
                <input type="search" v-model="search" placeholder="<?php echo __('Search') ?>..." v-on:keyup="filter()">
                <hr>
                <select required name="flight_origin" v-model="flight_origin">
                    <option v-if="place.visible"  v-for="place in places" v-bind:value="place.id">{{place.name}}</option>
                </select>
            </div>
            <div v-if="flight_type == 'departure'">
                <h3><?php echo __('Destination', 'Destination') ?></h3>
                <div>
                    <input type="search" v-model="search" placeholder="<?php echo __('Search') ?>..." v-on:keyup="filter()">
                    <hr>
                </div>
                <select required name="flight_destination" v-model="flight_destination">
                    <option v-if="place.visible"  v-for="place in places" v-bind:value="place.id">{{place.name}}</option>
                </select>
            </div>
        </div>
    <?php
    include_once ('flight_script.php');
}

add_action( 'add_meta_boxes', 'flightCustomFields');

function save_flight( $post_id ) {
	if ($_POST == null || get_post($post_id)->post_type != 'flight') return;

	update_post_meta($post_id, '_wp_flight-type_meta_key', $_POST['flight_type']);
	update_post_meta($post_id, '_wp_flight-route_meta_key', $_POST['flight_route']);
	update_post_meta($post_id, '_wp_flight-code_meta_key', $_POST['flight_code']);
	update_post_meta($post_id, '_wp_flight-estimate_meta_key', $_POST['flight_estimate']);

    if($_POST['flight_type'] == 'arrival'){
        unset($_POST['flight_destination']);
	    update_post_meta($post_id, '_wp_flight-origin_meta_key', $_POST['flight_origin']);
        delete_post_meta($post_id, '_wp_flight-destination_meta_key');
    }else{
	    unset($_POST['flight_origin']);
	    update_post_meta($post_id, '_wp_flight-destination_meta_key', $_POST['flight_destination']);
	    delete_post_meta($post_id, '_wp_flight-origin_meta_key');
    }
}
add_action( 'save_post', 'save_flight' );

