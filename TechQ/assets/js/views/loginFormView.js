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
        "click #signup_button": "do_register"
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
		if (!validateForm) {
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
						$("#errSign").html(xhr.responseJSON.status);
						new Noty({
							type: 'error',
							text: xhr.responseJSON.status,
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
