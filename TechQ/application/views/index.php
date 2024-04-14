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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"  type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"  type="text/javascript"></script>

	<script src="../../assets/js/app.js" type="text/javascript"></script>
	<script src="../../assets/js/routers/approuter.js" type="text/javascript"></script>
	<script src="../../assets/js/views/loginFormView.js" type="text/javascript"></script>
	<script src="../../assets/js/Models/user.js" type="text/javascript"></script>
	<script src="../../assets/js/views/homeView.js" type="text/javascript"></script>
	<script src="../../assets/js/Models/question.js" type="text/javascript"></script>
	<script src="../../assets/js/views/questionView.js" type="text/javascript"></script>
	<script src="../../assets/js/views/askQuestionView.js" type="text/javascript"></script>

	<!-- Adding CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-... (hash value) ..." crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-... (hash value) ..." crossorigin="anonymous" />
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

	<!-- Include Noty CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css"/>
	<!-- Include Noty JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>

	<!-- Script CDN -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="../../assets/plugins/jquery-validate/jquery.validate.js"></script>


	<link rel="stylesheet" href="../../assets/css/styles.css" />
	<!-- include a theme -->
	<link rel="stylesheet" href="../../assets/plugins/css/themes/default.css" />

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body>

<div class="nav_container"></div>
<div class="container" style="margin-top: 70px;"></div>

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
										<select class="form-control" required autofocus id="regOccupation">
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

<script type="text/template" id="home_template">

	<div class="header" style="position:absolute;top:0;left:0;width:100%">
		<nav class="navbar navbar-expand-lg navbar-light nav-color">
			<a class="navbar-brand" href="#">Tech'Q</a>
			<form class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i> search</button>
			</form>

			<div class="collapse navbar-collapse" id="navbarToggler">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-username" style="font-size: 20px; cursor: pointer">
						<a href="#" style="text-decoration: none; color: white">
							<i class="fa-solid fa-user"></i> <%=username%>
						</a>
					</li>
				</ul>
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li style="font-size: 30px">
						<a href="#" style="text-decoration: none; color: white">
							<i class="fa-regular fa-bookmark"></i>
						</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
					<a href="#logout" id="logout" class="btn btn-secondary my-2 my-sm-0">
						<i class="fa fa-sign-out" aria-hidden="true"></i> Log out</a>
				</ul>

			</div>
		</nav>

	</div>

	<div class="question-area" id="question">
		<div class="top-questions" style="display: flex; justify-content: space-between; align-items: center;">
			<h1>Top Questions</h1>
			<button type="button" class="btn btn-primary" id="ask_question_btn">Ask Question</button>
		</div>
		<hr>
	</div>

</script>

<script type="text/template" id="question_template">
	<div class="one-question">
		<h4 class="single-question"><%=title%></h4>
		<div class="all-tags" style="display: flex">
			<% tags.forEach(function(tag) { %>
			<div class="tags-cover" style="margin-right: 10px">
				<p><%= tag %></p>
			</div>
			<% }); %>
			<p>rate: <%= rate %></p>
		</div>
		<hr>
	</div>
</script>

<script type="text/template" id="add_question_template">
	<div class="header" style="position:absolute;top:0;left:0;width:100%">
		<nav class="navbar navbar-expand-lg navbar-light nav-color">
			<a class="navbar-brand" href="#">Tech'Q</a>
			<form class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i> search</button>
			</form>

			<div class="collapse navbar-collapse" id="navbarToggler">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-username" style="font-size: 20px; cursor: pointer">
						<a href="#" style="text-decoration: none; color: white">
							<i class="fa-solid fa-user"></i> <%=username%>
						</a>
					</li>
				</ul>
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li style="font-size: 20px">
						<a href="#" style="text-decoration: none; color: white">
							<i class="fa-regular fa-bookmark"></i>
						</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
					<a href="#logout" id="logout" class="btn btn-secondary my-2 my-sm-0">
						<i class="fa fa-sign-out" aria-hidden="true"></i> Log out</a>
				</ul>

			</div>
		</nav>

	</div>

	<h3 class="question-page-title" >Ask a Technical Questions</h3>

	<div class="question-title">
		<p class="topic">Title</p>
		<p style="font-size: 12px">Be specific and imaging you're asking a question to another person</p>

		<input type="text" class="form-control form-title" placeholder="Enter Question Title"
			   required id="inputQuestionTitle" name="inputQuestionTitle">
	</div>

	<div class="question-title">
		<p class="topic">What are the details of your problem</p>
		<p style="font-size: 12px">Introduce the problem and expand on what you put in the title. Minimum 20 characters</p>

		<textarea class="form-control form-title" id="inputQuestionDetails" name="inputQuestionDetails"
				  rows="3" required></textarea>
	</div>

	<div class="question-title">
		<p class="topic">What did you try and what were you expecting?</p>
		<p style="font-size: 12px">describe what you tried, what you expected to happen, and what actually
				resulted. Minimum 20 Characters</p>
		<textarea class="form-control form-title" id="inputQuestionExpectation" name="inputQuestionExpectation"
				  rows="3" required></textarea>
	</div>

	<div class="question-title">
		<p class="topic">Tags</p>
		<p style="font-size: 12px">Add up to 5 tags to describe what your question is about. Start typing to see suggestion </p>
		<input type="text" class="form-control form-title" placeholder="e.g. (javascript, react, nodejs)"
			   required id="inputQuestionTags" name="inputQuestionTags">
	</div>

	<div class="question-title">
		<select class="form-control" required autofocus id="questionCategory">
			<option value="" selected disabled>Category</option>
			<option value="software">Software</option>
			<option value="hardware">Hardware</option>
			<option value="programming">Programming</option>
			<option value="networking">Networking</option>
			<option value="security">Security</option>
			<option value="database">Database</option>
			<option value="web-development">Web Development</option>
			<option value="mobile-development">Mobile Development</option>
			<option value="cloud-computing">Cloud Computing</option>
			<option value="artificial-intelligence">Artificial Intelligence</option>
		</select>
	</div>


	<button type="submit" id="submit_question" class="btn btn-primary question-subbtn">Submit Question</button>
</script>

</body>
</html>






