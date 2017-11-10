

CREATE TABLE `magis_clientes` (
	`id` MEDIUMINT NOT NULL AUTO_INCREMENT,
	`ci` VARCHAR(24) UNIQUE NOT NULL,
	`nombre` VARCHAR(256) NOT NULL,
	`telefono` VARCHAR(16) NOT NULL,
	`ciudad` VARCHAR(256) NOT NULL,

	`fecha_creacion` DATETIME NOT NULL,
	`fecha_modificacion` DATETIME NOT NULL,

	PRIMARY KEY (id)
);

CREATE TABLE `magis_cronograma_citas` (
	`id` MEDIUMINT NOT NULL AUTO_INCREMENT,
	`dia` VARCHAR(24) NOT NULL,
	`periodo` VARCHAR(128) NOT NULL,
	`estado` VARCHAR(24) NOT NULL,
	`id_proyecto` BIGINT(20) UNSIGNED NOT NULL,
	`id_promotor` MEDIUMINT NOT NULL,
	`id_usuario_registrador` MEDIUMINT NOT NULL,

	`fecha_creacion` DATETIME NOT NULL,
	`fecha_modificacion` DATETIME NOT NULL,

	PRIMARY KEY (id),
	FOREIGN KEY (id_proyecto) REFERENCES wp_posts(ID)
);

CREATE TABLE `magis_citas` (
	`id` MEDIUMINT NOT NULL AUTO_INCREMENT,
	`hash` VARCHAR(32) UNIQUE NOT NULL,
	`id_cronograma` MEDIUMINT NOT NULL,
	`id_cliente` MEDIUMINT NOT NULL,
	`estado` VARCHAR(24) NOT NULL,

	`fecha_creacion` DATETIME NOT NULL,

	PRIMARY KEY (id),
	FOREIGN KEY (id_cronograma) REFERENCES magis_cronograma_citas(id),
	FOREIGN KEY (id_cliente) REFERENCES magis_clientes(id)
);

CREATE TABLE `magis_promotores` (
	`id` MEDIUMINT NOT NULL AUTO_INCREMENT,
	`ci` VARCHAR(24) UNIQUE NOT NULL,
	`nombre` VARCHAR(256) NOT NULL,
	`direccion` VARCHAR(256) NOT NULL,
	`telefono` VARCHAR(16) NOT NULL,
	`estado` VARCHAR(64) NOT NULL,

	`ci_garante` VARCHAR(24) NOT NULL,
	`nombre_garante` VARCHAR(256) NOT NULL,
	`direccion_garante` VARCHAR(256) NOT NULL,
	`telefono_garante` VARCHAR(16) NOT NULL,

	`fecha_creacion` DATETIME NOT NULL,
	`fecha_modificacion` DATETIME NOT NULL,

	PRIMARY KEY (id)
);

INSERT INTO magis_cronograma_citas VALUES(default, 'Viernes', '8:00 am - 11:00 am', 'publish', 301, 0, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO magis_cronograma_citas VALUES(default, 'Viernes', '14:00 - 16:00', 'publish', 301, 0, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO magis_cronograma_citas VALUES(default, 'Sábado', '14:00 - 16:00', 'publish', 301, 0, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO magis_cronograma_citas VALUES(default, 'Sábado', '14:00 - 16:00', 'publish', 393, 0, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
