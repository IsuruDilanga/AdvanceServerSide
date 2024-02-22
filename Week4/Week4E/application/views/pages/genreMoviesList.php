<h1>Genre Movie</h1>
<div>
	<?php foreach ($genre_details as $detail) : ?>
		<p><a href="<?php echo ('http://localhost/Week4E/index.php/pages/'.$detail['genre']); ?>"><?php echo $detail['genre']; ?></a></p>
	<?php endforeach; ?>
</div>

<a href="http://localhost/Week4E/index.php/films/getAllFilmDetails">Back All Films Rating</a>
