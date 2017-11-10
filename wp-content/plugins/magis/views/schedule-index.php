
<div class="magis-table-container">
	<a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
	<table class="magis-table">
		<tr>
			<?php foreach($schedules['columns'] as &$col) { ?>
				<th> <?php echo $col; ?> </th>
			<?php } ?>
		</tr>

		<?php
			if(!empty($schedules['rows'])) {
				foreach($schedules['rows'] as &$row) { ?>
					<tr class="magis-table-row">
						<td>
							<div>
								<b><?php echo $row->proyecto; ?></b>
							</div>
							<div class="magis-table-row-options">
								<a href="/editar-cronograma-cita/?schedule_id=<?php echo $row->id; ?>"><span>Editar</span></a>
								<?php
									switch($row->estado) {
									case 'No publicado':
								?>
										<a href="/wp-json/magis/v1/cronogramas-citas/publicar/schedule_id=<?php echo $row->id; ?>"><span>Publicar</span></a>
								<?php
										break;
									case 'Publicado':
								?>
										<a href="/wp-json/magis/v1/cronogramas-citas/ocultar/schedule_id=<?php echo $row->id; ?>"><span>Ocultar</span></a>
								<?php
										break;
									}
								?>
								
							</div>
						</td>
						<td> <?php echo $row->estado; ?> </td>
						<td> <?php echo $row->dia; ?> </td>
						<td> <?php echo $row->hora_inicio; ?> </td>
						<td> <?php echo $row->hora_fin; ?> </td>
						<td> <?php echo $row->nombre_promotor; ?> </td>

						<td> <?php echo $row->fecha_creacion; ?> </td>
						<td> <?php echo $row->fecha_modificacion; ?> </td>
					</tr>
				<?php }
			}
		?>
	</table>

	<?php if(empty($schedules['rows'])) { ?>
		<div><span><b>No hay datos que mostrar</b></span></div>
	<?php } ?>
</div>
