<h1>Search Title by Word</h1>
<form action="http://localhost:8888/Week4E/index.php/searchbyword/movieSearchWord" method="get">
	<label for="title">Search by title</label>
	<input type="text" id="title" name="title">
	<br><br>
	<button type="submit">Search</button>
</form>
<br><br>
<a href="http://localhost:8888/Week4E/index.php/movies/search">Search by Genre and IMDB Rating</a>
<br><br>
<h1>Search Result</h1>
<?php if($search_results === false): ?>
	<p>No results found</p>
<?php else: ?>
	<table>
		<tr>
			<th>Title</th>
			<th>Director</th>
			<th>Genre</th>
			<th>IMDB Rating</th>
			<th>Release Year</th>
		</tr>
		<tr <?php foreach ($search_results as $detail) : ?>>
			<td><?php echo $detail['title']; ?></td>
			<td><?php echo $detail['director']; ?></td>
			<td><?php echo $detail['genre']; ?></td>
			<td><?php echo $detail['IMDB_rating']; ?></td>
			<td><?php echo $detail['release_year']; ?></td>
		</tr <?php endforeach; ?>>
	</table>
<?php endif; ?>
