var app = app || {};

app.routers.AppRouter = Backbone.Router.extend({

	routes: {
		"": "home"
	},

	home: function () {
		console.log("Home route");
		app.user = new app.models.User();
		console.log(app.user);
		app.loginView = new app.views.LoginFormView({ model: app.user });
		app.loginView.render();
		// userJson = JSON.parse(localStorage.getItem("user"));
		// if (userJson == null) {
		// 	if (!app.loginView) {
		// 		app.user = new app.models.User();
		// 		//initialize view
		// 		app.loginView = new app.views.LoginFormView({ model: app.user });
		// 		app.loginView.render();
		// 	}
		// } else {
		// 	this.viewList();
		// }
	},
});
