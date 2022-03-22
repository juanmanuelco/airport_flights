<?php

add_action('init', function (){
	register_taxonomy('place','flight',array(
		'hierarchical' => true,
		'labels' => [
			'name' => __( 'Places', 'Places' ),
			'singular_name' => __( 'Place', 'Place' ),
			'search_items' =>  __( 'Search places' ),
			'popular_items' => __( 'Popular places' ),
			'all_items' => __( 'All places' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit place' ),
			'update_item' => __( 'Update place' ),
			'add_new_item' => __( 'Add New place' ),
			'new_item_name' => __( 'New place Name' ),
			'separate_items_with_commas' => __( 'Separate places with commas' ),
			'add_or_remove_items' => __( 'Add or remove places' ),
			'choose_from_most_used' => __( 'Choose from the most used places' ),
			'menu_name' => __( 'Places' ),
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