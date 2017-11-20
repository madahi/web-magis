
<div class="magis-table-container">
	<table class="magis-table">
		<thead>
			<tr>
				<?php foreach($meetings['columns'] as &$col) { ?>
					<th> <?php echo $col; ?> </th>
				<?php } ?>
			</tr>
		</thead>

		<?php
		if(!empty($meetings['rows'])) {
			foreach($meetings['rows'] as &$row) { ?>
				<tr class="magis-table-row">
					<td>
						<div>
							<b><?php echo $row->proyecto; ?></b>
						</div>
						<div class="magis-table-row-options">
							<?php
								switch($row->estado) {
								case 'Pendiente':
							?>
									<a href="<?php echo home_url().'/wp-json/magis/v1/citas/confirmar/meeting_id='.$row->id; ?>"><span>Confirmar</span></a>
							<?php
									break;
								case 'Confirmado':
							?>
									<a href="<?php echo home_url().'/wp-json/magis/v1/citas/cancelar/meeting_id='.$row->id; ?>"><span>Cancelar</span></a>
							<?php
									break;
								case 'Cancelado':
							?>
									<a href="<?php echo home_url().'/wp-json/magis/v1/citas/pendiente/meeting_id='.$row->id; ?>"><span>Pendiente</span></a>
							<?php
									break;
								}
							?>
						</div>
					</td>
					
					<td> <?php echo $row->estado; ?> </td>

					<td> <?php echo $row->ci_cliente; ?> </td>
					<td> <?php echo $row->nombre_cliente; ?> </td>
					<td> <?php echo $row->telefono_cliente; ?> </td>

					<td> <?php echo $row->dia; ?> </td>
					<td> <?php echo $row->hora_inicio; ?> </td>
					<td> <?php echo $row->hora_fin; ?> </td>

					<td> <?php echo $row->ci_promotor; ?> </td>
					<td> <?php echo $row->nombre_promotor; ?> </td>
					<td> <?php echo $row->telefono_promotor; ?> </td>

					<td> <?php echo $row->fecha_creacion; ?> </td>
					<td> <?php echo $row->fecha_modificacion; ?> </td>
				</tr>
		<?php
			}
		}
		?>
	</table>

	<?php if(empty($meetings['rows'])) { ?>
		<div><span><b>No hay datos que mostrar</b></span></div>
	<?php } ?>
</div>
