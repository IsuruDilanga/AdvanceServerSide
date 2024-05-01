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
	<script src="../../assets/js/views/answerQuestionView.js" type="text/javascript"></script>
	<script src="../../assets/js/Models/answer.js" type="text/javascript"></script>
	<script src="../../assets/js/views/answerView.js" type="text/javascript"></script>
	<script src="../../assets/js/views/bookmarkView.js" type="text/javascript"></script>
	<script src="../../assets/js/views/userView.js" type="text/javascript"></script>
	<script src="../../assets/js/views/navBarView.js" type="text/javascript"></script>

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

<!--<div class="nav_container"></div>-->

<div class="container" style="margin-top: 70px;"></div>

<script type="text/template" id="login_template">
    <div class="login-div">
        <div class="row no-gutters">
            <div class="col-sm-8 mx-auto">
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
									<div class="forget-password">
										<a href="#" id="forget-password">Forget Password</a>
									</div>

                                    <button id="login_button" class="btn btn-lg btn-outline-primary btn-block "
                                            type="submit">Log in
                                    </button>
                                </form>
                            </div>
                        </div>

						<!-- Add this HTML for the modal dialog -->
						<div class="modal fade" id="forgetPasswordModel" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="passwordModalLabel">Forget Password</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="changePasswordForm">

											<div class="form-group">
												<label for="username">Username or Email</label>
												<input type="text" class="form-control" id="username" placeholder="Enter Username or Email" required>
											</div>
											<div class="form-group">
												<label for="newPassword">New Password</label>
												<input type="password" class="form-control" id="newPassword" placeholder="Enter new password" required>
											</div>
											<div class="form-group">
												<label for="confirmPassword">Confirm Password</label>
												<input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" required>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" id="forgetPasswordChange">Save changes</button>
									</div>
								</div>
							</div>
						</div>

                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                             aria-labelledby="pills-profile-tab">
                            <div class="card-body">
                                <h5 class="card-title text-center">Tech'Q</h5>
                                <form class="form-signin">
                                    <p id="errSign"></p>

									<div class="container">
										<div class="row form-label-group-sign">
											<div class="col-sm-6">
												<input type="text" class="form-control" placeholder="Enter username"
													   required autofocus id="regUsername">
											</div>
											<div class="col-sm-6">
												<input type="text" class="form-control" placeholder="Enter your name"
													   required autofocus id="regName">
											</div>
										</div>
									</div>
									<div class="container">
										<div class="row form-label-group-sign">
											<div class="col-md-8">
												<input type="email" class="form-control" placeholder="Enter your email"
													   required autofocus id="regEmail">
											</div>
											<div class="col-md-4">
												<select class="form-control" required autofocus id="regOccupation">
													<option value="" selected disabled>Please select</option>
													<option value="student">Student</option>
													<option value="employee">Employee</option>
												</select>
											</div>
										</div>
									</div>

<!--                                    <div class="form-label-group">-->
<!--                                        <input type="text" class="form-control" placeholder="Enter username"-->
<!--                                               required autofocus id="regUsername">-->
<!--                                    </div>-->
<!--									<div class="form-label-group">-->
<!--										<input type="text" class="form-control" placeholder="Enter your name"-->
<!--											   required autofocus id="regName">-->
<!--									</div>-->
<!--									<div class="form-label-group-sign">-->
<!--										<input type="email" class="form-control" placeholder="Enter your email"-->
<!--											   required autofocus id="regEmail">-->
<!--									</div>-->
                                    <div class="form-label-group-sign">
                                        <input type="password" id="regPassword" class="form-control"
                                               placeholder="Password"
                                               required name="password">
                                    </div>

<!--									<div class="form-label-group-sign">-->
<!--										<select class="form-control" required autofocus id="regOccupation">-->
<!--											<option value="" selected disabled>Please select</option>-->
<!--											<option value="student">Student</option>-->
<!--											<option value="employee">Employee</option>-->
<!--										</select>-->
<!--									</div>-->
                                    <button class="btn btn-outline-primary btn-block " id="signup_button" style="margin-top: 50px"
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

	<div id="nav-bar-container">

	</div>

