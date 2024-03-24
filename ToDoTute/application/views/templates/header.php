<html>
	<head>
		<title>Week 5 Tutorial</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<style>
			/* Custom styles */
			body {

				background-color: #f8f9fa;
			}
			.navbar {
				background-color: lightblue;
				padding: 20px;
			}
			.navbar-nav {
				margin-left: auto;
			}

			.table-container {
				margin-top: 20px;
				margin-left: 22%;
				width: 80%
			}


			table {
				width: 70%;
				border-collapse: collapse;
			}

			thead {
				background-color: #f2f2f2;
			}

			th, td {
				padding: 8px;
				text-align: left;
				border: 1px solid #000000;
			}

			.priority-high {
				background-color: red;
			}

			.priority-medium {
				background-color: yellow;
			}

			.priority-low {
				background-color: green;
			}

		</style>
	</head>
	<body>
	<nav class="navbar navbar-expand-lg navbar-light">
		<a class="navbar-brand" href="<?php echo base_url("/login/index")?>">Todo List</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
<!--			<ul class="navbar-nav mr-auto">-->
<!--				<li class="nav-item active">-->
<!--					<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a class="nav-link" href="#">Link</a>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a class="nav-link" href="#">Another Link</a>-->
<!--				</li>-->
<!--			</ul>-->
			<form class="form-inline my-2 my-lg-0 mr-auto" action="<?php echo base_url('login/logout'); ?>">
				<button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
			</form>

		</div>
	</nav>

	<?php
	$success_message = $this->session->flashdata('success');
	$error_message = $this->session->flashdata('error');
	?>

	<?php if($success_message): ?>
		<div id="success-alert" class="alert alert-success"><?php echo $success_message; ?></div>
	<?php endif; ?>

	<?php if($error_message): ?>
		<div id="error-alert" class="alert alert-danger"><?php echo $error_message; ?></div>
	<?php endif; ?>





