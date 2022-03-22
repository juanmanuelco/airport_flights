<?php

add_action('init', function (){
	register_taxonomy('airline','flight',array(
		'hierarchical' => true,
		'labels' => [
			'name' => _x( 'Airlines', 'taxonomy general name' ),
			'singular_name' => _x( 'Airline', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Airlines' ),
			'popular_items' => __( 'Popular Airlines' ),
			'all_items' => __( 'All Airlines' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Airline' ),
			'update_item' => __( 'Update Airline' ),
			'add_new_item' => __( 'Add New Airline' ),
			'new_item_name' => __( 'New Airline Name' ),
			'separate_items_with_commas' => __( 'Separate Airlines with commas' ),
			'add_or_remove_items' => __( 'Add or remove Airlines' ),
			'choose_from_most_used' => __( 'Choose from the most used Airlines' ),
			'menu_name' => __( 'Airlines' ),
		],
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'airline'),
		'capabilities'     => array(
			'manage_terms' => 'manage_airlines',
            'edit_terms' => 'manage_airlines',
            'delete_terms' => 'manage_airlines',
            'assign_terms' => 'edit_flights'
        ),
	));
});

function airline_add_custom_field() {
	?>
	<div class="form-field term-image-wrap">
		<label for="cat-image"><?php _e( 'Image' ); ?></label>
		<p><a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a></p>
		<input type="hidden" name="airline_image" id="cat-image" value="" size="40" />
	</div>
	<?php
}
add_action( 'airline_add_form_fields', 'airline_add_custom_field', 10, 2 );



function airline_edit_custom_field($term) {
	$image = get_term_meta($term->term_id, 'airline_image', true);
	?>
	<tr class="form-field term-image-wrap">
		<th scope="row"><label for="airline_image"><?php _e( 'Image' ); ?></label></th>
		<td>
			<p><a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a></p><br/>
			<?php
				if(!empty($image)){
					?>
						<img src="<?php echo $image ?>" width="100%" alt="<?php echo $term->name ?>">
					<?php
				}
			?>
			<input type="hidden" name="airline_image" id="cat-image" value="<?php echo $image; ?>" size="40" />
		</td>
	</tr>
	<?php
}
add_action( 'airline_edit_form_fields', 'airline_edit_custom_field', 10, 2 );

function tx_include_script() {
	if ( ! did_action( 'wp_enqueue_media' ) ) wp_enqueue_media();
	wp_enqueue_script( 'txscript',  plugins_url( '/AirportFlights/assets/js/code.js'), array('jquery'), null, false );
}
add_action( 'admin_enqueue_scripts', 'tx_include_script' );


function save_taxonomy_custom_meta_field( $term_id ) {
	if ( isset( $_POST['airline_image'] ) ) update_term_meta($term_id, 'airline_image', $_POST['airline_image']);
}
add_action( 'edited_airline', 'save_taxonomy_custom_meta_field', 10, 2 );
add_action( 'create_airline', 'save_taxonomy_custom_meta_field', 10, 2 );