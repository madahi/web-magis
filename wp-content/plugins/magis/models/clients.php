<?php

class MagisClientsModel
{
	public function __construct() {
		$this->db_version = '1.0';
		$this->table = 'magis_clientes';
	}

	public function insert_or_update($row, $where) {
		global $wpdb;
		$client = $wpdb->get_row('SELECT * FROM ' . $this->table . ' WHERE ci =' . $row['ci']);

		if(empty($client)) {
			$row['estado'] = 'Activo';
			$row['fecha_creacion'] = current_time('mysql');
			$row['fecha_modificacion'] = current_time('mysql');
			$wpdb->insert($this->table, $row);
		} else {
			$row['fecha_modificacion'] = current_time('mysql');
			$wpdb->update($this->table, $row, array('ci' => $row['ci']));
		}
		return $wpdb->get_row('SELECT * FROM ' . $this->table . ' WHERE ci =' . $row['ci']);
	}

	public function get_by_ci($ci) {
		global $wpdb;
		return $wpdb->get_row("SELECT * FROM $this->table WHERE ci='" . $ci ."'");
	}

	public function install() {
		global $wpdb;

		$table_name = $this->table;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` MEDIUMINT NOT NULL AUTO_INCREMENT,
			`ci` VARCHAR(24) UNIQUE NOT NULL,
			`nombre` VARCHAR(256) NOT NULL,
			`telefono` VARCHAR(16) NOT NULL,
			`ciudad` VARCHAR(256) NOT NULL,
			`estado` VARCHAR(64) NOT NULL,

			`fecha_creacion` DATETIME NOT NULL,
			`fecha_modificacion` DATETIME NOT NULL,

			PRIMARY KEY (id)
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		add_option('db_version', $this->db_version);
	}
}
