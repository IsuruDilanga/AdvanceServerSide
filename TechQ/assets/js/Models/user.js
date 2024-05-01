var app = app || {};
app.models.User = Backbone.Model.extend({
	urlRoot: '/TechQ/index.php/api/User/',
	defaults: {
		name: "",
		email: "",
		username: "",
		password: "",
		user_id: null,
		occupation: "",
		premium: false,
		userimage: "",
		answerquestioncnt: null,
		askquestioncnt: null,
	},
	url: '/TechQ/index.php/api/User/',
	urlAskQuestion: '/TechQ/index.php/api/Question/',
	urlAnswerQuestion: '/TechQ/index.php/api/Answer/'

});
