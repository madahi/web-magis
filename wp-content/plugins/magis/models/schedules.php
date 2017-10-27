<?php

class MagisSchedulesModel
{
	public function __construct() {
		$this->table = 'magis_cronograma_citas';
	}

	public function all_prety() {
		global $wpdb;
		return array(
			'columns'=>array('Proyecto', 'Día', 'Hora', 'Estado', 'Fecha de Creación'),

			'rows'=>$wpdb->get_results(
				"SELECT mcs.id AS id, wpp.post_title AS proyecto, mcs.dia AS dia, mcs.periodo AS periodo, mcs.estado AS estado, mcs.fecha_creacion AS fecha_creacion " .
				"FROM " . $this->table . " AS mcs INNER JOIN wp_posts AS wpp ON mcs.id_proyecto = wpp.ID " .
				"ORDER BY mcs.fecha_creacion DESC")
		);
	}

	public function get_all_enabled_days() {
		return array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
	}

	public function get_all_enabled_periods() {
		return array('8:00 am', '9:00 am', '10:00 am', '11:00 am', '12:00 pm', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00');
	}
}
