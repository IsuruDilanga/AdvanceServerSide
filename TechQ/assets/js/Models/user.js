var app = app || {};
app.models.User = Backbone.Model.extend({
	urlRoot: '/TechQ/index.php/api/User/',
	defaults: {
		username: "",
		password: "",
		user_id: null
	},
	url: '/TechQ/index.php/api/User/',

});
