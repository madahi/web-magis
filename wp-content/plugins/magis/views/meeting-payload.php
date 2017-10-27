
<div class="magis-meeting-date-card">
	<h5 class="magis-meeting-date-title"><b>Ficha de programación de la cita</b></h5>
	<p class="magis-meeting-date-label"><b>CI: </b> <span><?php echo $client->ci; ?></span></p>
	<p class="magis-meeting-date-label"><b>Nombre: </b> <span><?php echo $client->nombre; ?></span></p>

	<p class="magis-meeting-date-label"><b>Proyecto: </b> <span><?php echo $project->nombre; ?></span></p>
	
	<p class="magis-meeting-date-label"><b>Día: </b> <span><?php echo $schedule->dia; ?></span></p>
	<p class="magis-meeting-date-label"><b>Hora: </b> <span><?php echo $schedule->periodo; ?></span></p>
</div>
