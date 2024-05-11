// Define the application namespace if it doesn't exist
var app = app || {};

/**
 * The Questions model represents a single question in the application.
 *
 * @author Isuru Dissanayake
 */
app.models.Questions = Backbone.Model.extend({
	// The API endpoint for this model
	urlRoot: '/TechQ/index.php/api/Question/',

	// Default attributes for the question
	defaults: {
		question: null, // The text of the question
		user_id: null, // The ID of the user who posted the question
		title: null, // The title of the question
		questionimage: null, // The image associated with the question
		category: null, // The category of the question
		tags: null, // The tags associated with the question
		rate: null, // The rate of the question
		answerrate: null, // The rate of the answer
		is_bookmark: null, // The bookmark status of the question
		viewstatus: null, // The view status of the question
		qaddeddate: null, // The date the question was added
		answeraddeddate: null // The date the answer was added
	},

	// The URL for this model
	url: '/TechQ/index.php/api/Question/',

	// The URL for the answers associated with this question
	urlAns: '/TechQ/index.php/api/Answer/',
});

/**
 * The QuestionCollection represents a collection of Questions models.
 *
 * @author Isuru Dissanayake
 */
app.collections.QuestionCollection = Backbone.Collection.extend({
	// The model for this collection
	model: app.models.Questions,

	// The API endpoint for this collection
	url: '/TechQ/index.php/api/Question/',
});
