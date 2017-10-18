<?php

class MagisSchedule
{
	public function __construct() {
		add_shortcode('magis_schedule_index', array($this, 'index'));
		add_shortcode('magis_create_schedule', array($this, 'create'));
	}

	function index($params) {
		global $wpdb;

		require plugin_dir_path( __FILE__ ) . '../templates/schedule-index.php';
	}

	function create($params) {
		global $wpdb;

		$projects = $wpdb->get_results("SELECT ID AS id, post_title AS nombre FROM wp_posts WHERE (post_type='project') AND (post_status='publish')");
		$projectors = array();
		$days = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
		$periods = array('8:00 am', '9:00 am', '10:00 am', '11:00 am', '12:00 pm', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00');

		require plugin_dir_path( __FILE__ ) . '../templates/schedule-create.php';
	}
}
