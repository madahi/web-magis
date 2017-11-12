
<div>
	<div class="magis-user-panel">
		<h3>Bienvenido</h3>
		<p>Perfil de usuario para la empresa magis</p>
	</div>

	<div class="magis-user-panel">
		<h5>Datos de usuario</h5>
		<h6>Nombre: <?php echo $user->data->display_name; ?></h6>
		<h6>Email: <?php echo $user->data->user_email; ?></h6>
		<h6>Usuario: <?php echo $user->data->user_login; ?></h6>
	</div>

	<div class="magis-user-panel">
		<h5>Menú de opciones</h5>
		<div><a href="/lista-de-promotores">Promotores</a></div>
		<div><a href="/lista-cronogramas-citas">Cronogramas de cita</a></div>
		<div><a href="/lista-citas-programadas">Citas Programadas</a></div>
		<div><a href="<?php echo wp_logout_url('/iniciar-sesion'); ?>">Cerrar sesión</a></div>
	</div>
</div>
