<?php

class MagisApiClient extends MagisController
{
	public function __construct() {
        $this->namespace     = '/magis/v1';
        $this->resource_name = 'clientes';

		$this->clientsModel = new MagisClientsModel();

		$this->_register_routes();
    }

	private function _register_routes() {
		register_rest_route($this->namespace, '/' . $this->resource_name . '/ver/client_ci=(?<client_ci>[a-zA-Z0-9-]+)',
			array(
				array(
					'methods'   => 'GET',
					'callback'  => array($this, 'show'),
				)
        	)
		);
	}

	function show($request) {
		$ci = $request['client_ci'];
		return array(
			'reqci' => $ci,
			'client' => $this->clientsModel->get_by_ci($ci),
			'ext' => 'test response'
		);
	}
}
