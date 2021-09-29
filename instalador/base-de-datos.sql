
DROP TABLE IF EXISTS idiomas;
CREATE TABLE idiomas
(
    id int(3) primary key auto_increment,
    idioma varchar(255) not null,
    composicion_prosa varchar(255) not null
);

DROP TABLE IF EXISTS palabras;
CREATE TABLE palabras
(
    id int(11) primary key auto_increment,
    palabra varchar(255) not null,
    id_tipo int(2) not null,
    id_idioma int(3) not null
);

DROP TABLE IF EXISTS relacion_palabras;
CREATE TABLE relacion_palabras
(
    id int(11) primary key auto_increment,
    id_palabra_origen int(11) not null,
    id_palabra_traduccion int(11) not null
);

DROP TABLE IF EXISTS tipos;
CREATE TABLE tipos
(
    id int(2) primary key auto_increment,
    tipo varchar(255) not null,
    descripcion text not null
);

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios
(
    id int(3) primary key auto_increment,
    usuario varchar(255) not null,
    contrasena text not null
);


DROP TABLE IF EXISTS tb_informe;
CREATE TABLE tb_informe (
  id int(11) NOT NULL,
  tipo char(2) NOT NULL,
  dependencia varchar(20) NOT NULL,
  texto text NOT NULL
);

ALTER TABLE tb_informe
  ADD PRIMARY KEY (id);

DROP VIEW IF EXISTS vista_idiomas;
CREATE VIEW vista_idiomas  AS SELECT count(0) AS conteo, t1.idioma AS idioma FROM idiomas AS t1 WHERE t1.id <> 0 GROUP BY t1.idioma ;

DROP VIEW IF EXISTS vista_palabras;
CREATE VIEW vista_palabras  AS SELECT count(0) AS conteo, t1.palabra AS palabra FROM palabras AS t1 WHERE t1.id <> 0 GROUP BY t1.palabra ;

DROP FUNCTION IF EXISTS fun_agregar_palabra;
DELIMITER $$

CREATE FUNCTION fun_agregar_palabra (p_palabra VARCHAR(255), p_id_tipo INT, p_id_idioma INT) RETURNS BIT(1) BEGIN 
  DECLARE v BIT;
  SET v = IF((SELECT COUNT(*) FROM palabras t1 WHERE t1.palabra = p_palabra AND t1.id_idioma = p_id_idioma) = 0, 1, 0);
  IF (v = 1) then
    INSERT INTO palabras(palabra, id_tipo, id_idioma)
    VALUES(UPPER(p_palabra), p_id_tipo, p_id_idioma); 
    RETURN 1;
  ELSE
    RETURN 0;
  END IF;
END$$

DELIMITER ;