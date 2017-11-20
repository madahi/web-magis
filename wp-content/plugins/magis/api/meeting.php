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

		register_rest_route($this->namespace, '/' . $this->resource_name . '/confirmar/meeting_id=(?P<meeting_id>[a-zA-Z0-9-]+)',
			array(
				array(
					'methods'   => 'GET',
					'callback'  => array($this, 'status_confirm'),
				)
        	)
		);
		register_rest_route($this->namespace, '/' . $this->resource_name . '/cancelar/meeting_id=(?P<meeting_id>[a-zA-Z0-9-]+)',
			array(
				array(
					'methods'   => 'GET',
					'callback'  => array($this, 'status_cancel'),
				)
        	)
		);
		register_rest_route($this->namespace, '/' . $this->resource_name . '/pendiente/meeting_id=(?P<meeting_id>[a-zA-Z0-9-]+)',
			array(
				array(
					'methods'   => 'GET',
					'callback'  => array($this, 'status_pending'),
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


	function status_confirm($request) {
		$meeting_id = $request['meeting_id'];
		$this->meetingsModel->update(
			array('estado' => 'Confirmado', 'fecha_modificacion' => current_time('mysql')),
			array('id' => $meeting_id)
		);
		wp_redirect(home_url().'/lista-citas-programadas');
	}

	function status_cancel($request) {
		$meeting_id = $request['meeting_id'];
		$this->meetingsModel->update(
			array('estado' => 'Cancelado', 'fecha_modificacion' => current_time('mysql')),
			array('id' => $meeting_id)
		);
		wp_redirect(home_url().'/lista-citas-programadas');
	}

	function status_pending($request) {
		$meeting_id = $request['meeting_id'];
		$this->meetingsModel->update(
			array('estado' => 'Pendiente', 'fecha_modificacion' => current_time('mysql')),
			array('id' => $meeting_id)
		);
		wp_redirect(home_url().'/lista-citas-programadas');
	}
}