<!--	<div class="header" style="position:absolute;top:0;left:0;width:100%">-->
<!--		<nav class="navbar navbar-expand-lg navbar-light nav-color">-->
<!--			<a class="navbar-brand" href="#">Tech'Q</a>-->
<!--			<form class="form-inline my-2 my-lg-0">-->
<!--				<input class="form-control mr-sm-2" id="searchHome" type="search" placeholder="Search Question" aria-label="Search">-->
<!--				<button class="btn btn-outline-success my-2 my-sm-0" id="homesearch" type="submit"><i class="fas fa-search"></i> search</button>-->
<!--			</form>-->
<!---->
<!--			<div class="collapse navbar-collapse" id="navbarToggler">-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li class="nav-username" style="font-size: 20px; cursor: pointer">-->
<!--						<a href="#home/user/<%=user_id%>" style="text-decoration: none; color: white">-->
<!--							<i class="fa-solid fa-user"></i> <%=name%>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li style="font-size: 30px">-->
<!--						<a href="#home/bookmark/<%=user_id%>" style="text-decoration: none; color: white; cursor: pointer">-->
<!--							<i class="fa-regular fa-bookmark"></i>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">-->
<!--					<a href="#logout" id="logout" class="btn btn-secondary my-2 my-sm-0">-->
<!--						<i class="fa fa-sign-out" aria-hidden="true"></i> Log out</a>-->
<!--				</ul>-->
<!---->
<!--			</div>-->
<!--		</nav>-->
<!---->
<!--	</div>-->

	<div class="question-area" id="question">
		<div class="top-questions" style="display: flex; justify-content: space-between; align-items: center;">
			<h1><strong>Top Questions</strong></h1>
			<button type="button" class="btn btn-primary" id="ask_question_btn">Ask Question</button>
		</div>
		<hr>
	</div>

</script>




<script type="text/template" id="user_template">

	<div id="nav-bar-container">

	</div>

<!--	<div class="header" style="position:absolute;top:0;left:0;width:100%">-->
<!--		<nav class="navbar navbar-expand-lg navbar-light nav-color">-->
<!--			<a class="navbar-brand" href="#">Tech'Q</a>-->
<!--			<form class="form-inline my-2 my-lg-0">-->
<!--				<input class="form-control mr-sm-2" id="searchHome" type="search" placeholder="Search Question" aria-label="Search">-->
<!--				<button class="btn btn-outline-success my-2 my-sm-0" id="homesearch" type="submit"><i class="fas fa-search"></i> search</button>-->
<!--			</form>-->
<!---->
<!--			<div class="collapse navbar-collapse" id="navbarToggler">-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li class="nav-username" style="font-size: 20px; cursor: pointer">-->
<!--						<a href="#home/user/<%=user_id%>" style="text-decoration: none; color: white">-->
<!--							<i class="fa-solid fa-user"></i> <%=username%>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li style="font-size: 30px">-->
<!--						<a href="#home/bookmark/<%=user_id%>" style="text-decoration: none; color: white; cursor: pointer">-->
<!--							<i class="fa-regular fa-bookmark"></i>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">-->
<!--					<a href="#logout" id="logout" class="btn btn-secondary my-2 my-sm-0">-->
<!--						<i class="fa fa-sign-out" aria-hidden="true"></i> Log out</a>-->
<!--				</ul>-->
<!---->
<!--			</div>-->
<!--		</nav>-->
<!--	</div>-->

	<div class="container">
		<div class="row user-row">
			<div class="col-sm-8" >
				<div class="user-details">
					<table>
						<tr>
							<td><span>User Name </span></td>
							<td><input type="text" value="<%=username%>" disabled id="editusername"></td>
						</tr>
						<tr>
							<td><span>Display Name </span></td>
							<td><input type="text" value="<%=name%>" disabled id="editname"></td>
						</tr>
						<tr>
							<td><span>Email </span></td>
							<td><input type="email" value="<%=email%>" disabled id="editemail"></td>
						</tr>
						<tr>
							<td><span>Occupation </span></td>
							<td>
								<select class="user-occupation" disabled id="editOccupation">
									<option value="<%=occupation%>"><%=occupation%></option>
									<option value="student">Student</option>
									<option value="employee">Employee</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<p>Answered Questions: <%= answerquestioncnt %></p>
								<% let anscntstar = Math.floor(answerquestioncnt / 10); %>
								<% if(anscntstar >= 1) { %>
									<% for (let i = 0; i < anscntstar; i++) { %>
										<i class="fa-solid fa-star" style="color: gold"></i>
									<% } %>
								<% } %>
							</td>
							<td>
								<div class="progress">
									<% const answerCnt = answerquestioncnt % 10; %>
									<% for (let i = 0; i < answerCnt; i++) { %>
									<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
									<% } %>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<p>Asked Questions: <%= askquestioncnt %></p>
								<% let askcntstar = Math.floor(askquestioncnt / 10); %>
								<% if(askcntstar >= 1) { %>

									<% for (let i = 0; i < askcntstar; i++) { %>
										<i class="fa-solid fa-star" style="color: gold"></i>
									<% } %>
								<% } %>
							</td>
							<td>
								<div class="progress">
									<% const askCnt = askquestioncnt % 10; %>
									<% for (let i = 0; i < askCnt; i++) { %>
									<div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
									<% } %>
								</div>
							</td>

