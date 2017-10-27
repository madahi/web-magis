<?php

class MagisSchedule extends MagisController
{
	public function __construct() {
		add_shortcode('magis_schedule_index', array($this, 'index'));
		add_shortcode('magis_create_schedule', array($this, 'create'));
		add_shortcode('magis_edit_schedule', array($this, 'edit'));

		$this->schedulesModel = new MagisSchedulesModel();
	}

	function index($params) {
		$schedules = $this->schedulesModel->all_prety();
		require plugin_dir_path( __FILE__ ) . '../views/schedule-index.php';
	}

	function create($params) {
		global $wpdb;

		$projects = $wpdb->get_results("SELECT ID AS id, post_title AS nombre FROM wp_posts WHERE (post_type='project') AND (post_status='publish')");
		$projectors = array();
		$days = $this->schedulesModel->get_all_enabled_days();
		$periods = $this->schedulesModel->get_all_enabled_periods();

		require plugin_dir_path( __FILE__ ) . '../views/schedule-create.php';
	}

	function edit() {
		$schedule_id = $this->_get('schedule_id');
		if (empty($schedule_id)) {
			$magis_error_msg = 'No se encontró el identificador para el cronograma de cita.';
			require plugin_dir_path( __FILE__ ) . '../views/error.php';
		} else {
			$days = $this->schedulesModel->get_all_enabled_days();
			$periods = $this->schedulesModel->get_all_enabled_periods();
			require plugin_dir_path( __FILE__ ) . '../views/schedule-create.php';
		}
	}
}
