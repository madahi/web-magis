<?php

class MagisMeeting
{
	public function __construct() {
		add_shortcode('magis_create_meeting', array($this, 'create'));
		add_shortcode('magis_meeting_result', array($this, 'payload'));
	}

	function create($params) {
		$cities = array('Sucre', 'La Paz', 'Santa Cruz', 'Cochabamba');
		$meeting_projects = array();

		global $wpdb;
		$projects = $wpdb->get_results("SELECT id_proyecto, COUNT(*) FROM magis_cronograma_citas WHERE estado = 'publish' GROUP BY id_proyecto");

		foreach($projects as &$projref) {
			$proj = $wpdb->get_row('SELECT ID AS id, post_title AS nombre FROM wp_posts WHERE ID =' . $projref->id_proyecto);
			array_push($meeting_projects, $proj);
		}
		require plugin_dir_path( __FILE__ ) . '../templates/meeting-create.php';
	}

	function payload($params) {
		$meeting_hash_id = $this->_get('meeting_hash_id');
		if (empty($meeting_hash_id)) {
			$magis_error_msg = 'No se encontró el identificador para la cita programada.';
			require 'templates/error.php';
		} else {
			global $wpdb;
			$themeeting = $wpdb->get_row("SELECT * FROM magis_citas WHERE hash = '" . $meeting_hash_id . "'");
			if (empty($themeeting)) {
				$magis_error_msg = 'No se encontró la cita programada.';
				require 'templates/error.php';
			} else {
				$client = $wpdb->get_row('SELECT * FROM magis_clientes WHERE id =' . $themeeting->id_cliente);

				$schedule = $wpdb->get_row('SELECT * FROM magis_cronograma_citas WHERE id =' . $themeeting->id_cronograma);
				$project = $wpdb->get_row('SELECT * FROM magis_proyecto WHERE id =' . $schedule->id_proyecto);

				require plugin_dir_path( __FILE__ ) . '../templates/meeting-payload.php';
			}
		}
	}



	public function create_post() {
		if(empty($_POST['meeting-uci'])) {
			$this->show_error('Por favor ingrese su CI.');
		}
		if(empty($_POST['meeting-uname'])) {
			$this->show_error('Por favor ingrese su nombre.');
		}
		if(empty($_POST['meeting-phone'])) {
			$this->show_error('Por favor ingrese su teléfono.');
		}
		if(empty($_POST['meeting-city'])) {
			$this->show_error('Por favor ingrese la ciudad.');
		}
		if(empty($_POST['meeting-date'])) {
			$this->show_error('Por favor ingrese el ID del cronograma.');
		}
		else {
			global $wpdb;
			$client = $wpdb->get_row('SELECT * FROM magis_clientes WHERE ci =' . $_POST['meeting-uci']);
			if (empty($client)) {
				$wpdb->insert('magis_clientes',
					array(
						'ci' => $_POST['meeting-uci'],
						'nombre' => $_POST['meeting-uname'],
						'telefono' => $_POST['meeting-phone'],
						'ciudad' => $_POST['meeting-city'],
						'fecha_creacion' => current_time('mysql'),
						'fecha_modificacion' => current_time('mysql'),
						)
					);
				$client = $wpdb->get_row('SELECT * FROM magis_clientes WHERE ci =' . $_POST['meeting-uci']);
			} else {

			}

			$schedule = $wpdb->get_row('SELECT * FROM magis_cronograma_citas WHERE id =' . $_POST['meeting-date']);

			$wpdb->insert('magis_citas',
				array(
					'hash' => $this->randHash(),
					'id_cronograma' => $schedule->id,
					'id_cliente' => $client->id,
					'estado' => 1,
					'fecha_creacion' => current_time('mysql')
					)
				);

			$inserted = $wpdb->get_row('SELECT * FROM magis_citas WHERE id =' . $wpdb->insert_id);

			wp_redirect('/programacion-de-cita?meeting_hash_id=' . $inserted->hash);
			exit;
		}
	}


	function show_error($msg) {
		$error = new WP_Error('empty_error', __($msg, 'magis'));
		wp_die($error->get_error_message(), __('CustomForm Error', 'magis'));
	}

	function _get($key) {
		$actual_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url_parts = parse_url($actual_url);
		parse_str($url_parts['query'], $query);
		return $query[$key];
	}

	function randHash($len=32) {
		return substr(md5(openssl_random_pseudo_bytes(20)),-$len);
	}
}