<!--							<td>-->
<!--								<span>answerQ: <%=answerquestioncnt%> </span>-->
<!--								<span>askQ: <%=askquestioncnt%></span>-->
<!---->
<!--							</td>-->
						</tr>

					</table>

					<div class="edit-btns">
						<button type="button" class="btn btn-primary" id="edit_userdetails_btn">Edit User Details</button>
						<button type="button" class="btn btn-primary" id="edit_userpassword_btn">Change Password</button>
						<button type="button" class="btn btn-primary" id="edit_userchangedp_btn">Change Profile Pic</button>
						<input type="file" id="upload_image_input" style="display: none;" accept="image/*">

					</div>
				</div>

			</div>
			<div class="col-sm-4">
				<div class="user-image">
					<% if (userimage != "") { %>
						<img src="<%=userimage%>" alt="User Image" >
					<% } else { %>
						<img src="../../assets/images/userimage/face-scan.png" alt="User Image" >
					<% } %>
				</div>
			</div>
		</div>

		<!-- Add this HTML for the modal dialog -->
		<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="changePasswordForm">
							<div class="form-group">
								<label for="oldPassword">Old Password</label>
								<input type="password" class="form-control" id="oldPassword" placeholder="Enter old password" required>
							</div>
							<div class="form-group">
								<label for="newPassword">New Password</label>
								<input type="password" class="form-control" id="newPassword" placeholder="Enter new password" required>
							</div>
							<div class="form-group">
								<label for="confirmPassword">Confirm Password</label>
								<input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" required>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="submitPasswordChange">Save changes</button>
					</div>
				</div>
			</div>
		</div>

	</div>

</script>

<script type="text/template" id="password_template">
	<div>
		<h1>Bookmark Page</h1>
	</div>
</script>

<script type="text/template" id="question_template">
	<div class="one-question">
		<h4 class="single-question"><a href="#home/answerquestion/<%=questionid%>" style="text-decoration: none; color: navy"><%=title%></a></h4>
		<p><%= question.slice(0, 200) %>...</p>
		<div class="all-tags" style="display: flex">
			<% tags.forEach(function(tag) { %>
			<div class="tags-cover" style="margin-right: 10px">
				<p><%= tag %></p>
			</div>
			<% }); %>
			<p><strong>rate:</strong> <%= rate %></p>
		</div>
	</div>
</script>

<script type="text/template" id="add_question_template">

	<div id="nav-bar-container">

	</div>

