<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h1>Film Search</h1>

<label for="filmName">Enter Film Name: </label>
<input id="filmName" name="filmName" type="text">
<button id="searchFilm" type="button">Search Film</button>

<div id="def">
	<!--	<img src="../../assets/Emma_Stone.jpg">-->
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>

<script>
	$(document).ready(function (){
		$("#searchFilm").click(function (){
			var film = $("#filmName").val();

			$.ajax({
				type:"GET",
				url:"http://www.omdbapi.com/?t="+film+"&apikey=5914e097",
				dataType:"json"
			})
			.done(function (response){
				if(response){
					var filmDetails = "<p><strong>Title:</strong> " + response.Title + "</p>";
					filmDetails += "<img src='"+response.Poster+"' alt='FilmImage' style='width: 250px; height: 300px'>"
					$("#def").html(filmDetails);
				}else {
					$("#def").text("Film not found.");
				}
			})
			.fail(function (xhr, status, error){
				console.error(xhr.responseText);
			})
		});
	});
</script>
