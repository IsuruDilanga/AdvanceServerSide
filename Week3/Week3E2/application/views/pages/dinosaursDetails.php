<h2>Dinosaurs Details</h2>
<table>
	<tr>
		<th>Name</th>
		<th>Period</th>
		<th>Land Animals</th>
		<th>Marine Animals</th>
		<th>Avian Animals</th>
		<th>Plant ife</th>
	</tr>
	<tr <?php foreach ($dinosaurs_details as $detail) :?>>
		<td><a href="<?php echo ('http://localhost:8888/Week3E2/index.php/pages/'.$detail['name']); ?>"> <?php echo $detail['name']; ?></a></td>
		<td><?php echo $detail['period']; ?></td>
		<td><?php echo $detail['land_animals']; ?></td>
		<td><?php echo $detail['marine_animals']; ?></td>
		<td><?php echo $detail['avian_animals']; ?></td>
		<td><?php echo $detail['plant_life']; ?></td>
	</tr <?php endforeach; ?>>
</table>

