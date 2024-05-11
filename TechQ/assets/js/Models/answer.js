var app = app || {};

app.models.Answers = Backbone.Model.extend({
	urlRoot: '/TechQ/index.php/api/Answer/',
	defaults:{
		answerid: "",
		questionid: null,
		userid: null,
		answeraddeduserid: null,
		user_id:"",
		answer: null,
		answerimage: null,
		answerrate: null,
		rate: null,
		questionrate: null,
		viewstatus: null,
		answeraddeddate: null
	},
	url: '/TechQ/index.php/api/Answer/',
});

app.collections.AnswerCollection = Backbone.Collection.extend({
	model: app.models.Answers,
	url: '/TechQ/index.php/api/Answer/',
});
