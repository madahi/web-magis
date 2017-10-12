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
		<label class="input-label" for="meeting-day">Día de la visita</label>
		<ul>
			<?php foreach($meetin_days as &$day) { ?>
				<li>
					<input type="radio" name="meeting-day" value="<?php echo $day ?>" checked/>
					<label class="radio-label" for="meeting-day"><?php echo $day ?></label>
				</li>
			<?php } ?>
		</ul>
		<span class="input-description">Seleccione el día de la visita</span>
	</div>

	<div class="input-group">
		<select name="meeting-time" placeholder="Hora de la cita" required>
			<?php foreach($meeting_times as &$time) { ?>
				<option> <?php echo $time; ?></option>
			<?php } ?>
		</select>
		<label class="input-label" for="meeting-time">Hora de la cita</label>
		<span class="input-description">Seleccione la hora de la cita</span>
	</div>

	<div class="input-group">
		<select name="meeting-project" placeholder="Proyecto" required>
			<?php foreach($meeting_projects as &$project) { ?>
				<option> <?php echo $project; ?></option>
			<?php } ?>
		</select>
		<label class="input-label" for="meeting-project">Proyecto</label>
		<span class="input-description">Seleccione el proyecto que desea ver</span>
	</div>

	<input type='submit' value='Crear'/>
</form>