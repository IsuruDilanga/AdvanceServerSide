<div class="container">
	<h1>Add To Do List</h1>
	<form action="<?php echo site_url('/todo/addToDoItem'); ?>" method="post">
		<div class="mb-3">
			<label for="actionTitle" class="form-label">Action Title</label>
			<input type="text" class="form-control" id="actionTitle" name="action_title" required>
		</div>
		<div class="mb-3">
			<label for="date" class="form-label">Date</label>
			<input type="date" class="form-control" id="date" name="date" required>
		</div>
		<button type="submit" class="btn btn-primary">Add</button>
	</form>

	<h1>To Do List</h1>
	<table class="table table-striped">
		<thead>
		<tr>
			<th>Action Title</th>
			<th>Date</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($todo_list as $item) :?>
			<tr>
				<td><?php echo $item['action_title'] ?></td>
				<td><?php echo $item['date'] ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