<!--	<div class="header" style="position:absolute;top:0;left:0;width:100%">-->
<!--		<nav class="navbar navbar-expand-lg navbar-light nav-color">-->
<!--			<a class="navbar-brand" href="#">Tech'Q</a>-->
<!--			<form class="form-inline my-2 my-lg-0">-->
<!--				<input class="form-control mr-sm-2" id="searchHome" type="search" placeholder="Search Question" aria-label="Search">-->
<!--				<button class="btn btn-outline-success my-2 my-sm-0" id="homesearch" type="submit"><i class="fas fa-search"></i> search</button>-->
<!--			</form>-->
<!---->
<!--			<div class="collapse navbar-collapse" id="navbarToggler">-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li class="nav-username" style="font-size: 20px; cursor: pointer">-->
<!--						<a href="#home/user/<%=user_id%>" style="text-decoration: none; color: white">-->
<!--							<i class="fa-solid fa-user"></i> <%=name%>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li style="font-size: 30px">-->
<!--						<a href="#home/bookmark/<%=user_id%>" style="text-decoration: none; color: white; cursor: pointer">-->
<!--							<i class="fa-regular fa-bookmark"></i>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">-->
<!--					<a href="#logout" id="logout" class="btn btn-secondary my-2 my-sm-0">-->
<!--						<i class="fa fa-sign-out" aria-hidden="true"></i> Log out</a>-->
<!--				</ul>-->
<!---->
<!--			</div>-->
<!--		</nav>-->
<!---->
<!--	</div>-->

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
		<p class="topic">Upload Image</p>
		<p style="font-size: 12px">Upload an image related to your question (optional)</p>
		<input type="file" class="form-control-file" id="imageUpload" name="imageUpload">
		<!-- Optionally, include a preview section here -->
	</div>

	<div class="question-title">
		<p class="topic">Tags</p>
		<p style="font-size: 12px">Add up to 5 tags to describe what your question is about. Start typing to see suggestion </p>
		<input type="text" class="form-control form-title" placeholder="e.g. (javascript, react, nodejs)"
			   required id="inputQuestionTags" name="inputQuestionTags">
	</div>

	<div class="question-title">
		<select class="form-control" required id="questionCategory">
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

<script type="text/template" id="answer-question-template">

	<div id="nav-bar-container">

	</div>

<!--	<div class="header" style="position:absolute;top:0;left:0;width:100%">-->
<!--		<nav class="navbar navbar-expand-lg navbar-light nav-color">-->
<!--			<a class="navbar-brand" href="#">Tech'Q</a>-->
<!--			<form class="form-inline my-2 my-lg-0">-->
<!--				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">-->
<!--				<button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i> search</button>-->
<!--			</form>-->
<!---->
<!--			<div class="collapse navbar-collapse" id="navbarToggler">-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li class="nav-username" style="font-size: 20px; cursor: pointer">-->
<!--						<a href="#" style="text-decoration: none; color: white">-->
<!--							<i class="fa-solid fa-user"></i> <%=username%>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li style="font-size: 20px">-->
<!---->
<!--						<a href="#" style="text-decoration: none; color: white">-->
<!--							<i class="fa-regular fa-bookmark"></i>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">-->
<!--					<a href="#logout" id="logout" class="btn btn-secondary my-2 my-sm-0">-->
<!--						<i class="fa fa-sign-out" aria-hidden="true"></i> Log out</a>-->
<!--				</ul>-->
<!---->
<!--			</div>-->
<!--		</nav>-->
<!---->
<!--	</div>-->

	<div class="container-fluid answer-contain" style="marg">
		<div class="row">
			<div class="col-sm-1 left-side-question question-display" style="background-color: #8fcbff; height: 250px">
				<div class="arrow-up" id="up-question-view" data-clicked="false">
					<i class="fa-solid fa-angle-up" style="margin-top: 10px; font-size: 30px"></i>
				</div>
				<p class="view-status" id="question-view-status"><%=viewstatus%></p>
				<div class="arrow-down" id="down-question-view" data-clicked="false">
					<i class="fa-solid fa-angle-down" style="margin-top: 10px; font-size: 30px"></i>
				</div>
				<% if (is_bookmark) { %>
					<i class="fa-solid fa-bookmark add-to-bookmark" id="remove-bookmark"></i>
				<% } else {%>
					<i class="fa-regular fa-bookmark add-to-bookmark" id="add-bookmark"></i>
				<% } %>
			</div>
			<div class="col-sm-11 question-display">
