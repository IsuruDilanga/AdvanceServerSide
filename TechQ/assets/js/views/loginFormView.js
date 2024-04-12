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
			$("#errLog").html("Please fill the form");
		}else {
			this.model.set(validateForm);
			var url = this.model.url + "login";
			console.log("url: ", url);
			this.model.save(this.model.attributes, {
				"url": url,
				success: function (model, reponse) {
					// $("#logout").show();
					localStorage.setItem('user', JSON.stringify(model));
					console.log("Login Done");
					// app.appRouter.navigate("#list", {trigger: true, replace: true});
				},
				error:function (model,xhr) {
					if(xhr.statsu=400){
						$("#errLog").html("Username or Password Incorrect");
					}
				}

			});
			console.log("detils has been filled");
		}
        console.log("click login");
    },
    do_register: function (e) {
        console.log("Click register");
    }
});
