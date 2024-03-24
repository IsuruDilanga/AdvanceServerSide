<!--<h2>Word Definition</h2>-->
<!--<form action="--><?php //echo site_url('/Word_Definition/get_definition'); ?><!--" method="post" id="wrdFrom">-->
<!--	<label for="inputTxt">Enter a word: </label>-->
<!--	<input id="inputTxt" name="inputTxt" type="text">-->
<!--	<button id="btnSub" type="submit">Check the definition</button>-->
<!--</form>-->
<!---->
<!--<div id="def">-->
<!---->
<!--</div>-->
<!---->
<!--<script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>-->


<h2>Word Definition</h2>
<form id="wrdForm">
	<label for="inputTxt">Enter a word: </label>
	<input id="inputTxt" name="inputTxt" type="text">
	<button id="btnSub" type="button">Check the definition</button>
</form>

<div id="def"></div>

<script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
<script>
	$(document).ready(function(){
		$("#btnSub").click(function(){
			var word = $("#inputTxt").val();
			$.ajax({
				url: "<?php echo site_url('/Word_Definition/get_definition'); ?>",
				type: "POST",
				data: { inputTxt: word },
				success: function(response){
					var jsonData = JSON.parse(response);
					$("#def").html(jsonData.definition);
				},
				error: function(xhr, status, error){
					console.error(xhr.responseText);
				}
			});
		});
	});
</script>


<!--<script>-->
<!--	$(document).ready(function (){-->
<!---->
<!--		$('#wrdFrom').submit(function (e)){-->
<!--			e.preventDefault()-->
<!--			var word = $('#inputTxt').val();-->
<!--			print(word);-->
<!--			$.ajax({-->
<!--				url:"../../index.php/Word_Definition/get_definition",-->
<!--				method: 'GET',-->
<!--				data:{inputTxt: word},-->
<!--				dataType:"json",-->
<!--				success:function (response){-->
<!--					$('#def').text(response);-->
<!--				}-->
<!--			})-->
<!--		}-->
<!---->
<!--		$('#btnSub').click(function (e){-->
<!--			e.preventDefault();-->
<!--			$('#def').html($('#inputTxt').val());-->
<!---->
<!--		});-->
<!---->
<!--	});-->
<!--</script>-->
