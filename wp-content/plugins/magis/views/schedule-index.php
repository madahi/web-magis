
<table>
  <tr>
		<?php foreach($schedules['columns'] as &$col) { ?>
			<th> <?php echo $col; ?> </th>
		<?php } ?>
  </tr>

	<?php foreach($schedules['rows'] as &$row) { ?>
		<tr class="magis-table-row">
			<td>
				<div>
					<b><?php echo $row->proyecto; ?></b>
				</div>
				<div class="magis-table-row-options">
					<a href="/editar-cronograma-cita/?schedule_id=<?php echo $row->id; ?>"><span>Editar</span></a>
				</div>
			</td>
			<td> <?php echo $row->dia; ?> </td>
			<td> <?php echo $row->periodo; ?> </td>
			<td> <?php echo $row->estado; ?> </td>
			<td> <?php echo $row->fecha_creacion; ?> </td>
	  </tr>
	<?php } ?>
</table>
