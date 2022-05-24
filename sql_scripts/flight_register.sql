
/* Elimina la funcion si ya existe */
drop procedure if exists fill_flights ;

/* Se pide como parametros un nombre, slug y descrpción*/
CREATE procedure fill_flights ( 
	in fl_type VARCHAR(255),	in route VARCHAR(255),		in code VARCHAR(255),			in estimate VARCHAR(255), 
	in hidden VARCHAR(255),		in place_id BIGINT,			in airline_slug VARCHAR(255),	in gate_slug VARCHAR(255),	in status_slug VARCHAR(255)
)
DETERMINISTIC

BEGIN

    DECLARE IDENTIFY BIGINT;
   	DECLARE COLUMN_TYPE VARCHAR(255);
   	
   INSERT INTO 
   `wp_posts`(
	   `ID`, 			`post_author`, 	`post_date`, 	`post_date_gmt`, 	`post_content`,		`post_title`,			`post_excerpt`,				`post_status`,		`comment_status`, 	
	   `ping_status`, 	`post_name`, 	`to_ping`, 		`pinged`,			`post_modified`, 	`post_modified_gmt`, 	`post_content_filtered`,	`guid`, 			`post_type`
	) 
   	VALUES (
	   null, 													1, 		( select current_timestamp() ), 	( select current_timestamp() ), 	'', 
	   CONCAT('Code: ', code , ', Type: ', UCASE(fl_type) ), 	'', 	'publish', 							'closed', 							'closed', 
	   CONCAT('code-', LOWER(code), '-type-', LOWER(fl_type)), 	'', 	'', 								( select current_timestamp() ),  	( select current_timestamp() ), 	
	   '', 														'', 	'flight'
	);

   	SET IDENTIFY = LAST_INSERT_ID();

   if fl_type = 'arrival' then set COLUMN_TYPE = '_wp_flight-origin_meta_key';
   else set COLUMN_TYPE = '_wp_flight-destination_meta_key';
   end if;
   
   INSERT INTO 
   		`wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) 
   	VALUES 
   		(null, IDENTIFY,'_wp_flight-type_meta_key', 	LOWER(fl_type)	), 
   		(null, IDENTIFY,'_wp_flight-route_meta_key', 	route	), 
   		(null, IDENTIFY,'_wp_flight-code_meta_key', 	code	), 
   		(null, IDENTIFY,'_wp_flight-estimate_meta_key', estimate),
   		(null, IDENTIFY,'_wp_flight-hidden_meta_key', 	hidden	),
   		(null, IDENTIFY, COLUMN_TYPE, 					place_id	);
   
   	INSERT INTO `wp_term_relationships`(`object_id`, `term_taxonomy_id`, `term_order`) 
   	VALUES 
   		(IDENTIFY, (select term_taxonomy_id from wp_terms wpt left join wp_term_taxonomy wptx on wptx.term_id = wpt.term_id where slug like airline_slug limit 1) ,0),
   		(IDENTIFY, (select term_taxonomy_id from wp_terms wpt left join wp_term_taxonomy wptx on wptx.term_id = wpt.term_id where slug like gate_slug limit 1) ,	0),
   		(IDENTIFY, (select term_taxonomy_id from wp_terms wpt left join wp_term_taxonomy wptx on wptx.term_id = wpt.term_id where slug like status_slug limit 1)  ,0);

END; 

/* Ejemplo de como llamar la función*/
CALL fill_flights ('arrival', 'national', 'A005', '2022-05-19T05:02', 'on', 33, 'viriginia', 'puerta-12', 'blocked');
CALL fill_flights ('departure', 'international', 'A005', '2022-05-19T05:02', 'off', 33, 'viriginia', 'puerta-12', 'blocked');









