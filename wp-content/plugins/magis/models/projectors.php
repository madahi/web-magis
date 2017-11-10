<?php

class MagisProjectorsModel
{
	public function __construct() {
		$this->db_version = '1.0';
		$this->table = 'magis_promotores';
	}

	public function all_prety() {
		global $wpdb;
		return array(
			'columns'=>array(
				'CI', 'Estado', 'Nombre', 'Dirección', 'Teléfono',
				'CI del garante', 'Nombre del garante', 'Dirección del garante', 'Teléfono del garante',
				'Fecha de creación', 'Fecha de modificación'),

			'rows'=>$wpdb->get_results(
				"SELECT * " .
				"FROM " . $this->table)
		);
	}

	public function insert($row) {
		global $wpdb;
		$wpdb->insert($this->table, $row);
	}

	public function install() {
		global $wpdb;

		$table_name = $this->table;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
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
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		add_option('db_version', $this->db_version);
	}
}
