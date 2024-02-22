<h1>Movie Titles of <?php echo $title ?></h1>


<?php foreach ($genre_view as $detail) : ?>
	<p><?php echo $detail['title'] ?></p>
<?php endforeach; ?>

<a href="http://localhost/Week4E/index.php/genre/viewgenre">Back to Genre</a>