<!--				<div class="question-display">-->
					<div class="ans-question-title">
						<h3 class="answer"><%= title %></h3>
						<p><strong>Asked:</strong> <%= Qaddeddate %>    <strong>Rate:</strong> <%= rate %> </p>
					</div>

					<div class="ans-question">
						<p><%= question %></p>
						<p><%= expectationQ %></p>
						<!--		<img src="../../assets/images/images9.jpeg" alt="Question Image">-->
						<% if (questionimage !== '') { %>
						<img src="<%= questionimage %>" alt="Question Image">
						<% } %>
					</div>
<!--				</div>-->
			</div>
		</div>
	</div>

<!--	<h1>answer Question Page</h1>-->
<!--	<div class="question-display">-->
<!--		<div class="ans-question-title">-->
<!--			<h3 class="answer"><%= title %></h3>-->
<!--			<p><strong>Asked:</strong> <%= Qaddeddate %>    <strong>Rate:</strong> <%= rate %> </p>-->
<!--		</div>-->
<!---->
<!--		<div class="ans-question">-->
<!--			<p><%= question %></p>-->
<!--			<p><%= expectationQ %></p>-->
<!--					<img src="../../assets/images/images9.jpeg" alt="Question Image">-->
<!--			<% if (questionimage !== '') { %>-->
<!--				<img src="<%= questionimage %>" alt="Question Image">-->
<!--			<% } %>-->
<!--		</div>-->
<!--	</div>-->


	<div class="existing-answer-area" id="answer" style="display: none">
		<div class="top-answers" style="display: flex; justify-content: space-between; align-items: center;">
<!--			<h1>Answers</h1>-->
		</div>
	</div>

	<div class="ans-que">
		<div class="question-title">
			<p class="topic">Your Answer</p>

			<textarea class="form-control form-title" id="inputQuestionDetails" name="inputQuestionDetails"
					  rows="3" required></textarea>
		</div>

		<div class="question-title">
			<p class="topic">Upload Image</p>
			<p style="font-size: 12px">Upload an image related to your Answer (optional)</p>
			<input type="file" class="form-control-file" id="answerImageUpload" name="answerImageUpload">
			<!-- Optionally, include a preview section here -->
		</div>

		<div class="sub-answer">
			<button type="submit" id="submit_answer" class="btn btn-primary ans-subbtn">Submit Answer</button>
			<select class="form-control" required id="questionrate">
				<option value="" selected disabled>Rate for Question</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
			<button type="submit" id="submit_answer" class="btn btn-primary ans-subbtn">Add to bookmark</button>
		</div>
	</div>

</script>

<script type="text/template" id="answer-template">
	<div class="one-question ex-answer">
		<p> <%= answer %> </p>
		<% if (answerimage !== '') { %>
		<img src="<%= answerimage %>" alt="Answer Image">
		<% } %>
<!--		<img src="<%= answerimage %>" alt="Answer Image" style="margin-top: 10px">-->
		<p style="margin-top: 10px"><strong>Rate : </strong><%= answerrate %>  <strong>Added Date: </strong><%= answeraddeddate %></p>
	</div>
</script>

<script type="text/template" id="bookmark_View">

	<div id="nav-bar-container">

	</div>

