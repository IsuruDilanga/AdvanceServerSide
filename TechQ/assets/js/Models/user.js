// Define the application namespace if it doesn't exist
var app = app || {};

/**
 * The User model represents a single user in the application.
 *
 * @author Isuru Dissanayake
 */
app.models.User = Backbone.Model.extend({
	// The API endpoint for this model
	urlRoot: '/TechQ/index.php/api/User/',

	// Default attributes for the user
	defaults: {
		name: "", // The name of the user
		email: "", // The email of the user
		username: "", // The username of the user
		password: "", // The password of the user
		user_id: null, // The ID of the user
		occupation: "", // The occupation of the user
		premium: false, // The premium status of the user
		userimage: "", // The image of the user
		answerquestioncnt: null, // The count of answered questions by the user
		askquestioncnt: null, // The count of asked questions by the user
	},

	// The URL for this model
	url: '/TechQ/index.php/api/User/',

	// The URL for the questions asked by this user
	urlAskQuestion: '/TechQ/index.php/api/Question/',

	// The URL for the answers provided by this user
	urlAnswerQuestion: '/TechQ/index.php/api/Answer/'
});
