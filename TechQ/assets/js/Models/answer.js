// Define the application namespace if it doesn't exist
var app = app || {};

/**
 * The Answers model represents a single answer in the application.
 *
 * @author Isuru Dissanayake
 */
app.models.Answers = Backbone.Model.extend({
	// The API endpoint for this model
	urlRoot: '/TechQ/index.php/api/Answer/',

	// Default attributes for the answer
	defaults:{
		answerid: "", // The ID of the answer
		questionid: null, // The ID of the question the answer is associated with
		userid: null, // The ID of the user who posted the answer
		answeraddeduserid: null, // The ID of the user who added the answer
		user_id:"", // The ID of the user
		answer: null, // The text of the answer
		answerimage: null, // The image associated with the answer
		answerrate: null, // The rating of the answer
		rate: null, // The rate of the answer
		questionrate: null, // The rate of the question
		viewstatus: null, // The view status of the answer
		answeraddeddate: null // The date the answer was added
	},

	// The URL for this model
	url: '/TechQ/index.php/api/Answer/',
});

/**
 * The AnswerCollection represents a collection of Answers models.
 *
 * @author Isuru Dissanayake
 */
app.collections.AnswerCollection = Backbone.Collection.extend({
	// The model for this collection
	model: app.models.Answers,

	// The API endpoint for this collection
	url: '/TechQ/index.php/api/Answer/',
});
