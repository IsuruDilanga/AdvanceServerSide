<h1>Movie Search</h1>
<form action="http://localhost/Week4E/index.php/movies/search" method="get">
	<label for="genre">Search by Genre:</label>
	<select id="genre" name="genre">
		<option value="action">Action</option>
		<option value="comedy">Comedy</option>
		<option value="drama">Drama</option>
		<option value="horror">Horror</option>
	</select>
	<br><br>
	<label for="imdb_rating">Search by IMDb Rating:</label>
	<select id="imdb_rating" name="imdb_rating">
		<option value="9">9+</option>
		<option value="8">8+</option>
		<option value="7">7+</option>
		<option value="6">6+</option>
		<option value="5">5+</option>
	</select>
	<br><br>
	<button type="submit">Search</button>
</form>

<h1>Search Result</h1>
<?php if($search_results === false) { ?>
	<p>No results found</p>
<?php } else { ?>
	<table>
		<tr>
			<th>Title</th>
			<th>Director</th>
			<th>Genre</th>
			<th>IMDB Rating</th>
			<th>Release Year</th>
		</tr>
		<?php foreach ($search_results as $detail) : ?>
			<tr>
				<td><?php echo $detail['title']; ?></td>
				<td><?php echo $detail['director']; ?></td>
				<td><?php echo $detail['genre']; ?></td>
				<td><?php echo $detail['IMDB_rating']; ?></td>
				<td><?php echo $detail['release_year']; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php } ?>

<br><br>
<a href="http://localhost/Week4E/index.php/movies/allmovies">All Movie Details</a>

