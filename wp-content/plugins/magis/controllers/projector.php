<?php

class MagisProjector extends MagisController
{
	public function __construct()
	{
		add_shortcode('magis_projector_index', array($this, 'index'));
		add_shortcode('magis_projector_create', array($this, 'create_form'));

		$this->projectorsModel = new MagisProjectorsModel();
	}

	public function install() {
		$this->projectorsModel->install();
	}

	function index() {
		$user = wp_get_current_user();
		if(in_array("secretary_role", $user->roles) || in_array("administrator", $user->roles)) {
			$projectors = $this->projectorsModel->all_prety();
			require plugin_dir_path( __FILE__ ) . '../views/projector-index.php';
		} else {
			wp_redirect(home_url());
		}
	}

	function create_form($params) {
		$user = wp_get_current_user();
		if(in_array("secretary_role", $user->roles) || in_array("administrator", $user->roles)) {
			require plugin_dir_path( __FILE__ ) . '../views/projector-create.php';
		}else{
			wp_redirect(home_url());
		}
	}

	function create_post($post) {
		$data = $this->_validate_post($post);
		
		if($data->is_valid) {
			$this->projectorsModel->insert($data->post);
			wp_redirect(home_url().'/lista-de-promotores');
		} else {
			$this->_show_error($data->validation_message);
		}
	}

	private function _validate_post($post) {
		$data = new ValidationData();

		$user = wp_get_current_user();
		if(!in_array("secretary_role", $user->roles) && !in_array("administrator", $user->roles)) {
			$data->validation_message = 'No tienes permiso para realizar esta acción.';
			return $data;
		}

		if(empty($_POST['projector-status'])) {
			$data->validation_message = 'Por favor ingrese el estado del promotor.';
			return $data;
		} else {
			$data->post['estado'] = $_POST['projector-status'];
		}

		if(empty($_POST['projector-ci'])) {
			$data->validation_message = 'Por favor ingrese CI del promotor.';
			return $data;
		} else {
			$data->post['ci'] = $_POST['projector-ci'];
		}

		if(empty($_POST['projector-name'])) {
			$data->validation_message = 'Por favor ingrese el nombre del promotor.';
			return $data;
		} else {
			$data->post['nombre'] = $_POST['projector-name'];
		}

		if(empty($_POST['projector-dir'])) {
			$data->validation_message = 'Por favor ingrese la dirección del promotor.';
			return $data;
		} else {
			$data->post['direccion'] = $_POST['projector-dir'];
		}

		if(empty($_POST['projector-telf'])) {
			$data->validation_message = 'Por favor ingrese el teléfono del promotor.';
			return $data;
		} else {
			$data->post['telefono'] = $_POST['projector-telf'];
		}

		if(empty($_POST['projectorg-ci'])) {
			$data->validation_message = 'Por favor ingrese CI del garante.';
			return $data;
		} else {
			$data->post['ci_garante'] = $_POST['projectorg-ci'];
		}

		if(empty($_POST['projectorg-name'])) {
			$data->validation_message = 'Por favor ingrese el nombre del garante.';
			return $data;
		} else {
			$data->post['nombre_garante'] = $_POST['projectorg-name'];
		}

		if(empty($_POST['projectorg-dir'])) {
			$data->validation_message = 'Por favor ingrese la dirección del garante.';
			return $data;
		} else {
			$data->post['direccion_garante'] = $_POST['projectorg-dir'];
		}

		if(empty($_POST['projectorg-telf'])) {
			$data->validation_message = 'Por favor ingrese el teléfono del garante.';
			return $data;
		} else {
			$data->post['telefono_garante'] = $_POST['projectorg-telf'];
		}

		$data->is_valid = true;
		return $data;
	}
}
