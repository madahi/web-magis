<form method="post" action="">
	<input name="nonce_custom_form" value="magis_meeting_form" type="hidden"/>

	<div class="input-group">
		<input name="meeting-uci" type="text" placeholder="Cédula de Identidad" required/>
		<label class="input-label" for="meeting-uci">Cédula de Identidad</label>
		<span class="input-description">Introduzca su número de cédula de identidad</span>
	</div>

	<div class="input-group">
		<input name="meeting-uname" type="text" placeholder="Nombre completo" required/>
		<label class="input-label" for="meeting-uname">Nombre completo</label>
		<span class="input-description">Introduzca su nombre completo</span>
	</div>

	<div class="input-group">
		<input name="meeting-phone" type="text" placeholder="Teléfono celular" required/>
		<label class="input-label" for="meeting-phone">Teléfono celular</label>
		<span class="input-description">Teléfono celular de confirmación</span>
	</div>

	<div class="input-group">
		<select name="meeting-city" placeholder="Ciudad" required>
			<?php foreach($cities as &$city) { ?>
				<option> <?php echo $city; ?></option>
			<?php } ?>
		</select>
		<label class="input-label" for="meeting-city">Ciudad</label>
		<span class="input-description">Ciudad en la que se encuentra</span>
	</div>

	<div class="input-group">
		<select id="magis_meeting_project" name="meeting-project" placeholder="Proyecto" required>
			<?php foreach($meeting_projects as &$project) { ?>
				<option value="<?php echo $project->id; ?>"><?php echo $project->nombre; ?></option>
			<?php } ?>
		</select>
		<label class="input-label" for="meeting-project">Proyecto</label>
		<span class="input-description">Seleccione el proyecto que desea ver</span>
	</div>

	<div class="input-group">
		<select id="magis_meeting_date" name="meeting-date" placeholder="Día y hora de la cita" required>
		</select>
		<label class="input-label" for="meeting-date">Día y hora de la cita</label>
		<span class="input-description">Seleccione el día y la hora de la cita</span>
	</div>

	<div>
		<input type='submit' value='Crear'/>
	</div>
</form>