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
		register_rest_route( $this->namespace, '/' . $this->resource_name . '/project_id=(?P<project_id>[a-zA-Z0-9-]+)',
			array(
				array(
					'methods'   => 'GET',
					'callback'  => array($this, 'schedules_for_project'),
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
		wp_redirect(home_url().'/lista-cronogramas-citas');
	}

	function unpublish($request) {
		$schedule_id = $request['schedule_id'];
		$this->schedulesModel->update(
			array('estado' => 'No publicado', 'fecha_modificacion' => current_time('mysql')),
			array('id' => $schedule_id)
		);
		wp_redirect(home_url().'/lista-cronogramas-citas');
	}

	function schedules_for_project($request) {
		$project_id = $request['project_id'];
		global $wpdb;
		$results = $wpdb->get_results("SELECT id, dia, hora_inicio, hora_fin FROM magis_cronograma_citas WHERE estado = 'Publicado' AND id_proyecto = " . $project_id);
		return $results;
	}
}
