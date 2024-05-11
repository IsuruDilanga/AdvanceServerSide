// Initialize the application object and its namespaces for views, routers, models, and collections.
var app = app || {};
app.views = {};
app.routers = {};
app.models = {};
app.collections = {};

/**
 * This function is used to validate the login form.
 * It retrieves the username and password input values from the form.
 * If either the username or password is not provided, it returns false.
 * Otherwise, it returns an object containing the username and password.
 *
 * @returns {Object|boolean} - An object containing the username and password, or false if either input is missing.
 */
function validateLoginForm() {
	var user = {	// Create an object to store the username and password
		'username': $("input#inputUsername").val(),
		'password': $("input#inputPassword").val()
	};
	if (!user.username || !user.password) {
		return false;
	}
	return user;	// Return the object containing the username and password
}

/**
 * This function is used to validate the registration form.
 * It retrieves the username, password, occupation, name, and email input values from the form.
 * It also checks if the email is valid by testing it against a regular expression.
 *
 * @returns {Object|string|boolean} - An object containing the user details, or a string "Invalid email address" if the email is invalid, or false if any input is missing.
 */
function validateRegisterForm() {
	var user = {	// Create an object to store the user details
		'username': $("input#regUsername").val(),
		'password': $("input#regPassword").val(),
		'occupation': $("select#regOccupation").val(),
		'name': $("input#regName").val(),
		'email': $("input#regEmail").val(),
	};

	var emailRegex = /\S+@\S+\.\S+/;	// Regular expression for email validation

	// Check if the email matches the regular expression for email validation
	if (!emailRegex.test(user.email)) {
		// If email is not valid, return false
		return "Invalid email address";
	}

	if (!user.username || !user.password || !user.occupation || !user.name || !user.email) {
		return false;
	}
	return user;	// Return the object containing the user details
}
/**
 * This function is used to validate the user profile update form.
 * It retrieves the image file from the '#upload_image_input' input field.
 *
 * @returns {Object} - An object containing the image file.
 */
function validateUpdateUserProfileForm() {
	var userImg = {
		'userimage': $("input#upload_image_input")[0].files[0]
	};

	return userImg;
}

/**
 * This function is used to validate the change password form.
 * It retrieves the old password, new password, and confirm password input values from the form.
 * It checks if the new password and confirm password are the same.
 * If they are not the same, it returns false.
 * It also checks if the old password, new password, and confirm password are provided.
 * If any of them is not provided, it returns false.
 * Otherwise, it returns an object containing the old password, new password, and confirm password.
 *
 * @returns {Object|boolean} - An object containing the old password, new password, and confirm password, or false if the new password and confirm password are not the same or any input is missing.
 */
function validateChangePasswordForm(){
	var userPass = {
		'oldpassword': $("input#oldPassword").val(),
		'newpassword': $("input#newPassword").val(),
		'confirmpassword': $("input#confirmPassword").val()
	};

	if(userPass.newpassword !== userPass.confirmpassword){
		return false;
	}

	if (!userPass.oldpassword || !userPass.newpassword || !userPass.confirmpassword) {
		return false;
	}

	return userPass;

}

/**
 * This function is used to validate the answer form.
 * It retrieves the answer text, answer image, rate, and current date and time from the form.
 * The answer text is processed to replace newline characters with '<br>' for HTML rendering.
 * The current date and time is formatted to an ISO string and the 'T' is replaced with a space.
 *
 * @returns {Object|boolean} - An object containing the answer details, or false if the answer text is not provided.
 */
function validateAnswerForm() {
	var answer = {
		'answer': $("textarea#inputQuestionDetails").val().replace(/\n/g, '<br>'),
		'answerimage': $("input#answerImageUpload")[0].files[0],
		'rate': $("select#questionrate").val(),
		'answeraddeddate': new Date().toISOString().slice(0, 19).replace('T', ' ')
	};

	if (!answer.answer) {
		return false;
	}

	return answer;
}

/**
 * This function is used to validate the search form.
 * It retrieves the search input value from the form.
 *
 * @returns {Object|boolean} - An object containing the search input value, or false if the search input is not provided.
 */
function validateSearchForm(){
	var search = {
		'search': $("input#searchHome").val()
	};

	if (!search.search) {
		return false;
	}

	return search;

}

/**
 * This function is used to validate the user details edit form.
 * It retrieves the username, name, email, and occupation input values from the form.
 *
 * @returns {Object|boolean} - An object containing the edited user details, or false if any input is missing.
 */
function validateEditUserDetailsAddForm(){
	// Remove disabled attribute temporarily

	var editUser = {
		'username': $("input#editusername").val(),
		'name': $("input#editname").val(),
		'email': $("input#editemail").val(),
		'occupation': $("select#editOccupation").val()
	};

	// Restore disabled attribute

	if (!editUser.username || !editUser.name || !editUser.email || !editUser.occupation) {
		return false;
	}

	return editUser;
}

/**
 * This function is used to validate the question addition form.
 * It retrieves the title, question, expectation, question image, category, tags, and current date and time from the form.
 * The question and expectation text are processed to replace newline characters with '<br>' for HTML rendering.
 * The current date and time is formatted to an ISO string and the 'T' is replaced with a space.
 * It checks if the question and expectation text have at least 20 characters.
 * It also checks if the number of tags is more than 5.
 * If any of these conditions are not met, it returns false.
 * If the title or category is not provided, it also returns false.
 * Otherwise, it returns an object containing the question details.
 *
 * @returns {Object|boolean} - An object containing the question details, or false if any input is missing or conditions are not met.
 */
function validateQuestionAddForm() {
	var question = {
		'title': $("input#inputQuestionTitle").val(),
		'question': $("textarea#inputQuestionDetails").val().replace(/\n/g, '<br>'),
		'expectationQ': $("textarea#inputQuestionExpectation").val().replace(/\n/g, '<br>'),
		'questionimage': $("input#imageUpload")[0].files[0], // Store the image file directly
		'category': $("select#questionCategory").val(),
		'tags': $("input#inputQuestionTags").val(),
		'qaddeddate': new Date().toISOString().slice(0, 19).replace('T', ' ')
	};

	console.log("question: " + question);
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

/**
 * This code block is executed when the DOM is fully loaded.
 * It initializes the application router and starts the Backbone history.
 * The 'app.appRouter = new app.routers.AppRouter();' line creates a new instance of the application router.
 * The 'Backbone.history.start();' line starts the Backbone history for pushState support.
 */
$(document).ready(function() {
	app.appRouter = new app.routers.AppRouter();	// Create a new instance of the application router
	$(function() {	// Execute the following code block when the DOM is fully loaded
		Backbone.history.start();	// Start the Backbone history for pushState support
	});
});
