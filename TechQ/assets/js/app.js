var app = app || {};
app.views = {};
app.routers = {};
app.models = {};
app.collections = {};

//Validation for login. If not there it will return false
function validateLoginForm() {
	var user = {
		'username': $("input#inputUsername").val(),
		'password': $("input#inputPassword").val()
	};
	if (!user.username || !user.password) {
		return false;
	}
	return user;
}

function validateRegisterForm() {
	var user = {
		'username': $("input#regUsername").val(),
		'password': $("input#regPassword").val(),
	};
	if (!user.username || !user.password || !user.list_name || !user.list_description) {
		return false;
	}
	return user;
}

$(document).ready(function () {
	app.appRouter = new app.routers.AppRouter();
	$(function () {
		Backbone.history.start();
	});
});
