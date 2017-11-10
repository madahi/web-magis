<?php

class MagisSchedule extends MagisController
{
	public function __construct() {
		add_shortcode('magis_schedule_index', array($this, 'index'));
		add_shortcode('magis_schedule_create', array($this, 'create_form'));
		add_shortcode('magis_edit_schedule', array($this, 'edit'));

		$this->schedulesModel = new MagisSchedulesModel();
	}

	public function install() {
		$this->schedulesModel->install();
	}

	function index($params) {
		$user = wp_get_current_user();
		if(in_array("secretary_role", $user->roles)) {
			$schedules = $this->schedulesModel->all_prety();
			require plugin_dir_path( __FILE__ ) . '../views/schedule-index.php';
		}else{
			wp_redirect(home_url());
		}
	}

	function create_form($params) {
		$user = wp_get_current_user();
		if(in_array("secretary_role", $user->roles)) {
			global $wpdb;

			$projects = $wpdb->get_results("SELECT ID AS id, post_title AS nombre FROM wp_posts WHERE (post_type='project') AND (post_status='publish')");
			$projectors = $wpdb->get_results("SELECT id, ci, nombre FROM magis_promotores WHERE estado='Hábil'");
			$days = $this->schedulesModel->get_all_enabled_days();
			$periods = $this->schedulesModel->get_all_enabled_periods();

			require plugin_dir_path( __FILE__ ) . '../views/schedule-create.php';
		}else{
			wp_redirect(home_url());
		}
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

	function create_post($post) {
		$data = $this->_validate_post($post);

		if($data->is_valid) {
			$data->post['fecha_creacion'] = current_time('mysql');
			$data->post['fecha_modificacion'] = current_time('mysql');
			$data->post['estado'] = 'No publicado';

			$this->schedulesModel->insert($data->post);

			wp_redirect('/lista-cronogramas-citas');
		} else {
			$this->_show_error($data->validation_message);
		}
	}

	private function _validate_post($post) {
		$data = new ScheduleData();

		$user = wp_get_current_user();
		if(!in_array("secretary_role", $user->roles)) {
			$data->validation_message = 'No tienes permiso para realizar esta acción.';
			return $data;
		}

		if(empty($post['schedule-project'])) {
			$data->validation_message = 'Por favor ingrese un proyecto.';
			return $data;
		} else {
			$data->post['id_proyecto'] = $post['schedule-project'];
		}

		if(empty($post['schedule-day'])) {
			$data->validation_message = 'Por favor ingrese un día.';
			return $data;
		} else {
			$data->post['dia'] = $post['schedule-day'];
		}

		if(empty($post['schedule-start'])) {
			$data->validation_message = 'Por favor ingrese la hora de inicio.';
			return $data;
		} else {
			$data->post['hora_inicio'] = $post['schedule-start'];
		}

		if(empty($post['schedule-end'])) {
			$data->validation_message = 'Por favor ingrese la hora de finalización.';
			return $data;
		} else {
			$data->post['hora_fin'] = $post['schedule-end'];
		}

		if(empty($post['schedule-projector'])) {
			$data->validation_message = 'Por favor ingrese un promotor.';
			return $data;
		} else {
			$data->post['id_promotor'] = $post['schedule-projector'];
		}

		$data->is_valid = true;
		return $data;
	}
}

class ScheduleData {
	public $is_valid = true;
	public $validation_message = '';
	public $post = array();
}
