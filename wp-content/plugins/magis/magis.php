<?php
/**
 * Plugin Name: Magis
 * Plugin URI: https://magis.com/
 * Description: Gestión de citas y usuarios para la empresa constructora MAGIS.
 * Version: 0.1.1
 * Author: Juan Carlos Labrandero
 * Author URI: https://magis.com
 * Requires at least: 4.4
 * Tested up to: 4.8
 *
 * Text Domain: magis
 * Domain Path: /i18n/languages/
 *
 * @package Magis
 * @category Core
 * @author Juan Carlos Labrandero
 */


require 'controllers/schedule.php';

class MagisMeeting
{
	public function __construct() {
		require 'api/cronograma-citas.php';

		add_action( 'rest_api_init', function () {
			$api_controller = new MAGIS_ApiCronogramaCitas();
			$api_controller->register_routes();
		});

		add_action('init', array($this, 'init'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

		add_shortcode('magis_create_meeting', array($this, 'create_meeting_form'));
		add_shortcode('magis_meeting_result', array($this, 'meeting_result_view'));

		$this->schedule = new MagisSchedule();

		/*add_shortcode('magis_schedule_index', array($this, 'schedule_index'));
		add_shortcode('magis_create_schedule', array($this, 'create_schedule'));*/
	}




	public function init() {
        if (!empty($_POST['nonce_custom_form']))  {
			if (wp_verify_nonce($_POST['nonce_custom_form'], 'magis_meeting_form')) {
                die('No estas autorizado para realizar esta acción.');
            } else {
				if (strcmp($_POST['nonce_custom_form'], 'magis_meeting_form') === 0) {
					$this->meeting_form_post();
				} else {
					die('Wrong action.');
				}
            }
        }
	}

	function enqueue_scripts() {
		wp_enqueue_style('magis-style', plugin_dir_url( __FILE__ ) . 'assets/css/magis.css', false, '1.1', 'all');
		wp_enqueue_script('magis-script', plugin_dir_url( __FILE__ ) . 'assets/js/magis.js', array(), '1.1', true);
	}


	/**************************************************************************************

	**************************************************************************************/

	function create_meeting_form($params) {
		$cities = array('Sucre', 'La Paz', 'Santa Cruz', 'Cochabamba');
		$meeting_projects = array();

		global $wpdb;
		$projects = $wpdb->get_results("SELECT id_proyecto, COUNT(*) FROM magis_cronograma_citas WHERE estado = 'publish' GROUP BY id_proyecto");

		foreach($projects as &$projref) {
			$proj = $wpdb->get_row('SELECT ID AS id, post_title AS nombre FROM wp_posts WHERE ID =' . $projref->id_proyecto);
			array_push($meeting_projects, $proj);
		}
		require 'templates/meeting-form.php';
	}

	function meeting_result_view($params) {
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
				//var_dump();
				require 'templates/meeting-result.php';
			}
		}
	}

	/**************************************************************************************

	**************************************************************************************/

	/*function schedule_index($params) {
		global $wpdb;

		return 'lista de cronogramas';
	}

	function create_schedule($params) {
		global $wpdb;

		$projects = $wpdb->get_results("SELECT ID AS id, post_title AS nombre FROM wp_posts WHERE (post_type='project') AND (post_status='publish')");
		$projectors = array();
		$days = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
		$periods = array('8:00 am', '9:00 am', '10:00 am', '11:00 am', '12:00 pm', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00');

		require 'templates/schedule-form.php';
	}*/

	/**************************************************************************************

	**************************************************************************************/

	function meeting_form_post() {
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

$MagisMeeting = new MagisMeeting();
