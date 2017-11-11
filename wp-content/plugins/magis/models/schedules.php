<?php

class MagisSchedulesModel
{
	public function __construct() {
		$this->db_version = '1.0';
		$this->table = 'magis_cronograma_citas';
	}

	public function all_prety() {
		global $wpdb;
		return array(
			'columns'=>array('Proyecto', 'Estado', 'Día', 'Hora inicio', 'Hora fin', 'Promotor','Fecha de creación', 'Fecha de modificación'),

			'rows'=>$wpdb->get_results(
				"SELECT mcs.id AS id, wpp.post_title AS proyecto, mcs.dia AS dia, mcs.hora_inicio AS hora_inicio, mcs.hora_fin AS hora_fin, mcs.estado AS estado, mp.nombre AS nombre_promotor, mcs.fecha_creacion AS fecha_creacion, mcs.fecha_modificacion AS fecha_modificacion " .
				"FROM " . $this->table . " AS mcs INNER JOIN wp_posts AS wpp ON mcs.id_proyecto = wpp.ID INNER JOIN magis_promotores AS mp ON mcs.id_promotor = mp.id " .
				"ORDER BY mcs.fecha_creacion DESC")
		);
	}

	public function get_all_enabled_days() {
		return array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
	}

	public function get_all_enabled_periods() {
		return array('8:00 am', '9:00 am', '10:00 am', '11:00 am', '12:00 pm', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00');
	}

	public function insert($row) {
		global $wpdb;
		$wpdb->insert($this->table, $row);
	}

	public function update($data, $where) {
		global $wpdb;
		$wpdb->update($this->table, $data, $where);
	}

	public function install() {
		global $wpdb;

		$table_name = $this->table;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` MEDIUMINT NOT NULL AUTO_INCREMENT,
			`dia` VARCHAR(24) NOT NULL,
			`hora_inicio` VARCHAR(128) NOT NULL,
			`hora_fin` VARCHAR(128) NOT NULL,
			`estado` VARCHAR(64) NOT NULL,
			`id_proyecto` BIGINT(20) UNSIGNED NOT NULL,
			`id_promotor` MEDIUMINT NOT NULL,
			`id_usuario_registrador` MEDIUMINT NOT NULL,

			`fecha_creacion` DATETIME NOT NULL,
			`fecha_modificacion` DATETIME NOT NULL,

			PRIMARY KEY (id),
			FOREIGN KEY (id_proyecto) REFERENCES wp_posts(ID),
			FOREIGN KEY (id_promotor) REFERENCES magis_promotores(id)
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		add_option('db_version', $this->db_version);
	}
}
