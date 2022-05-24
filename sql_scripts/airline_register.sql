
/* Elimina la funcion si ya existe */
drop procedure if exists fill_airlines ;

/* Se pide como parametros un nombre, slug y descrpción*/
CREATE procedure fill_airlines ( in name VARCHAR(255), in slug VARCHAR(255), in description longtext , in image_url VARCHAR(255) )
DETERMINISTIC

BEGIN

    DECLARE IDENTIFY BIGINT;
   	INSERT INTO wp_terms (`term_id`, `name`, `slug`, `term_group`) VALUES (NULL, name, slug, '0'); 

    /* Se obtiene el ID */   
   	SET IDENTIFY = LAST_INSERT_ID();

    /* Se registra el elemento para ser usado*/
  	INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) 
	VALUES (NULL, IDENTIFY, 'airline', description, '0', '0'); 

    
    /* Aqui se registra el código del sitio ejemplo Ecuador = EC */
    INSERT INTO `wp_termmeta` (`meta_id`, `term_id`, `meta_key`, `meta_value`) 
    VALUES (NULL, IDENTIFY, 'airline_image', image_url); 

END; 

/* Ejemplo de como llamar la función*/
CALL fill_airlines ('Tame', 'tame', 'Aerolinea Tame', 'http://127.0.0.1/aeropuertos/wp-content/uploads/2022/05/logo_grande_tame04.jpg');