
<div class="magis-meeting-date-card">
	<h5 class="magis-meeting-date-title"><b>Ficha de programación de la cita</b></h5>
	<p class="magis-meeting-date-label"><b>CI: </b> <span><?php echo $client->ci; ?></span></p>
	<p class="magis-meeting-date-label"><b>Nombre: </b> <span><?php echo $client->nombre; ?></span></p>

	<p class="magis-meeting-date-label"><b>Proyecto: </b> <span><?php echo $project->nombre; ?></span></p>
	
	<p class="magis-meeting-date-label"><b>Fecha de la cita: </b> <span><?php echo $schedule->dia; ?></span></p>
	<p class="magis-meeting-date-label"><b>Hora: </b> <span><?php echo 'de '.$schedule->hora_inicio.' a '.$schedule->hora_fin; ?></span></p>

	<p class="magis-meeting-date-label"><b>Fecha de creación: </b> <span><?php echo $themeeting->fecha_creacion; ?></span></p>
</div><br>
<div>
	<a class="magis-button" href="<?php echo home_url().'/buscar-mis-citas'; ?>">Ver mis citas programadas</a>
</div>
