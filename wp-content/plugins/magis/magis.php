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


require 'controllers/controller.php';
require 'controllers/meeting.php';
require 'controllers/schedule.php';
require 'controllers/projector.php';

require 'models/schedules.php';

class Magis
{
	public function __construct() {
		require 'api/cronograma-citas.php';

		add_action( 'rest_api_init', function () {
			$api_controller = new MAGIS_ApiCronogramaCitas();
			$api_controller->register_routes();
		});

		add_action('init', array($this, 'init'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

		$this->meeting = new MagisMeeting();
		$this->schedule = new MagisSchedule();
		$this->projector = new MagisProjector();
	}

	public function init() {
        if (!empty($_POST['nonce_custom_form']))  {
			if (wp_verify_nonce($_POST['nonce_custom_form'], 'magis_meeting_form')) {
                die('No estas autorizado para realizar esta acción.');
            } else {
				/*if (strcmp($_POST['nonce_custom_form'], 'magis_meeting_form') === 0) {
					//$this->meeting_form_post();
					$this->meeting->create_post();
				} else {
					die('Wrong action.');
				}*/

				switch($_POST['nonce_custom_form']) {
				case 'magis_meeting_create_form':
					$this->meeting->create_post();
					break;
				case 'magis_projector_create_form':
					$this->projector->create_post();
					break;
				default:
					die('Wrong action.');
					break;
				}
            }
        }
	}

	function enqueue_scripts() {
		wp_enqueue_style('magis-style', plugin_dir_url( __FILE__ ) . 'assets/css/magis.css', false, '1.1', 'all');
		wp_enqueue_script('magis-script', plugin_dir_url( __FILE__ ) . 'assets/js/magis.js', array(), '1.1', true);
	}
}

$MagisPlugin = new Magis();
