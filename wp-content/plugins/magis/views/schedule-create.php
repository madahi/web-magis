<form method="post" action="">
	<input name="nonce_custom_form" value="magis_schedule_create_form" type="hidden"/>


	<div class="input-group">
		<select id="magis_schedule_project" name="schedule-project" placeholder="Proyecto" required>
			<?php foreach($projects as &$project) { ?>
				<option value="<?php echo $project->id; ?>"><?php echo $project->nombre; ?></option>
			<?php } ?>
		</select>
		<label class="input-label" for="schedule-project">Proyecto</label>
		<span class="input-description">Seleccione un proyecto</span>
	</div>

	<div class="input-group">
		<!--<select name="schedule-day" placeholder="Seleccione el día" required>
			<?php foreach($days as &$day) { ?>
				<option> <?php echo $day; ?></option>
			<?php } ?>
		</select>-->
		<input name="schedule-day" type="date" placeholder="Seleccione el día" required/>
		<label class="input-label" for="schedule-day">Seleccione el día</label>
		<span class="input-description">Seleccione el día de la cita</span>
	</div>

	<div class="input-group">
		<select name="schedule-start" placeholder="Hora inicio" required>
			<?php foreach($periods as &$period) { ?>
				<option> <?php echo $period; ?></option>
			<?php } ?>
		</select>
		<label class="input-label" for="schedule-start">Seleccione la hora de inicio</label>
		<span class="input-description">Seleccione la hora de inicio</span>
	</div>

	<div class="input-group">
		<select name="schedule-end" placeholder="Hora final" required>
			<?php foreach($periods as &$period) { ?>
				<option> <?php echo $period; ?></option>
			<?php } ?>
		</select>
		<label class="input-label" for="schedule-end">Seleccione la hora de finalización</label>
		<span class="input-description">Seleccione la hora de finalización</span>
	</div>

	<div class="input-group">
		<select name="schedule-projector" placeholder="Promotor" required>
			<?php foreach($projectors as &$projector) { ?>
				<option value="<?php echo $projector->id; ?>"> <?php echo $projector->nombre . ' - ' . $projector->ci; ?></option>
			<?php } ?>
		</select>
		<label class="input-label" for="schedule-projector">Seleccione el promotor</label>
		<span class="input-description">Seleccione el promotor</span>
	</div>

	<div>
		<input type='submit' value='Programar'/>
	</div>
</form>
