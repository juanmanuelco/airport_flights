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
    $taxonomies = ['place', 'airline', 'door', 'status'];
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