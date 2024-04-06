<h2>Welcome Home</h2>
<button id="btnEx">Click Me</button>

<button class="btn1">Button 1</button>
<button class="btn1">Button 2</button>

<br></br>

<form>
	<input type="text" id="txtfield">
	<button type="submit" id="submitBtn">Submit</button>
</form>

<div id="divfield"></div>

<button id="clearbtn">Clear Div</button>

<script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>

<script>
	$(document).ready(function (){
		$('#btnEx').click(function () {
			alert("Click the Click me Button!");
		});

		$('.btn1').mouseover(function () {
			alert("Hover over the button!");
		});

		$('#submitBtn').click(function (e){
			e.preventDefault();
			$('#divfield').html($('#txtfield').val());
		});

		$('#clearbtn').click(function (e) {
			e.preventDefault();
			$('#divfield').html('');
		});
	});
</script>
