var app = app || {};


app.views.LoginFormView = Backbone.View.extend({
    el: ".container",

    render: function () {
        template = _.template($('#login_template').html());
        this.$el.html(template(this.model.attributes));
		console.log("login template");
        // $("#logout").hide();
    },
    events: {
        "click #login_button": "do_login",
        "click #signup_button": "do_register",
		"click #forget-password": "forget_password",
		'click #forgetPasswordChange': 'forgetPasswordChange',
    },

	forget_password: function (e) {
		e.preventDefault();
		e.stopPropagation();

		console.log("Forget Password");
		$('#forgetPasswordModel').modal('show');
	},

	forgetPasswordChange: function (){
		console.log("forgetPasswordChange");
		// userJson = JSON.parse(localStorage.getItem("user"));
		// var user_id = userJson['user_id'];

		$username = $("input#username").val();
		$newPassword = $("input#newPassword").val();
		$confirmPassword = $("input#confirmPassword").val();

		if($newPassword != $confirmPassword){
			new Noty({
				type: 'error',
				text: 'New password and confirm password do not match',
				timeout: 2000
			}).show();
		}else{
			var userPass = {
				'username': $username,
				'newpassword': $newPassword,
				'confirmpassword': $confirmPassword
			};

			var url = this.model.url + "forget_password";

			$.ajax({
				url: url,
				type: 'POST',
				data: userPass,
				success: (response) =>{
					console.log("response", response);
					if(response.status === true){
						new Noty({
							type: 'success',
							text: 'Password changed successfully',
							timeout: 2000
						}).show();
						$('#forgetPasswordModel').modal('hide');
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

		$("input#username").val("");
		$("input#newPassword").val(""),
		$("input#confirmPassword").val("");
	},

    do_login: function (e) {
		e.preventDefault();
		e.stopPropagation();

		var validateForm = validateLoginForm();
		if (!validateForm) {
			new Noty({
				type: 'error',
				text: 'Please Enter the Cridential',
				timeout: 2000
			}).show();
			$("#errLog").html("Please fill the form");


			// Show the error message for 2 seconds
			setTimeout(function() {
				$("#errLog").empty(); // Clear the error message after 2 seconds
			}, 2000);
		}else {
			this.model.set(validateForm);
			var url = this.model.url + "login";
			console.log("url: ", url);
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
			console.log("detils has been filled");
		}
        console.log("click login");
    },
	do_register: function (e) {
		e.preventDefault();
		e.stopPropagation();

		var validateForm = validateRegisterForm();
		console.log("validateForm: ", validateForm);
		if(validateForm === 'Invalid email address'){
			$("#errSign").html("Invalid email address");

			// Show the error message for 2 seconds
			setTimeout(function() {
				$("#errSign").empty(); // Clear the error message after 2 seconds
			}, 2000);
		}
		else if (!validateForm) {
			$("#errSign").html("Please fill the form");
		} else {
			console.log("validateForm: ");
			this.model.set(validateForm);
			var url = this.model.url + "register";
			this.model.save(this.model.attributes, {
				"url": url,
				success: function(model, response){
					new Noty({
						type: 'success',
						text: 'Registration successful',
						timeout: 2000
					}).show();
					console.log("Registration Done");
					app.appRouter.navigate("#", {trigger: true, replace: true}); // Navigate to root route
				},

				error:function (model,xhr) {
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

			console.log("details are filled");
			console.log("validateForm: " ,validateForm);
		}

		$('#regUsername').val('');
		$('#regPassword').val('');
		$('#regOccupation').val('');
		$('#regName').val('');
		$('#regEmail').val('');

	}

});
