<?php

class MagisMeetingsModel
{
	public function __construct() {
		$this->db_version = '1.0';
		$this->table = 'magis_citas';
	}

	public function insert($row) {
		global $wpdb;

		$row['hash'] = $this->_rand_hash();
		$row['estado'] = 'Pendiente';
		$row['fecha_creacion'] = current_time('mysql');
		$row['fecha_modificacion'] = current_time('mysql');

		$wpdb->insert($this->table, $row);
		return $wpdb->get_row('SELECT * FROM magis_citas WHERE id =' . $wpdb->insert_id);
	}

	public function get_for_client($client_id) {
		global $wpdb;
		$query =
			"SELECT wp.post_title AS proyecto, c.estado AS estado, s.dia AS dia, s.hora_inicio AS hora_inicio, s.hora_fin AS hora_fin, c.fecha_creacion AS fecha_creacion ".
			"FROM $this->table AS c INNER JOIN magis_cronograma_citas s ON c.id_cronograma=s.id INNER JOIN wp_posts AS wp ON s.id_proyecto=wp.ID ".
			"WHERE id_cliente = '" . $client_id ."'";
		return $wpdb->get_results($query);
	}

	public function install() {
		global $wpdb;

		$table_name = $this->table;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` MEDIUMINT NOT NULL AUTO_INCREMENT,
			`hash` VARCHAR(32) UNIQUE NOT NULL,
			`id_cronograma` MEDIUMINT NOT NULL,
			`id_cliente` MEDIUMINT NOT NULL,
			`estado` VARCHAR(64) NOT NULL,

			`fecha_creacion` DATETIME NOT NULL,
			`fecha_modificacion` DATETIME NOT NULL,

			PRIMARY KEY (id),
			FOREIGN KEY (id_cronograma) REFERENCES magis_cronograma_citas(id),
			FOREIGN KEY (id_cliente) REFERENCES magis_clientes(id)
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		add_option('db_version', $this->db_version);
	}

	private function _rand_hash($len=32) {
		return substr(md5(openssl_random_pseudo_bytes(20)),-$len);
	}
}
