

CREATE TABLE `magis_clientes` (
	`id` MEDIUMINT NOT NULL AUTO_INCREMENT,
	`ci` VARCHAR(24) UNIQUE NOT NULL,
	`nombre` VARCHAR(256) NOT NULL,
	`telefono` VARCHAR(16) NOT NULL,
	`ciudad` VARCHAR(256) NOT NULL,
	`fecha_creacion` datetime NOT NULL,
	`fecha_modificacion` datetime NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE `magis_cronograma_citas` (
	`id` MEDIUMINT NOT NULL AUTO_INCREMENT,
	`dia` VARCHAR(24) NOT NULL,
	`periodo` VARCHAR(128) NOT NULL,
	`estado` int(10) UNSIGNED NOT NULL,
	`id_promotor` MEDIUMINT NOT NULL,
	`id_proyecto`MEDIUMINT NOT NULL,
	`id_usuario_registrador` MEDIUMINT NOT NULL,
	PRIMARY KEY (id)
)

CREATE TABLE `magis_citas` (
  `IdCronograma` int(10) UNSIGNED NOT NULL,
  `IdUserPromotor` VARCHAR(256) NOT NULL,
  `FechaHoraInicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FechaHoraFin` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FechaHoraRegistro` datetime DEFAULT CURRENT_TIMESTAMP,
  `IdEstado` int(10) UNSIGNED NOT NULL,
  `IdUserRegistrador` bigint(20) UNSIGNED NOT NULL
);