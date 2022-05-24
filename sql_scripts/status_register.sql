
/* Elimina la funcion si ya existe */
drop procedure if exists fill_statuses ;

/* Se pide como parametros un nombre, slug y descrpción*/
CREATE procedure fill_statuses ( in name VARCHAR(255), in slug VARCHAR(255), in description longtext , in eng_name VARCHAR(255), in bk_color VARCHAR(255), in txt_color VARCHAR(255) )
DETERMINISTIC

BEGIN

    DECLARE IDENTIFY BIGINT;
   	INSERT INTO wp_terms (`term_id`, `name`, `slug`, `term_group`) VALUES (NULL, name, slug, '0'); 

    /* Se obtiene el ID */   
   	SET IDENTIFY = LAST_INSERT_ID();

    /* Se registra el elemento para ser usado*/
  	INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) 
	VALUES (NULL, IDENTIFY, 'status', description, '0', '0'); 

    
    /* Aqui se registra el nombre en inglés del sitio  */
    INSERT INTO `wp_termmeta` (`meta_id`, `term_id`, `meta_key`, `meta_value`) 
    VALUES (NULL, IDENTIFY, 'english_name_txt', eng_name); 

     /* Aqui se registra el color de fondo (en hexadecimal) del status  */
    INSERT INTO `wp_termmeta` (`meta_id`, `term_id`, `meta_key`, `meta_value`) 
    VALUES (NULL, IDENTIFY, 'status_bk_color', bk_color); 

     /* Aqui se registra el color de texto (en hexadecimal) del status  */
    INSERT INTO `wp_termmeta` (`meta_id`, `term_id`, `meta_key`, `meta_value`) 
    VALUES (NULL, IDENTIFY, 'status_txt_color', txt_color); 

END; 

/* Ejemplo de como llamar la función*/
CALL fill_statuses ('Nuevo', 'nuevo', 'Nuevos vuelos', 'New', '#ffffff', '#000000');