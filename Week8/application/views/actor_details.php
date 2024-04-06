<h2>Actor Details</h2>

<label for="inputTxt">Enter a Actor Name: </label>
<input id="inputTxt" name="inputTxt" type="text">
<button id="btnSub" type="button">Check the Details</button>

<div id="def"></div>

<script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
<script>
	$(document).ready(function(){
		$("#btnSub").click(function(){
			alert("Button was Clicked!");
			var word = $("#inputTxt").val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Actor_details_controller/getActor')?>",
				data: {inputTxt: word},
				dataType: "json",
				success: function(response){
					if(response) {
						var definition = "<p><strong>Name:</strong> " + response.name + "</p>";
						definition += "<p><strong>Age:</strong> " + response.age + "</p>";
						definition += "<p><strong>URL:</strong> <a href='" + response.url + "'>" + response.url + "</a></p>";
						definition += "<p><strong>Films:</strong> " + response.films.join(', ') + "</p>";
						$("#def").html(definition);
					} else {
						$("#def").text("Actor not found.");
					}
				},

				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}
			});
		});
	});
</script>




