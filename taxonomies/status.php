<?php


add_action( 'init', function () {
	register_taxonomy( 'status', 'flight', array(
		'hierarchical'      => true,
		'labels'            => [
			'name'                       => __( 'Statuses', 'Statuses' ),
			'singular_name'              => __( 'Status', 'Status' ),
			'search_items'               => __( 'Search statuses' ),
			'popular_items'              => __( 'Popular statuses' ),
			'all_items'                  => __( 'All statuses' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit status' ),
			'update_item'                => __( 'Update status' ),
			'add_new_item'               => __( 'Add New status' ),
			'new_item_name'              => __( 'New status Name' ),
			'separate_items_with_commas' => __( 'Separate statuses with commas' ),
			'add_or_remove_items'        => __( 'Add or remove statuses' ),
			'choose_from_most_used'      => __( 'Choose from the most used statuses' ),
			'menu_name'                  => __( 'Statuses' ),
		],
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'status' ),
		'capabilities'      => array(
			'manage_terms' => 'manage_statuses',
			'edit_terms'   => 'manage_statuses',
			'delete_terms' => 'manage_statuses',
			'assign_terms' => 'edit_flights'
		),
	) );
} );

function status_add_custom_field() {
	?>
<!--    <div class="form-field">-->
<!--        <label for="status_show_estimate">--><?php //_e( 'Show estimation' ); ?><!--</label>-->
<!--        <input type="checkbox" name="status_show_estimate" id="status_show_estimate" >-->
<!--    </div>-->

	<div class="form-field">
		<label for="status_bk_color"><?php _e( 'Background color' ); ?></label>
		<input type="color" name="status_bk_color" id="status_bk_color" value="#000000">
	</div>

	<div class="form-field">
		<label for="status_txt_color"><?php _e( 'Text color' ); ?></label>
		<input type="color" name="status_txt_color" id="status_txt_color" value="#ffffff">
	</div>
	<?php
}
add_action( 'status_add_form_fields', 'status_add_custom_field', 10, 2 );


function status_edit_custom_field($term) {
	$bk_color = get_term_meta($term->term_id, 'status_bk_color', true);
	$txt_color = get_term_meta($term->term_id, 'status_txt_color', true);
	//$show_estimation = get_term_meta($term->term_id, 'show_estimation', true);
	?>

<!--    <tr class="form-field term-bk_color-wrap">-->
<!--        <th scope="row">-->
<!--            <label for="status_show_estimate">--><?php //_e( 'Show estimation' ); ?><!--</label>-->
<!--        </th>-->
<!--        <td>-->
<!--            <input type="checkbox" name="status_show_estimate" id="status_show_estimate" --><?php //echo $show_estimation? 'checked' : '' ;  ?><!-- >-->
<!--        </td>-->
<!--    </tr>-->

	<tr class="form-field term-bk_color-wrap">
		<th scope="row">
			<label for="status_bk_color"><?php _e( 'Background color' ); ?></label>
		</th>
		<td>
			<input type="color" name="status_bk_color" id="status_bk_color" value="<?php echo $bk_color ?>">
		</td>
	</tr>

	<tr class="form-field term-txt_color-wrap">
		<th scope="row">
			<label for="status_bk_color"><?php _e( 'Text color' ); ?></label>
		</th>
		<td>
			<input type="color" name="status_txt_color" id="status_txt_color" value="<?php echo $txt_color ?>">
		</td>
	</tr>
	<?php
}
add_action( 'status_edit_form_fields', 'status_edit_custom_field', 10, 2 );


function save_taxonomy_status_meta_field( $term_id ) {
	if ( isset( $_POST['status_bk_color'] ) ) update_term_meta($term_id, 'status_bk_color', $_POST['status_bk_color']);
	if ( isset( $_POST['status_txt_color'] ) ) update_term_meta($term_id, 'status_txt_color', $_POST['status_txt_color']);
	//if ( isset( $_POST['status_show_estimate'] ) ) update_term_meta($term_id, 'show_estimation', $_POST['status_show_estimate']);
}
add_action( 'edited_status', 'save_taxonomy_status_meta_field', 10, 2 );
add_action( 'create_status', 'save_taxonomy_status_meta_field', 10, 2 );
