<?php
/**
 * Plugin Name: Magis
 * Plugin URI: https://magis.com/
 * Description: Gestión de citas para la empresa constructora MAGIS.
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

require 'controllers/user.php';
require 'controllers/projector.php';
require 'controllers/schedule.php';
require 'controllers/meeting.php';

require 'models/projectors.php';
require 'models/schedules.php';
require 'models/clients.php';
require 'models/meetings.php';

class Magis
{
	public function __construct() {
		add_action('init', array($this, 'init'));
		add_action('rest_api_init', array($this, 'rest_api_init'));

		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

		$this->user = new MagisUser();
		$this->projector = new MagisProjector();
		$this->schedule = new MagisSchedule();
		$this->meeting = new MagisMeeting();
	}

	public function init() {
        if (!empty($_POST['nonce_custom_form']))  {
			if (wp_verify_nonce($_POST['nonce_custom_form'], 'magis_meeting_form')) {
                die('No estas autorizado para realizar esta acción.');
            } else {
				switch($_POST['nonce_custom_form']) {
				case 'magis_user_signin':
					$this->user->signin_post($_POST);
					break;
				case 'magis_projector_create_form':
					$this->projector->create_post($_POST);
					break;
				case 'magis_schedule_create_form':
					$this->schedule->create_post($_POST);
					break;
				case 'magis_meeting_create_form':
					$this->meeting->create_post($_POST);
					break;
				default:
					die('Wrong action.');
					break;
				}
            }
        }
	}

	function rest_api_init() {
		require 'api/schedule.php';
		$api_schedule_controller = new MagisApiSchedule();

		require 'api/client.php';
		$api_client_controller = new MagisApiClient();

		require 'api/meeting.php';
		$api_meeting_controller = new MagisApiMeeting();
	}

	function install() {
		$this->projector->install();
		$this->schedule->install();
		$this->meeting->install();

		add_role('secretary_role', 'Secretario/a', array('read' => true, 'level_0' => true));
	}

	function enqueue_scripts() {
		wp_enqueue_style('magis-style', plugin_dir_url( __FILE__ ) . 'assets/css/magis.css', false, '1.1', 'all');
		wp_enqueue_script('magis-script', plugin_dir_url( __FILE__ ) . 'assets/js/magis.js', array(), '1.1', true);
	}
}

$MagisPlugin = new Magis();
register_activation_hook( __FILE__, array($MagisPlugin, 'install'));
