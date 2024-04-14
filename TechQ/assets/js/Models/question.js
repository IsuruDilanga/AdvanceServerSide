var app = app || {};

app.models.Questions = Backbone.Model.extend({
	urlRoot: '/TechQ/index.php/api/Question/',
	defaults: {
		question: null,
		user_id: null,
		title: null,
		question: null,
		questionimage: null,
		category: null,
		tags: null,
		rate:null,
		bookmark:null,
		viewstatus:null,
		qaddeddate:null
	},
	url: '/TechQ/index.php/api/Question/',

});

app.collections.QuestionCollection = Backbone.Collection.extend({
	model: app.models.Questions,
	url: '/TechQ/index.php/api/Question/',
});
