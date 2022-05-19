<?php
add_action('rest_api_init', function () {
	register_rest_route('v1', '/list/flights', array(
		'methods' => \WP_REST_Server::READABLE,
		'callback' => 'flightList',
	));
});
function flightList(WP_REST_Request $request){
	if(!isset($request['type']) || !isset($request['route']) ) return new WP_REST_Response('Error', 403);

	date_default_timezone_set('America/Guayaquil');

	if(!isset($request['current']) || !isset($request['interval_f']) || !isset($request['interval_b'])) return new WP_REST_Response('Parameters not found', 403);;

	$start = new DateTime($request['current']);
	$final = new DateTime($request['current']);

	date_add($start, date_interval_create_from_date_string("-{$request['interval_b']} hours"));
	date_add($final, date_interval_create_from_date_string("{$request['interval_f']} hours"));

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
				),

				array(
					'key' => '_wp_flight-estimate_meta_key',
					'value' =>  array(
						date($start->format('Y-m-d H:i:s')),
						date($final->format('Y-m-d H:i:s'))
					),
					'type'  => 'DATETIME',
					'compare' => 'BETWEEN'
				)
			),
			'tax_query' => array(
				array (
					'taxonomy' => 'status',
					'field' => 'status_hidden',
					'terms' => 'off',
					'operator' => '=',
				)
			),
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
					$place_meta = get_term_by('id', $post_metas[$key][0] , 'place');
					$post_metas[$key] = $place_meta;
					$post_metas[$key]->{'meta_data'} = get_term_meta($place_meta->term_id);
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