<!--	<div class="header" style="position:absolute;top:0;left:0;width:100%">-->
<!--		<nav class="navbar navbar-expand-lg navbar-light nav-color">-->
<!--			<a class="navbar-brand" href="#">Tech'Q</a>-->
<!--			<form class="form-inline my-2 my-lg-0">-->
<!--				<input class="form-control mr-sm-2" id="searchHome" type="search" placeholder="Search Question" aria-label="Search">-->
<!--				<button class="btn btn-outline-success my-2 my-sm-0" id="homesearch" type="submit"><i class="fas fa-search"></i> search</button>-->
<!--			</form>-->
<!---->
<!--			<div class="collapse navbar-collapse" id="navbarToggler">-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li class="nav-username" style="font-size: 20px; cursor: pointer">-->
<!--						<a href="#" style="text-decoration: none; color: white">-->
<!--							<i class="fa-solid fa-user"></i> <%=username%>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li style="font-size: 30px">-->
<!--						<a href="#home/bookmark/<%=user_id%>" style="text-decoration: none; color: white; cursor: pointer">-->
<!--							<i class="fa-regular fa-bookmark"></i>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">-->
<!--					<a href="#logout" id="logout" class="btn btn-secondary my-2 my-sm-0">-->
<!--						<i class="fa fa-sign-out" aria-hidden="true"></i> Log out</a>-->
<!--				</ul>-->
<!---->
<!--			</div>-->
<!--		</nav>-->
<!---->
<!--	</div>-->

	<div class="question-area" id="question">
		<div class="top-questions" style="display: flex; justify-content: space-between; align-items: center;">
			<h1>Bookmark Questions</h1>
			<button type="button" class="btn btn-primary" id="ask_question_btn">Ask Question</button>
		</div>
		<hr>
	</div>

</script>

<script type="text/template" id="nav-bar-template">
	<div class="header" style="position:absolute;top:0;left:0;width:100%">
		<nav class="navbar navbar-expand-lg navbar-light nav-color">
			<a class="navbar-brand" href="#">Tech'Q</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon" style="color: #2ea53a"></span>
			</button>

			<div class="collapse navbar-collapse justify-content-center" id="navbarToggler">
				<div class="d-flex justify-content-center align-items-center flex-grow-1"> <!-- Added a container div for center alignment -->
					<form class="form-inline my-2 my-lg-0">
						<input class="form-control mr-sm-2" id="searchHome" type="search" placeholder="Search Question" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0" id="homesearch" type="submit"><i class="fas fa-search"></i> search</button>
					</form>
				</div>
<!--				<ul class="navbar-nav">-->
<!--					<li class="nav-item" style="font-size: 20px;">-->
<!--						<a class="nav-link" href="#home/user/<%=user_id%>" style="text-decoration: none; color: white;">-->
<!--							<i class="fa-solid fa-user"></i> <%=name%>-->
<!--						</a>-->
<!--					</li>-->
<!--					<li class="nav-item ml-3" style="font-size: 30px;">-->
<!--						<a class="nav-link" href="#home/bookmark/<%=user_id%>" style="text-decoration: none; color: white;">-->
<!--							<i class="fa-regular fa-bookmark"></i>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">-->
					<a href="#logout" id="logout" class="btn btn-secondary my-2 my-sm-0">
						<i class="fa fa-sign-out" aria-hidden="true"></i> Log out</a>
				</ul>
			</div>
		</nav>


		<!--		<nav class="navbar navbar-expand-lg navbar-light nav-color">-->
<!--			<a class="navbar-brand" href="#">Tech'Q</a>-->
<!---->
<!--			<div class="collapse navbar-collapse" id="navbarToggler">-->
<!--				<form class="form-inline my-2 my-lg-0">-->
<!--					<input class="form-control mr-sm-2" id="searchHome" type="search" placeholder="Search Question" aria-label="Search">-->
<!--					<button class="btn btn-outline-success my-2 my-sm-0" id="homesearch" type="submit"><i class="fas fa-search"></i> search</button>-->
<!--				</form>-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li class="nav-username" style="font-size: 20px; cursor: pointer">-->
<!--						<a href="#home/user/<%=user_id%>" style="text-decoration: none; color: white">-->
<!--							<i class="fa-solid fa-user"></i> <%=name%>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">-->
<!--					<li style="font-size: 30px">-->
<!--						<a href="#home/bookmark/<%=user_id%>" style="text-decoration: none; color: white; cursor: pointer">-->
<!--							<i class="fa-regular fa-bookmark"></i>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">-->
<!--					<a href="#logout" id="logout" class="btn btn-secondary my-2 my-sm-0">-->
<!--						<i class="fa fa-sign-out" aria-hidden="true"></i> Log out</a>-->
<!--				</ul>-->
<!---->
<!--			</div>-->
<!--		</nav>-->

	</div>
</script>


</body>
</html>






