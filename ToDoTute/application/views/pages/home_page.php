<h1 style="text-align: center">Existing To Do List</h1>
<div class="table-container">
	<table>
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
			<tr style="background-color: <?php
			if ($item['priority_level'] == 1) {
				echo 'red';
			} elseif ($item['priority_level'] == 2) {
				echo 'yellow';
			} elseif ($item['priority_level'] == 3) {
				echo 'green';
			} else {
				echo '';
			}
			?>">
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
<h1 style="text-align: center; margin-top: 20px;" >Add the to do action</h1>
<div class="container" style="width: 50%;
							  border-radius: 8px;
							  padding: 20px;
							  box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
	<form action="<?php echo site_url('/home/addToDoItem'); ?>" method="post">
		<div class="mb-3">
			<label for="actionTitle" class="form-label">Action Title</label>
			<input type="text" class="form-control" id="actionTitle" name="action_title" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;" required>
		</div>
		<div class="mb-3">
			<label for="date" class="form-label">Date</label>
			<input type="date" class="form-control" id="date" name="date" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; " required>
		</div>
		<div class="mb-3">
			<label for="priority" class="form-label">Priority Level</label>
			<select class="form-select" id="priority" name="priority" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;" required>
				<option value="1">High</option>
				<option value="2">Medium</option>
				<option value="3">Low</option>
			</select>
		</div>
		<button type="submit" class="btn btn-primary">Add</button>
	</form>
</div>
