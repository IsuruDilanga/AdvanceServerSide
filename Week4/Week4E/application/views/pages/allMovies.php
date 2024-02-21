<h1>All Movies</h1>
<br><br>
<table>
	<tr>
		<th>Title</th>
		<th>Director</th>
		<th>Genre</th>
		<th>IMDB Rating</th>
		<th>Release Year</th>
	</tr>
	<tr <?php foreach ($all_movies as $detail) : ?>>
		<td><?php echo $detail['title']; ?></td>
		<td><?php echo $detail['director']; ?></td>
		<td><?php echo $detail['genre']; ?></td>
		<td><?php echo $detail['IMDB_rating']; ?></td>
		<td><?php echo $detail['release_year']; ?></td>
	</tr <?php endforeach; ?>>
</table>
<br><br>
<a href="http://localhost:8888/Week4E/index.php/movies/search">Search Page</a>
