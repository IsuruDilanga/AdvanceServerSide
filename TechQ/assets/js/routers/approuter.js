// Define the application namespace if it doesn't exist
var app = app || {};

/**
 * The AppRouter is responsible for handling the navigation and routing for the application.
 *
 * @author Isuru Dissanayake
 */
app.routers.AppRouter = Backbone.Router.extend({

	// Define the routes for the application
	routes: {
		"": "login", // Route for the login page
		"home": "home", // Route for the home page
		"home/askquestion": "askquestion", // Route for the ask question page
		"home/answerquestion/:questionid": "answerquestion", // Route for the answer question page, with a dynamic segment for the question ID
		"home/bookmark/:userid": "bookmark", // Route for the bookmark page, with a dynamic segment for the user ID
		"home/user/:userid": "user", // Route for the user page, with a dynamic segment for the user ID
		"logout": "logout" // Route for the logout action
	},

	/**
	 * This function handles the login route of the application.
	 *
	 * @author Isuru Dissanayake
	 */
	login: function () {

		// Retrieve the user data from local storage and parse it as JSON
		userJson = JSON.parse(localStorage.getItem("user"));

		// If there is no user data in local storage
		if(userJson == null){

			// If the login view does not exist
			if(!app.loginView) {
				// Create a new user model
				app.user = new app.models.User();

				// Create a new login form view with the user model
				app.loginView = new app.views.LoginFormView({ model: app.user });

				// Render the login form view
				app.loginView.render();
			}
		} else {
			// If there is user data in local storage, navigate to the home route
			this.home();
		}
	},

	// login: function () {
	// 	userJson = JSON.parse(localStorage.getItem("user"));
	// 	if(userJson == null){
	// 		if(!app.loginView) {
	// 			app.user = new app.models.User();
	// 			app.loginView = new app.views.LoginFormView({ model: app.user });
	// 			app.loginView.render();
	// 		}
	// 	}else {
	// 		this.home();
	// 	}
	// },

	/**
	 * This function handles the user route of the application.
	 * It retrieves the user data from local storage and parses it as JSON.
	 * If there is user data in local storage, it creates a new user model with the user data,
	 * creates a new user view with the user model, and renders the user view.
	 *
	 * @param {string} userid - The ID of the user.
	 * @author Isuru Dissanayake
	 */
	user: function (userid){

		// Retrieve the user data from local storage and parse it as JSON
		userJson = JSON.parse(localStorage.getItem("user"));

		// If there is user data in local storage
		if(userJson != null) {

			// Create a new user model with the user data
			app.user = new app.models.User(userJson);

			// Create a new user view with a new user model
			app.userView = new app.views.UserView({model: new app.models.User()});

			// Render the user view
			app.userView.render();
		}
	},

	// user: function (userid){
	// 	console.log("user route");
	// 	console.log("userid: "+ userid);
	// 	userJson = JSON.parse(localStorage.getItem("user"));
	//
	// 	if(userJson != null) {
	// 		app.user = new app.models.User(userJson);
	// 		console.log("if");
	//
	// 		app.userView = new app.views.UserView({model: new app.models.User()});
	//
	// 		app.userView.render();
	//
	// 	}
	//
	// },

	/**
	 * This function handles the bookmark route of the application.
	 * It retrieves the user data from local storage and parses it as JSON.
	 * If there is user data in local storage, it creates a new user model with the user data,
	 * creates a new bookmark view with a new question collection, and fetches the bookmarked questions.
	 * If there is an error during fetching, it logs the error and renders the bookmark view.
	 * If there is no user data in local storage, it navigates to the login route.
	 *
	 * @param {string} userid - The ID of the user.
	 * @author Isuru Dissanayake
	 */
	bookmark: function(userid){

		// Retrieve the user data from local storage and parse it as JSON
		userJson = JSON.parse(localStorage.getItem("user"));

		// If there is user data in local storage
		if(userJson != null){

			// Create a new user model with the user data
			app.user = new app.models.User(userJson);

			// Define the URL for fetching the bookmarked questions
			var url = app.user.urlAskQuestion + "bookmarkQuestions/"+userid;


			// Create a new bookmark view with a new question collection
			app.bookmarkView = new app.views.bookmarkView({collection: new app.collections.QuestionCollection()});

			// Fetch the bookmarked questions
			app.bookmarkView.collection.fetch({
				reset: true,
				"url": url,
				success: function(collection, response){

					// Render the bookmark view
					app.bookmarkView.render();
				},
				error: function(model, xhr, options){
					// If there is an error during fetching
					if(xhr.status == 404){

						// Render the bookmark view
						app.bookmarkView.render();
					}

				}
			});
		} else {
			// If there is no user data in local storage, navigate to the login route
			app.appRouter.navigate("", {trigger: true});
		}
	},

	// bookmark: function(userid){
	// 	console.log("bookmark route");
	// 	userJson = JSON.parse(localStorage.getItem("user"));
	// 	$userid = userJson.user_id;
	// 	console.log("user"+userJson);
	// 	if(userJson != null){
	// 		app.user = new app.models.User(userJson);
	// 		console.log("if");
	//
	// 		var url = app.user.urlAskQuestion + "bookmarkQuestions/"+$userid;
	// 		console.log("url: "+ url);
	//
	// 		app.bookmarkView = new app.views.bookmarkView({collection: new app.collections.QuestionCollection()});
	//
	// 		app.bookmarkView.collection.fetch({
	// 			reset: true,
	// 			"url": url,
	// 			success: function(collection, response){
	// 				console.log("response: "+ response);
	// 				app.bookmarkView.render();
	// 			},
	// 			error: function(model, xhr, options){
	// 				if(xhr.status == 404){
	// 					console.log("error 404");
	// 					app.bookmarkView.render();
	// 				}
	// 				console.log("error");
	// 			}
	// 		});
	// 	}else {
	// 		app.appRouter.navigate("", {trigger: true});
	// 		console.log("else")
	// 	}
	// },

	/**
	 * This function handles the home route of the application.
	 * It retrieves the user data from local storage and parses it as JSON.
	 * If there is user data in local storage, it creates a new user model with the user data,
	 * creates a new home view with a new question collection, and fetches all questions.
	 * If there is an error during fetching, it logs the error and renders the home view.
	 * If there is no user data in local storage, it navigates to the login route.
	 *
	 * @author Isuru Dissanayake
	 */
	home: function(){

		// Retrieve the user data from local storage and parse it as JSON
		userJson = JSON.parse(localStorage.getItem("user"));


		// If there is user data in local storage
		if (userJson != null){

			// Create a new user model with the user data
			app.user = new app.models.User(userJson);

			// Create a new home view with a new question collection
			app.homeView = new app.views.homeView({collection: new app.collections.QuestionCollection()});

			// Define the URL for fetching all questions
			var url = app.homeView.collection.url + "displayAllQuestions";

			// Fetch all questions
			app.homeView.collection.fetch({
				reset: true,
				"url": url,
				success: function(collection, response){

					// Render the home view
					app.homeView.render();
				},
				error: function(model, xhr, options){
					// If there is an error during fetching
					if(xhr.status == 404){
						// Render the home view
						app.homeView.render();
					}
				}
			});
		} else {
			// If there is no user data in local storage, navigate to the login route
			app.appRouter.navigate("", {trigger: true});

		}
	},

	// home: function(){
	// 	console.log("home route");
	// 	userJson = JSON.parse(localStorage.getItem("user"));
	// 	console.log(userJson);
	//
	// 	if (userJson != null){
	// 		app.user = new app.models.User(userJson);
	// 		console.log("user: "+ app.user);
	//
	// 		// Render the home view and fetch questions
	// 		app.homeView = new app.views.homeView({collection: new app.collections.QuestionCollection()});
	//
	// 		var url = app.homeView.collection.url + "displayAllQuestions";
	// 		// console.log("url: "+ url);
	// 		app.homeView.collection.fetch({
	// 			reset: true,
	// 			"url": url,
	// 			success: function(collection, response){
	// 				console.log("response: "+ response);
	//
	// 				app.homeView.render();
	// 			},
	// 			error: function(model, xhr, options){
	// 				if(xhr.status == 404){
	// 					// console.log("error 404");
	// 					app.homeView.render();
	// 				}
	// 				// console.log("error");
	// 			}
	// 		});
	// 	} else {
	// 		app.appRouter.navigate("", {trigger: true});
	// 		console.log("else")
	// 	}
	// },

	/**
	 * This function handles the ask question route of the application.
	 * It retrieves the user data from local storage and parses it as JSON.
	 * If there is user data in local storage, it creates a new user model with the user data,
	 * creates a new ask question view with the user model, and renders the ask question view.
	 * If there is no user data in local storage, it navigates to the login route.
	 *
	 * @author Isuru Dissanayake
	 */
	askquestion: function (){

		// Retrieve the user data from local storage and parse it as JSON
		userJson = JSON.parse(localStorage.getItem("user"));

		// If there is user data in local storage
		if(userJson != null){

			// Create a new user model with the user data
			app.user = new app.models.User(userJson);

			// Create a new ask question view with the user model
			app.askQuestionView = new app.views.AddQuestionView({model: app.user});

			// Render the ask question view
			app.askQuestionView.render();
		}else {
			// If there is no user data in local storage, navigate to the login route
			app.appRouter.navigate("", {trigger: true});
		}
	},

	// askquestion: function (){
	// 	console.log("askQuestion route");
	// 	userJson = JSON.parse(localStorage.getItem("user"));
	// 	console.log("user"+userJson);
	// 	if(userJson != null){
	// 		app.user = new app.models.User(userJson);
	// 		console.log("if");
	//
	// 		app.askQuestionView = new app.views.AddQuestionView({model: app.user});
	// 		app.askQuestionView.render();
	// 	}else {
	// 		app.appRouter.navigate("", {trigger: true});
	// 		console.log("else")
	// 	}
	// },

	/**
	 * This function handles the answer question route of the application.
	 * It retrieves the user data from local storage and parses it as JSON.
	 * If there is user data in local storage, it fetches the question details and checks if the question is bookmarked.
	 * If the question is bookmarked, it creates a new answer question view with the question model and a new answer collection, and fetches the answers.
	 * If there is an error during fetching, it logs the error.
	 * If there is no user data in local storage, it navigates to the login route.
	 *
	 * @param {string} questionid - The ID of the question.
	 * @author Isuru Dissanayake
	 */
	answerquestion:function (questionid){

		// Retrieve the user data from local storage and parse it as JSON
		userJson = JSON.parse(localStorage.getItem("user"));
		$user_id = userJson.user_id;

		// If there is user data in local storage
		if(userJson != null){

			// Create a new user model with the user data
			app.user = new app.models.User(userJson);

			var url = app.user.urlAskQuestion + "displayAllQuestions/" + questionid;

			// Fetch the question details
			app.user.fetch({
				"url": url,
				success: function(model, responseQ){

					// Add the username and user ID to the response
					responseQ['username'] = app.user.get("username");
					responseQ['user_id'] = $user_id;

					// Create a new question model with the response
					var questionModel = new app.models.Questions(responseQ);

					// Define the URL for checking if the question is bookmarked
					var urlBookmark = app.user.urlAskQuestion + "getBookmark";

					// Check if the question is bookmarked
					$.ajax({
						url: urlBookmark,
						type: "POST",
						data: {
							"questionid": questionid,
							"userid": $user_id
						},
						success: function(responseB){

							if(responseB.is_bookmark){
								// Set the is_bookmark attribute of the question model to true
								questionModel.set("is_bookmark", true);
								questionModel.set("user_id", $user_id);

								// Create a new answer question view with the question model and a new answer collection
								app.ansQuestionView = new app.views.AnswerQuestionView({
									model: questionModel,
									collection: new app.collections.AnswerCollection(),
									bookmark: true,
								});
							}else {

								// Set the is_bookmark attribute of the question model to false
								questionModel.set("is_bookmark", false);
								app.ansQuestionView = new app.views.AnswerQuestionView({
									model: questionModel,
									collection: new app.collections.AnswerCollection(),
									bookmark: false,
								});
							}

							// Define the URL for fetching the answers
							var answerUrl = app.ansQuestionView.collection.url + "getAnswers/" + questionid;

							// Fetch the answers
							app.ansQuestionView.collection.fetch({
								reset: true,
								"url": answerUrl,
								success: function (collection, response) {

									// Set the user ID for each model in the collection
									collection.each(function (model) {
										model.set("user_id", $user_id);
									});
									response['user_id'] = $user_id;
									app.ansQuestionView.render();
								},
								error: function (model, xhr, options) {
									if (xhr.status == 404) {
										console.log("error 404");
									}
									console.log("error");
								}
							});

							// app.ansQuestionView.render();
						},
						error: function(model, xhr, options){
							if(xhr.status == 404){
								console.log("error 404");
							}
							console.log("error");
						}
					});

				},
				error: function(model, xhr, options){
					if(xhr.status == 404){
						console.log("error 404");
						// app.ansQuestionView = new app.views.AnswerQuestionView({model: app.askQue});
						// app.ansQuestionView.render();
					}
					console.log("error");
				}
			})

		}else {
			app.appRouter.navigate("", {trigger: true});
		}
	},

	/**
	 * This function handles the logout route of the application.
	 * It clears the local storage and sends a POST request to the server to logout the user.
	 * If the logout is successful, it redirects the user to the login page.
	 * If there is an error during the logout process, it logs the error.
	 *
	 * @author Isuru Dissanayake
	 */
	logout: function(){
		// Log the start of the logout route
		console.log("logout route");

		// Clear the local storage
		localStorage.clear();

		// Define the URL for the logout request
		var url = app.user.url + "logout";

		// Send a POST request to the server to logout the user
		$.ajax({
			url: url,
			type: "POST",
			success: function (response) {
				// If the logout is successful, redirect the user to the login page
				window.location.href = "";
			},
			error: function(model, xhr, options){
				// If there is an error during the logout process
				if(xhr.status == 404){
					// Log the error
					console.log("error 404");
				}

				// Log the error
				console.log("error");
			}
		});
	}


});
