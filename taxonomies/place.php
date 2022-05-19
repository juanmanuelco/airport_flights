<?php

add_action('init', function (){
	register_taxonomy('place','flight',array(
		'hierarchical' => true,
		'labels' => [
			'name' => __( 'Places', 'airport_flights' ),
			'singular_name' => __( 'Place', 'airport_flights' ),
			'search_items' =>  __( 'Search places', 'airport_flights' ),
			'popular_items' => __( 'Popular places' , 'airport_flights'),
			'all_items' => __( 'All places', 'airport_flights' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit place', 'airport_flights' ),
			'update_item' => __( 'Update place', 'airport_flights' ),
			'add_new_item' => __( 'Add New place', 'airport_flights' ),
			'new_item_name' => __( 'New place Name' , 'airport_flights'),
			'separate_items_with_commas' => __( 'Separate places with commas', 'airport_flights' ),
			'add_or_remove_items' => __( 'Add or remove places' , 'airport_flights'),
			'choose_from_most_used' => __( 'Choose from the most used places' , 'airport_flights'),
			'menu_name' => __( 'Places', 'airport_flights' ),
		],
		'show_ui' => true,
		'show_in_rest' => true,
		'query_var' => true,
		'meta_box_cb' => false,
		'rewrite' => array('slug' => 'place'),
		'capabilities'     => array(
			'manage_terms' => 'manage_places',
			'edit_terms' => 'manage_places',
			'delete_terms' => 'manage_places',
			'assign_terms' => 'edit_flights'
		),
	));
});

add_action( 'admin_head', 'remove_parent_taxonomy' );

function remove_parent_taxonomy(){
    if(!isset($_GET['taxonomy'])) return;
    $taxonomies = ['place', 'airline', 'gate', 'status'];
	if ( !in_array($_GET['taxonomy'], $taxonomies) ) return;
	$parent = 'parent()';
	if ( isset( $_GET['action'] ) )
		$parent = 'parent().parent()';
	?>
	<script type="text/javascript">
        jQuery(document).ready(function($){
            $('label[for=parent]').<?php echo $parent; ?>.remove();
            let edited_parent = $('.term-parent-wrap');
            if(edited_parent.length > 0) edited_parent[0].remove();
        });
	</script>
	<?php
}



function place_add_custom_field() {
	?>

    <div class="form-field">
        <label for="english_name_txt"><?php _e( 'English name' ); ?></label>
        <input required type="text" name="english_name_txt" id="english_name_txt">
    </div>
    <div class="form-field">
        <label for="code_txt"><?php _e( 'Code' ); ?></label>
        <input required type="text" name="code_txt" id="code_txt">
    </div>

	<?php
}
add_action( 'place_add_form_fields', 'place_add_custom_field', 10, 2 );


function place_edit_custom_field($term) {
	$english_name = get_term_meta($term->term_id, 'english_name_txt', true);
	$code_txt = get_term_meta($term->term_id, 'code_txt', true);
	?>
    <tr class="form-field">
        <th scope="row">
            <label for="english_name_txt"><?php _e( 'English name' ); ?></label>
        </th>
        <td>
            <input type="text" required name="english_name_txt" id="english_name_txt" value="<?php echo $english_name ?>" >
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row">
            <label for="code_txt"><?php _e( 'Code' ); ?></label>
        </th>
        <td>
            <input type="text" required name="code_txt" id="code_txt" value="<?php echo $code_txt ?>" >
        </td>
    </tr>

	<?php
}
add_action( 'place_edit_form_fields', 'place_edit_custom_field', 10, 2 );




function save_taxonomy_place_meta_field( $term_id ) {

	if ( isset( $_POST['english_name_txt'] )  && !empty( $_POST['english_name_txt'])) {
		update_term_meta($term_id, 'english_name_txt', $_POST['english_name_txt']);
	}else{
		update_term_meta($term_id, 'english_name_txt', $_POST['name']);
	}

	if ( isset( $_POST['code_txt'] )  && !empty( $_POST['code_txt'])) {
		update_term_meta($term_id, 'code_txt', $_POST['code_txt']);
	}else{
		update_term_meta($term_id, 'code_txt', '');
	}

}
add_action( 'edited_place', 'save_taxonomy_place_meta_field', 10, 2 );
add_action( 'create_place', 'save_taxonomy_place_meta_field', 10, 2 );