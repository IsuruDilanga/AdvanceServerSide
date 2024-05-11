/**
 * This is the LoginFormView which extends from Backbone.View.
 * It is responsible for rendering the login form and handling user interactions.
 *
 * @property {String} el - The DOM element associated with this view. It is set to '.container'.
 *
 * @method render - This method is responsible for rendering the view.
 * It first compiles the template found in the '#login_template' script tag.
 * It then renders the compiled template into the view's element with the model's attributes.
 *
 * @method forget_password - This method is called when the '#forget-password' element is clicked.
 * It prevents the default action, stops the event propagation, and shows the 'forgetPasswordModel' modal.
 *
 * @method forgetPasswordChange - This method is called when the '#forgetPasswordChange' element is clicked.
 * It validates the form, sends a POST request to the server to change the password, and handles the server response.
 *
 * @method do_login - This method is called when the '#login_button' element is clicked.
 * It validates the form, sends a POST request to the server to log in the user, and handles the server response.
 *
 * @method do_register - This method is called when the '#signup_button' element is clicked.
 * It validates the form, sends a POST request to the server to register the user, and handles the server response.
 */

var app = app || {};

// This is the LoginFormView
app.views.LoginFormView = Backbone.View.extend({
    el: ".container",

	// This is the initialize function which is called when the view is created.
    render: function () {
        template = _.template($('#login_template').html());	// Fetch the template from the HTML file
        this.$el.html(template(this.model.attributes)); // Pass the model data to the template
        // $("#logout").hide();
    },

	// This is the events object which contains all the events and their corresponding functions.
    events: {
        "click #login_button": "do_login", 		// When the login button is clicked, call the do_login function
        "click #signup_button": "do_register",		// When the signup button is clicked, call the do_register function
		"click #forget-password": "forget_password",	// When the forget-password button is clicked, call the forget_password function
		'click #forgetPasswordChange': 'forgetPasswordChange',	// When the forgetPasswordChange button is clicked, call the forgetPasswordChange function
    },

	// This is the initialize function which is called when the view is created.
	forget_password: function (e) {
		e.preventDefault();	// Prevent the default action
		e.stopPropagation();	// Stop the event propagation

		console.log("Forget Password");
		$('#forgetPasswordModel').modal('show');
	},

	// This function is called when the forgetPasswordChange button is clicked.
	forgetPasswordChange: function (){

		// Get the values of the input fields
		$username = $("input#username").val();
		$newPassword = $("input#newPassword").val();
		$confirmPassword = $("input#confirmPassword").val();

		// Validate the form
		if($newPassword != $confirmPassword){
			new Noty({
				type: 'error',
				text: 'New password and confirm password do not match',
				timeout: 2000
			}).show();
		}else{
			// Create an object with the user's username, new password, and confirm password
			var userPass = {
				'username': $username,
				'newpassword': $newPassword,
				'confirmpassword': $confirmPassword
			};

			var url = this.model.url + "forget_password";	// Set the URL to the forget_password endpoint

			// Send a POST request to the server to change the password
			$.ajax({
				url: url,
				type: 'POST',
				data: userPass,
				// success callback function
				success: (response) =>{
					if(response.status === true){
						new Noty({
							type: 'success',
							text: 'Password changed successfully',
							timeout: 2000
						}).show();
						$('#forgetPasswordModel').modal('hide');	// Hide the forgetPasswordModel modal
					}else if(response.status === false){
						new Noty({
							type: 'error',
							text: 'Username or email incorrect',
							timeout: 2000
						}).show();
					}
				},
				error: function(response){
					console.error("Error:", response);
					new Noty({
						type: 'error',
						text: 'Failed to update password. Please try again.',
						timeout: 2000
					}).show();
				}

			})

		}

		// Clear the input fields
		$("input#username").val("");
		$("input#newPassword").val(""),
		$("input#confirmPassword").val("");
	},

	// This function is called when the login button is clicked.
    do_login: function (e) {
		e.preventDefault();	// Prevent the default action
		e.stopPropagation();	// Stop the event propagation

		var validateForm = validateLoginForm();	// Validate the login form
		if (!validateForm) {	// If the form is not valid
			new Noty({
				type: 'error',
				text: 'Please Enter the Cridential',
				timeout: 2000
			}).show();
			$("#errLog").html("Please fill the form");	// Show the error message


			// Show the error message for 2 seconds
			setTimeout(function() {
				$("#errLog").empty(); // Clear the error message after 2 seconds
			}, 2000);
		}else {
			this.model.set(validateForm);	// Set the model with the form data
			var url = this.model.url + "login";	// Set the URL to the login endpoint

			// Send a POST request to the server to log in the user
			this.model.save(this.model.attributes, {
				"url": url,
				success: function (model, response) {
					new Noty({
						type: 'success',
						text: 'Login successful',
						timeout: 2000
					}).show();
					$("#logout").show();
					localStorage.setItem('user', JSON.stringify(model));
					console.log("Login Done");
					app.appRouter.navigate("home", {trigger: true});

				},
				error:function (model,xhr) {
					console.log("model: ", model);
					if(xhr.statsu=400){
						$("#errLog").html("Username or Password Incorrect");
						new Noty({
							type: 'error',
							text: 'Username or Password Incorrect',
							timeout: 2000
						}).show();
					}
				}

			});
		}
    },

	// This function is called when the signup button is clicked.
	do_register: function (e) {
		e.preventDefault();	// Prevent the default action
		e.stopPropagation();	// Stop the event propagation

		var validateForm = validateRegisterForm();	// Validate the register form

		// If the form is not valid
		if(validateForm === 'Invalid email address'){
			$("#errSign").html("Invalid email address");

			// Show the error message for 2 seconds
			setTimeout(function() {
				$("#errSign").empty(); // Clear the error message after 2 seconds
			}, 2000);
		}
		else if (!validateForm) {	// If the form is not valid
			$("#errSign").html("Please fill the form");	// Show the error message
		} else {

			this.model.set(validateForm);	// Set the model with the form data
			var url = this.model.url + "register";	// Set the URL to the register endpoint
			// Send a POST request to the server to register the user
			this.model.save(this.model.attributes, {
				"url": url,
				success: function(model, response){	// Success callback function
					new Noty({
						type: 'success',
						text: 'Registration successful',
						timeout: 2000
					}).show();
					console.log("Registration Done");
					app.appRouter.navigate("#", {trigger: true, replace: true}); // Navigate to root route
				},

				error:function (model,xhr) {	// Error callback function
					if(xhr.status === 409){
						$("#errSign").html(xhr.responseJSON.data);
						new Noty({
							type: 'error',
							text: 'Username or Email already exists',
							timeout: 2000
						}).show();
					} else {
						$("#errSign").html();
					}
				}
			});
		}

		// Clear the input fields
		$('#regUsername').val('');
		$('#regPassword').val('');
		$('#regOccupation').val('');
		$('#regName').val('');
		$('#regEmail').val('');

	}

});
