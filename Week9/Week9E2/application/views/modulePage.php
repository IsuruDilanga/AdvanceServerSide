<h1>Module Details</h1>

<div id="def">
	<p id="modelname"></p>
</div>

<h1>Student Details</h1>

<div id="stu">

</div>

<script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>

<script>
	$(document).ready(function (){
		var request = $.ajax({
			url:"<?php echo base_url()?>index.php/ModuleStudent/getModuleDetails",
			method:"GET",
			datatype:"json"
		})

		request.done(function (response){
			var modules = JSON.parse(response);

			if(modules && modules.length > 0){
				var moduleDetails = "<p>";
				for (var i = 0; i < modules.length; i++){
					moduleDetails += "Module Name: " + modules[i].name;
					moduleDetails += "<br>";
				}
				moduleDetails += "</p>";
				$("#modelname").html(moduleDetails);
			} else {
				$("#modelname").html("Model not found");
			}
		});
		request.fail(function (xhr, status, error){
			console.error(xhr.responseText);
		})
	});

	$(document).ready(function (){
		var request = $.ajax({
			url: "<?php echo base_url()?>index.php/ModuleStudent/getStudentDetails",
			method: "GET",
			dataType: "json"
		});

		request.done(function (response){
			var students = response;

			if(students && students.length > 0){
				var studentDetails = "<p>";
				var prevStudentName = ""; // Variable to store previous student name
				for (var i = 0; i < students.length; i++){
					if (students[i].name !== prevStudentName) {
						studentDetails += "Student Name: " + students[i].name + "<br>";
						prevStudentName = students[i].name; // Update previous student name
					}
					studentDetails += "Modules: " + students[i].modules.join(", ") + "<br><br>";
				}
				studentDetails += "</p>";
				$("#stu").html(studentDetails);
			} else {
				$("#stu").html("Students not found");
			}
		});

		request.fail(function (xhr, status, error){
			console.error(xhr.responseText);
		});
	});


</script>
