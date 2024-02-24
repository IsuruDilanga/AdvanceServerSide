<h1>Existing To Do List</h1>
<table class="table table-striped">
	<thead>
	<tr>
		<th>Action Title</th>
		<th>Date</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($existing_action as $item) :?>
		<tr>
			<td><?php echo $item['action_title'] ?></td>
			<td><?php echo $item['date'] ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
