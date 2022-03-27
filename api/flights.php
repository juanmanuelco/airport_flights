<?php
add_action('rest_api_init', function () {
	register_rest_route('v1', '/list/flights', array(
		'methods' => \WP_REST_Server::READABLE,
		'callback' => 'flightList',
		'args' => [
			'type'
		],
	));
});
function flightList(WP_REST_Request $request){
	if(!isset($request['type']) || !isset($request['route']) ) return new WP_REST_Response('Error', 403);
	try {
		$args = array(
			'post_type'             => 'flight',
			'post_status'           => 'publish',
			'ignore_sticky_posts'   => 1,
			'orderby'               => 'date',
			'order'                 => 'DESC',
			'posts_per_page'        => -1,
			'meta_query' => array(
				array(
					'key' => '_wp_flight-type_meta_key',
					'value' => $request['type'],
					'compare' => '=',
				),
				array(
					'key' => '_wp_flight-route_meta_key',
					'value' => $request['route'],
					'compare' => '=',
				)
			)
		);
		$posts = wp_list_pluck( (new WP_Query($args))->get_posts(), 'ID');
		$posts = array_map(function ($p){
			$taxonomies = get_post_taxonomies($p);
			$terms = [];
			foreach ($taxonomies as $taxonomy){
				$tax_terms = get_the_terms($p, $taxonomy);
				if($tax_terms != false){
					$tax_terms = array_map(function ($t){
						$t->{'values'} = get_term_meta($t->term_id);
						return $t;
					}, $tax_terms);
				}
				$terms = array_merge($terms, [$taxonomy => $tax_terms ]);
			}
			$post_metas = get_post_meta($p);
			foreach ($post_metas as $key => $post_meta){
				if($key == '_wp_flight-destination_meta_key' || $key == '_wp_flight-origin_meta_key'){
					$post_metas[$key] = get_term_by('id', $post_metas[$key][0] , 'place');
				}
			}
			return [
				'flight' => get_post($p),
				'terms' => $terms,
				'meta_values' => $post_metas
			];
		}, $posts);

		return new WP_REST_Response($posts, 200);
	}catch (\Throwable $e){
		return new WP_REST_Response($e->getMessage(), 403);
	}
}