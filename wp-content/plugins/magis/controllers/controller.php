<?php

class MagisController {
	function _get($key) {
		$actual_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url_parts = parse_url($actual_url);
		parse_str($url_parts['query'], $query);
		return $query[$key];
	}

	function _show_error($msg) {
		$error = new WP_Error('empty_error', __($msg, 'magis'));
		wp_die($error->get_error_message(), __('CustomForm Error', 'magis'));
	}
}
