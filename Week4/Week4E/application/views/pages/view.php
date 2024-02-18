<h1>IMDB ALL Films Rating</h1>
<table>
	<tr>
		<th>Title</th>
		<th>Director</th>
		<th>Genre</th>
		<th>IMDB Rating</th>
		<th>Release Year</th>
	</tr>
	<tr <?php foreach ($films_details as $detail) : ?>>
		<td><?php echo $detail['title']; ?></td>
		<td><?php echo $detail['director']; ?></td>
		<td><?php echo $detail['genre']; ?></td>
		<td><?php echo $detail['IMDB_rating']; ?></td>
		<td><?php echo $detail['release_year']; ?></td>
	</tr <?php endforeach; ?>>
</table>
<br><br>
<h1>Comedy Film with more than 5 IMDB Rate</h1>
<table>
	<tr>
		<th>Title</th>
		<th>Director</th>
		<th>Genre</th>
		<th>IMDB Rating</th>
		<th>Release Year</th>
	</tr>
	<tr <?php foreach ($comedy_films as $detail) : ?>>
		<td><?php echo $detail['title']; ?></td>
		<td><?php echo $detail['director']; ?></td>
		<td><?php echo $detail['genre']; ?></td>
		<td><?php echo $detail['IMDB_rating']; ?></td>
		<td><?php echo $detail['release_year']; ?></td>
	</tr <?php endforeach; ?>>
</table>

