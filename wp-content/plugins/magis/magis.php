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


class MagisMeeting
{
	public function __construct()
	{
		add_action('init', array($this, 'init'));
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));

		add_shortcode('magis_create_meeting', array($this, 'create_meeting_form'));
		add_shortcode('magis_meeting_result', array($this, 'meeting_result_view'));
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

	function wp_enqueue_scripts() {
		/*wp_register_style( 'magis-styles',  plugin_dir_url( __FILE__ ) . 'assets/css/magis.css' );
		wp_enqueue_style( 'magis-styles' );*/

		wp_enqueue_style('magis', plugin_dir_url( __FILE__ ) . 'assets/css/magis.css', false, '1.1', 'all');
	}




	function create_meeting_form($params) {
		$cities = array('Sucre', 'La Paz', 'Santa Cruz');
		$meetin_days = array('Jueves','Viernes', 'Sábado');
		$meeting_times = array('8:00 am - 10:00 am', '10:00 am - 12:00 pm');
		$meeting_projects = array('Departamentos Royal', 'Casa House');

		require 'templates/meeting-form.php';
	}

	function meeting_result_view() {
		require 'templates/meeting-result.php';
	}




	function meeting_form_post() {
		echo 'meeting_form_post ';
		$error = null;
		if (empty($_POST['meeting-uci']))
		{
			$error = new WP_Error('empty_error', __('Por favor ingrese su CI.', 'tahiryasin'));
			wp_die($error->get_error_message(), __('CustomForm Error', 'tahiryasin'));
			echo 'NO CI';
		}
		if (empty($_POST['meeting-uname']))
		{
			$error = new WP_Error('empty_error', __('Por favor ingrese su nombre.', 'tahiryasin'));
			wp_die($error->get_error_message(), __('CustomForm Error', 'tahiryasin'));
			echo 'NO NAME';
		}
		if (empty($_POST['meeting-phone']))
		{
			$error = new WP_Error('empty_error', __('Por favor ingrese su teléfono.', 'tahiryasin'));
			wp_die($error->get_error_message(), __('CustomForm Error', 'tahiryasin'));
			echo 'NO PHONE';
		}
		if (empty($_POST['meeting-city']))
		{
			$error = new WP_Error('empty_error', __('Por favor ingrese la ciudad.', 'tahiryasin'));
			wp_die($error->get_error_message(), __('CustomForm Error', 'tahiryasin'));
			echo 'NO CITY';
		}
		else
		{
			global $wpdb;
			$wpdb->insert(
				'magis_clientes',
				array(
					'ci' => $_POST['meeting-uci'],
					'nombre' => $_POST['meeting-uname'],
					'telefono' => $_POST['meeting-phone'],
					'ciudad' => $_POST['meeting-city'],
					'fecha_creacion' => current_time('mysql'),
					)
				);

			$meeting_hash_id = 'hash';

			wp_redirect('/programacion-de-cita/?id=' . $meeting_hash_id);
			exit;
		}
	}
}

$MagisMeeting = new MagisMeeting();
