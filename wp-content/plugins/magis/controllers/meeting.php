<?php

class MagisMeeting extends MagisController
{
	public function __construct() {
		add_shortcode('magis_meeting_create', array($this, 'create_form'));
		add_shortcode('magis_meeting_payload', array($this, 'payload'));

		$this->clientsModel = new MagisClientsModel();
		$this->meetingsModel = new MagisMeetingsModel();
	}

	public function install() {
		$this->clientsModel->install();
		$this->meetingsModel->install();
	}

	function create_form($params) {
		$cities = array('Sucre', 'La Paz', 'Santa Cruz', 'Cochabamba', 'Potosi', 'Oruro', 'Otro');
		$meeting_projects = array();

		global $wpdb;
		$projects = $wpdb->get_results("SELECT id_proyecto, COUNT(*) FROM magis_cronograma_citas WHERE estado = 'Publicado' GROUP BY id_proyecto");

		foreach($projects as &$projref) {
			$proj = $wpdb->get_row('SELECT ID AS id, post_title AS nombre FROM wp_posts WHERE ID =' . $projref->id_proyecto);
			array_push($meeting_projects, $proj);
		}
		require plugin_dir_path( __FILE__ ) . '../views/meeting-create.php';
	}

	function payload($params) {
		$meeting_hash_id = $this->_get('meeting_hash_id');
		if(empty($meeting_hash_id)) {
			$magis_error_msg = 'No se encontró el identificador para la cita programada.';
			require plugin_dir_path( __FILE__ ) . '../views/error.php';
		} else {
			global $wpdb;
			$themeeting = $wpdb->get_row("SELECT * FROM magis_citas WHERE hash = '" . $meeting_hash_id . "'");
			if (empty($themeeting)) {
				$magis_error_msg = 'No se encontró la cita programada.';
				require plugin_dir_path( __FILE__ ) . '../views/error.php';
			} else {
				$client = $wpdb->get_row('SELECT * FROM magis_clientes WHERE id =' . $themeeting->id_cliente);

				$schedule = $wpdb->get_row('SELECT * FROM magis_cronograma_citas WHERE id =' . $themeeting->id_cronograma);
				$project = $wpdb->get_row('SELECT post_title AS nombre FROM wp_posts WHERE ID =' . $schedule->id_proyecto);

				require plugin_dir_path( __FILE__ ) . '../views/meeting-payload.php';
			}
		}
	}

	public function create_post($post) {
		$client_data = $this->_validate_client_post($post);
		if($client_data->is_valid) {
			$client = $this->clientsModel->insert_or_update($client_data->post);
			$data = $this->_validate_post($post);
			if($data->is_valid) {
				$data->post['id_cliente'] = $client->id;
				$inserted = $this->meetingsModel->insert($data->post);
				wp_redirect('/programacion-de-cita?meeting_hash_id=' . $inserted->hash);
			} else {
				$this->_show_error($data->validation_message);
			}
		} else {
			$this->_show_error($client_data->validation_message);
		}
	}

	private function _validate_client_post($post) {
		$data = new ValidationData();

		if(empty($post['meeting-uci'])) {
			$data->validation_message = 'Por favor ingrese su CI.';
			return $data;
		} else {
			$data->post['ci'] = $post['meeting-uci'];
		}

		if(empty($post['meeting-uname'])) {
			$data->validation_message = 'Por favor ingrese su nombre.';
			return $data;
		} else {
			$data->post['nombre'] = $post['meeting-uname'];
		}

		if(empty($post['meeting-phone'])) {
			$data->validation_message = 'Por favor ingrese su teléfono.';
			return $data;
		} else {
			$data->post['telefono'] = $post['meeting-phone'];
		}

		if(empty($post['meeting-city'])) {
			$data->validation_message = 'Por favor ingrese la ciudad.';
			return $data;
		} else {
			$data->post['ciudad'] = $post['meeting-city'];
		}

		$data->is_valid = true;
		return $data;
	}

	private function _validate_post($post) {
		$data = new ValidationData();

		if(empty($post['meeting-project'])) {
			$data->validation_message = 'Por favor ingrese el ID del proyecto.';
			return $data;
		}

		if(empty($post['meeting-schedule'])) {
			$data->validation_message = 'Por favor ingrese el ID del cronograma.';
			return $data;
		} else {
			$data->post['id_cronograma'] = $post['meeting-schedule'];
		}

		$data->is_valid = true;
		return $data;
	}
}
