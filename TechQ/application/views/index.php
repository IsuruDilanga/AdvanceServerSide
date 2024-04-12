<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>TechQ</title>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/plugins/ssi-model/js/ssi-model.js" type="text/javascript">/</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"  type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"  type="text/javascript"></script>

	<script src="../../assets/js/app.js" type="text/javascript"></script>
	<script src="../../assets/js/routers/approuter.js" type="text/javascript"></script>
	<script src="../../assets/js/views/loginFormView.js" type="text/javascript"></script>
	<script src="../../assets/js/Models/user.js" type="text/javascript"></script>

	<!-- Adding CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<!-- Script CDN -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="../../assets/plugins/alertify.js"></script>
	<script src="../../assets/plugins/jquery-validate/jquery.validate.js"></script>

	<link rel="stylesheet" href="../../assets/css/styles.css" />
	<!-- include the style -->
	<link rel="stylesheet" href="../../assets/plugins/css/alertify.css" />
	<!-- include a theme -->
	<link rel="stylesheet" href="../../assets/plugins/css/themes/default.css" />

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body>
<div class="container" style="margin-top: 70px;">

</div>

<script type="text/template" id="login_template">
    <div class="login-div">
        <div class="row no-gutters">
            <div class="col-md-5 mx-auto">
                <div class="card card-signin my-5">
                    <ul class="nav nav-pills " id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                               role="tab"
                               aria-controls="pills-home" aria-selected="true">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-r" id="pills-profile-tab" data-toggle="pill"
                               href="#pills-profile"
                               role="tab"
                               aria-controls="pills-profile" aria-selected="false">Sign up</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                             aria-labelledby="pills-home-tab">
                            <div class="card-body">
                                <h5 class="card-title text-center">Tech'Q</h5>
                                <form class="form-signin">
                                    <p id="errLog"></p>
                                    <div class="form-label-group">
                                        <input type="text" class="form-control" placeholder="Enter username"
                                               required id="inputUsername" name="inputEmail">
                                    </div>

                                    <div class="form-label-group">
                                        <input type="password" id="inputPassword" class="form-control"
                                               placeholder="Password"
                                               required name="password">
                                    </div>

                                    <button id="login_button" class="btn btn-lg btn-outline-primary btn-block "
                                            type="submit">Log in
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                             aria-labelledby="pills-profile-tab">
                            <div class="card-body">
                                <h5 class="card-title text-center">Tech'Q</h5>
                                <form class="form-signin">
                                    <p id="errSign"></p>
                                    <div class="form-label-group">
                                        <input type="text" class="form-control" placeholder="Enter username"
                                               required autofocus id="regUsername">
                                    </div>
                                    <div class="form-label-group">
                                        <input type="password" id="regPassword" class="form-control"
                                               placeholder="Password"
                                               required name="password">
                                    </div>
									<div class="form-label-group">
										<select class="form-control" required autofocus id="regListName">
											<option value="" selected disabled>Please select</option>
											<option value="student">Student</option>
											<option value="employee">Employee</option>
										</select>
									</div>
                                    <button class="btn btn-outline-primary btn-block " id="signup_button"
                                            type="submit">Sign up
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
</body>
</html>






