
/* Elimina la funcion si ya existe */
drop procedure if exists fill_gates ;

/* Se pide como parametros un nombre, slug y descrpción*/
CREATE procedure fill_gates ( in name VARCHAR(255), in slug VARCHAR(255), in description longtext  )
DETERMINISTIC

BEGIN

    DECLARE IDENTIFY BIGINT;
   	INSERT INTO wp_terms (`term_id`, `name`, `slug`, `term_group`) VALUES (NULL, name, slug, '0'); 

    /* Se obtiene el ID */   
   	SET IDENTIFY = LAST_INSERT_ID();

    /* Se registra el elemento para ser usado*/
  	INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) 
	VALUES (NULL, IDENTIFY, 'gate', description, '0', '0'); 
END; 

/* Ejemplo de como llamar la función*/
CALL fill_gates ('Puerta 1', 'puerta-1', 'Descripcion de la puerta 1');
