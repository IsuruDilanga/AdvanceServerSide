<h2>Welcome Home</h2>
<button id="btnEx">Click Me</button>

<button class="btn1">Button 1</button>
<button class="btn1">Button 2</button>


<script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>

<script>
	$(document).ready(function (){
// jquery callback function for click events on the button
		$('#btnEx').click(function () {
// open alert box to display another welcome message
			alert("Click the Click me Button!")
		});
	});
	$(document).ready(function (){
		// jquery callback function for mouseover events on the button
		$('.btn1').mouseover(function () {
			// open alert box to display another welcome message
			alert("Hover over the button!");
		});
	});
</script>
