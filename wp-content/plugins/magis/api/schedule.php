<?php

class MagisApiSchedule extends MagisController
{
	public function __construct() {
        $this->namespace     = '/magis/v1';
        $this->resource_name = 'cronogramas-citas';

		$this->schedulesModel = new MagisSchedulesModel();

		$this->_register_routes();
    }

	private function _register_routes() {
		register_rest_route($this->namespace, '/' . $this->resource_name . '/publicar/schedule_id=(?<schedule_id>[a-zA-Z0-9-]+)',
			array(
				array(
					'methods'   => 'GET',
					'callback'  => array($this, 'publish'),
				)
        	)
		);
		register_rest_route($this->namespace, '/' . $this->resource_name . '/ocultar/schedule_id=(?P<schedule_id>[a-zA-Z0-9-]+)',
			array(
				array(
					'methods'   => 'GET',
					'callback'  => array($this, 'unpublish'),
				)
        	)
		);
	}

	function publish($request) {
		$schedule_id = $request['schedule_id'];
		$this->schedulesModel->update(
			array('estado' => 'Publicado', 'fecha_modificacion' => current_time('mysql')),
			array('id' => $schedule_id)
		);
		wp_redirect('/lista-cronogramas-citas');
	}

	function unpublish($request) {
		$schedule_id = $request['schedule_id'];
		$this->schedulesModel->update(
			array('estado' => 'No publicado', 'fecha_modificacion' => current_time('mysql')),
			array('id' => $schedule_id)
		);
		wp_redirect('/lista-cronogramas-citas');
	}
}
