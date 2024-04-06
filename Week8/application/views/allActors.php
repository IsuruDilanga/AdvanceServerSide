<h1> All Actors </h1>

<div id="acts">

</div>

<div id="def"></div>

<script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>

<script>
	$(document).ready(function(){
		// AJAX request to fetch all actors and populate the list
		$.ajax({
			url: "<?php echo site_url('/Actor_details_controller/getAllActors'); ?>",
			type: "GET",
			dataType: "json",
		})
			.done(function (response){
				if (response && response.length > 0){
					var actorsHtml = "";
					response.forEach(function(actor) {
						actorsHtml += "<p> Actor: <a class='actor-link' data-id='" + actor.id + "' href='#'>" + actor.name + "</a></p>";
					});
					$("#acts").html(actorsHtml);
				} else {
					$("#acts").text("No actors found.");
				}
			})
			.fail(function (xhr, status, error){
				console.error(xhr.responseText);
			});

		// Event handler for clicking on actor links
		$(document).on("click", ".actor-link", function(event){
			event.preventDefault();
			var actorId = $(this).data("id");

			// AJAX request to fetch details of the specific actor
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Actor_details_controller/actor')?>",
				data: {id: actorId},
				dataType: "json",
			})
				.done(function (response){
					console.log(response);
					if(response){
						var definition = "<p><strong>Name:</strong> " + response.name + "</p>";
						definition += "<p><strong>Age:</strong> " + response.age + "</p>";
						definition += "<img src='" + response.url + "' alt='actor image' style='width: 250px; height: 300px'>";
						console.log(response.url);
						definition += "<p><strong>Films:</strong></p>";
						definition += "<ul>";
						if (response.films && response.films.length > 0) {
							for(var i = 0; i < Math.min(3, response.films.length); i++) {
								definition += "<li>" + response.films[i] + "</li>";
							}
						} else {
							definition += "<li>No films found</li>";
						}
						definition += "</ul>";
						$("#def").html(definition); // Display response content in #def element
					} else {
						$("#def").text("Actor not found.");
					}
				})
				.fail(function (xhr, status, error){
					console.error(xhr.responseText);
				});
		});
	});
</script>

