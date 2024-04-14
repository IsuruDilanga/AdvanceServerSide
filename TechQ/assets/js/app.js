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
		'occupation': $("select#regOccupation").val()
	};
	if (!user.username || !user.password || !user.occupation) {
		return false;
	}
	return user;
}

function validateQuestionAddForm(){
	var question = {
		'title': $("input#inputQuestionTitle").val(),
		'question': $("textarea#inputQuestionDetails").val(),
		'expectationQ': $("textarea#inputQuestionExpectation").val(),
		'category': $("select#questionCategory").val(),
		'tags': $("input#inputQuestionTags").val()
	};
	console.log(question);
	// Check if 'question' or 'expectationQ' has at least 20 characters
	if (!question.question || question.question.length < 20) {
		return false;
	}

	if (!question.expectationQ || question.expectationQ.length < 20) {
		return false;
	}

	var tagsArray = question.tags.split(',').filter(tag => tag.trim() !== ''); // Remove empty tags
	if (tagsArray.length > 5) {
		return false; // Return false if more than 5 tags
	}

	if (!question.title || !question.category) {
		return false;
	}

	return question;
}

$(document).ready(function () {
	app.appRouter = new app.routers.AppRouter();
	$(function () {
		Backbone.history.start();
	});
});
