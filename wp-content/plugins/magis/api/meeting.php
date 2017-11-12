<?php

class MagisApiMeeting extends MagisController
{
	public function __construct() {
        $this->namespace     = '/magis/v1';
        $this->resource_name = 'citas';

		$this->meetingsModel = new MagisMeetingsModel();
		$this->clientsModel = new MagisClientsModel();

		$this->_register_routes();
    }

	private function _register_routes() {
		register_rest_route($this->namespace, '/' . $this->resource_name . '/buscar-de-cliente/client_ci=(?<client_ci>[a-zA-Z0-9-]+)',
			array(
				array(
					'methods'   => 'GET',
					'callback'  => array($this, 'filter_for'),
				)
        	)
		);
	}

	function filter_for($request) {
		$ci = $request['client_ci'];
		$client = $this->clientsModel->get_by_ci($ci);

		if(!empty($client)) {
			return array(
				'meetings' => $this->meetingsModel->get_for_client($client->id),
				'message' => NULL
			);
		} else {
			return array(
				'meetings' => NULL,
				'message' => 'No se encontró el cliente'
			);
		}
	}
}
