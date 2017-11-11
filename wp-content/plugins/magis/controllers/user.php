<?php

class MagisUser extends MagisController
{
	public function __construct()
	{
		add_shortcode('magis_user_signin', array($this, 'signin'));
		add_shortcode('magis_user_profile', array($this, 'profile'));

		$this->projectorsModel = new MagisProjectorsModel();
	}

	function signin() {
		if(is_user_logged_in()){
			wp_redirect('/perfil-usuario');
		} else {
			require plugin_dir_path( __FILE__ ) . '../views/user-signin.php';
		}
	}

	function profile() {
		if(is_user_logged_in()){
			$user = wp_get_current_user();

			/*
			object(stdClass)#1728 (10) {
				["ID"]=> string(1) "6"
				["user_login"]=> string(5) "juanp"
				["user_pass"]=> string(34) "$P$BV4gAGxkYyP792gLF0nzJVheae20zf."
				["user_nicename"]=> string(5) "juanp"
				["user_email"]=> string(11) "jp@mail.com"
				["user_url"]=> string(0) ""
				["user_registered"]=> string(19) "2017-11-10 21:18:19"
				["user_activation_key"]=> string(0) ""
				["user_status"]=> string(1) "0"
				["display_name"]=> string(10) "Juan Perez" }
			*/
			require plugin_dir_path( __FILE__ ) . '../views/user-profile.php';
		} else {
			wp_redirect('/iniciar-sesion');
		}
	}

	public function signin_post($post) {
		$data = $this->_validate_post($post);
		if($data->is_valid) {
			$data->post['remember'] = true;
			$user = wp_signon($data->post, false);
			if(is_wp_error($user)) {
				$this->_show_error($user->get_error_message());
			} else {
				wp_redirect('/perfil-de-usuario');
			}
		} else {
			$this->_show_error($data->validation_message);
		}
	}

	private function _validate_post($post) {
		$data = new UserData();

		if(empty($post['user-name'])) {
			$data->validation_message = 'Por favor ingrese el nombre de usuario.';
			return $data;
		} else {
			$data->post['user_login'] = $post['user-name'];
		}

		if(empty($post['user-pwd'])) {
			$data->validation_message = 'Por favor ingrese su contraseña.';
			return $data;
		} else {
			$data->post['user_password'] = $post['user-pwd'];
		}

		$data->is_valid = true;
		return $data;
	}
}

class UserData {
	public $is_valid = false;
	public $validation_message = '';
	public $post = array();
}
