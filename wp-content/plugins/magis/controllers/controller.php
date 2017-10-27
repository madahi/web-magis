<?php

class MagisController {
	function _get($key) {
		$actual_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url_parts = parse_url($actual_url);
		parse_str($url_parts['query'], $query);
		return $query[$key];
	}
}
