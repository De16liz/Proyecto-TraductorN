-- vista palabras

CREATE VIEW vista_palabras
AS
SELECT COUNT( * ) AS conteo, t1.palabra
FROM palabras t1
WHERE t1.id
GROUP BY t1.palabra;


-- vista idiomas

CREATE VIEW vista_idiomas
AS
SELECT COUNT( * ) AS conteo, t1.idioma
FROM idiomas t1
WHERE t1.id
GROUP BY t1.idioma;


-- FUNCIONES

-- Funcion de insertar palabras.
DROP FUNCTION IF EXISTS fun_agregar_palabra;
DELIMITER //
CREATE FUNCTION fun_agregar_palabra(p_palabra VARCHAR(255), p_id_tipo INT, p_id_idioma INT)
RETURNS BIT
BEGIN 
	DECLARE v BIT;
	SET v = IF((SELECT COUNT(*) FROM palabras t1 WHERE t1.palabra = p_palabra AND t1.id_idioma = p_id_idioma) = 0, 1, 0);
	IF (v = 1) then
		INSERT INTO palabras(palabra, id_tipo, id_idioma)
		VALUES(UPPER(p_palabra), p_id_tipo, p_id_idioma); 
		RETURN 1;
	ELSE
		RETURN 0;
	END IF;
END //
DELIMITER ;