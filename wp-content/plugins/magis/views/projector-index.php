
<div class="magis-projector-table-container">
	<table class="magis-projector-table">
		<thead>
			<tr>
				<?php foreach($projectors['columns'] as &$col) { ?>
					<th> <?php echo $col; ?> </th>
				<?php } ?>
			</tr>
		</thead>

		<?php
		if(!empty($projectors['rows'])) {
			foreach($projectors['rows'] as &$row) { ?>
				<tr class="magis-table-row">
					<td>
						<div>
							<b><?php echo $row->ci; ?></b>
						</div>
						<div class="magis-table-row-options">
							<a href="/editar-promotor/?projector_id=<?php echo $row->id; ?>"><span>Editar</span></a>
							<a href="/eliminar-promotor/?projector_id=<?php echo $row->id; ?>"><span>Eliminar</span></a>
						</div>
					</td>

					<td> <?php echo $row->estado; ?> </td>
					<td> <?php echo $row->nombre; ?> </td>
					<td> <?php echo $row->direccion; ?> </td>
					<td> <?php echo $row->telefono; ?> </td>

					<td> <?php echo $row->ci_garante; ?> </td>
					<td> <?php echo $row->nombre_garante; ?> </td>
					<td> <?php echo $row->direccion_garante; ?> </td>
					<td> <?php echo $row->telefono_garante; ?> </td>

					<td> <?php echo $row->fecha_creacion; ?> </td>
					<td> <?php echo $row->fecha_modificacion; ?> </td>
				</tr>
		<?php
			}
		}
		?>

	</table>

	<?php if(empty($projectors['rows'])) { ?>
		<div><span><b>No hay datos que mostrar</b></span></div>
	<?php } ?>
</div>
