
<?php

class MAGIS_ApiCronogramaCitas {
	public function __construct() {
        $this->namespace     = '/magis/v1';
        $this->resource_name = 'cronograma-citas';
    }

	public function register_routes() {
        /*register_rest_route( $this->namespace, '/' . $this->resource_name, array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_items' ),
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
            ),
            // Register our schema callback.
            'schema' => array( $this, 'get_item_schema' ),
        ) );*/
        register_rest_route( $this->namespace, '/' . $this->resource_name . '/(?P<project>[a-zA-Z0-9-]+)', array(
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'cronograma_citas_proyecto' ),
            )
        ) );
    }

	function cronograma_citas_proyecto($request) {
		//$request['project'];
		return array(
			array(
				'id' => 'fw32r23',
				'dia' => 'Viernes',
				'periodo' => '8:00 - 10:00',
			),
			array(
				'id' => 'dyu78',
				'dia' => 'Viernes',
				'periodo' => '9:00 - 11:00'
			),
		);
	}
}