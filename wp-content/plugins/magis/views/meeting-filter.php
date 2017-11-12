
<div>
	<form method="post" action="">
		<div class="magis-projector-panel">
			<div class="input-group">
				<input id="magis-meeting-client-ci" name="meeting-client-ci" type="text" placeholder="Cédula de Identidad" required/>
				<label class="input-label" for="meeting-client-ci">Cédula de Identidad</label>
				<span class="input-description">Introduzca su número de cédula de identidad</span>
			</div>

			<div>
				<button id="magis-meeting-filter-btn" class="magis-button" type="button">Buscar</button>
				<a class="magis-button" href="/programar-cita">Programar nueva cita</a>
			</div>
		</div>
	</form>

	<div class="magis-table-container">
		<table class="magis-table">
			<thead>
				<tr>
					<th>Proyecto</th>
					<th>Estado</th>
					<th>Fecha de la cita</th>
					<th>Hora inicio</th>
					<th>Hora fin</th>
					<th>Fecha de creación</th>
				</tr>
			</thead>
			<tbody>
				<tr id="magis-client-meetings-rows" class="magis-table-row">
				</tr>
			</tbody>
		</table>
	</div>
</div>
