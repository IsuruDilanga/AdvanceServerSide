<h1>Existing To Do List</h1>
<div class="container">
	<table class="table table-striped">
		<thead>
		<tr>
			<th>Action Title</th>
			<th>Date</th>
			<th>
				<a href="<?php echo base_url("/home/changePriority")  ?>">Priority Level</a>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($existing_action as $item) :?>
			<tr>
				<td><?php echo $item['action_titles'] ?></td>
				<td><?php echo $item['added_date'] ?></td>
				<?php if ($item['priority_level'] == 1): ?>
					<td>High</td>
				<?php elseif ($item['priority_level'] == 2): ?>
					<td>Medium</td>
				<?php elseif ($item['priority_level'] == 3): ?>
					<td>Low</td>
				<?php else: ?>
					<td><?php echo $item['priority_level'] ?></td>
				<?php endif; ?>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

