/**
 * This is the homeView which extends from Backbone.View.
 * It is responsible for rendering the home page of the application.
 *
 * @property {String} el - The DOM element associated with this view. It is set to '.container'.
 *
 * @method render - This method is responsible for rendering the view.
 * It first compiles the template found in the '#home_template' script tag.
 * It then renders the compiled template into the view's element with the user's attributes.
 * After that, it creates a new NavBarView with the user model and renders it.
 * Finally, it iterates over the collection of questions, creates a new QuestionView for each question, and renders it.
 *
 * @method ask_question - This method is called when the '#ask_question_btn' element is clicked.
 * It prevents the default action, stops the event propagation, logs the action, and navigates to the 'home/askquestion' route.
 *
 * @method home_search - This method is called when the '#homesearch' element is clicked.
 * It prevents the default action, stops the event propagation, validates the search form, and sends a GET request to the server to search for questions.
 */
var app = app || {};

app.views.homeView = Backbone.View.extend({
	el: ".container",

	render: function() {
		// Compile the template found in the '#home_template' script tag
		template = _.template($('#home_template').html());
		// Render the compiled template into the view's element with the user's attributes
		this.$el.html(template(app.user.attributes));

		// Create a new NavBarView with the user model and render it
		app.navView = new app.views.NavBarView({model: app.user});
		app.navView.render();

		// Iterate over the collection of questions
		this.collection.each(function(question){
			// Create a new QuestionView for each question and render it
			var questionView = new app.views.QuestionView({model: question});
			questionView.render();
		});

	},

	// The events hash maps DOM events to methods on the view
	events:{
		"click #ask_question_btn": "ask_question",
		"click #homesearch": "home_search",
	},

	// This method is called when the '#ask_question_btn' element is clicked
	ask_question: function(e){

		// Prevent the default action and stop the event propagation
		e.preventDefault();
		e.stopPropagation();

		app.appRouter.navigate("home/askquestion", {trigger: true});         // Navigate to the 'home/askquestion' route
	},

	// This method is called when the '#homesearch' element is clicked
	home_search: function(e){
		e.preventDefault();
		e.stopPropagation();

		var validateAnswer = validateSearchForm();	// Validate the search form

		var searchWord = $("#searchHome").val();	// Get the search word from the search form

		// If the search form is not valid, return
		if(searchWord != ""){

			app.user = new app.models.User(userJson);	// Create a new user model with the userJson
			app.homeView = new app.views.homeView({collection: new app.collections.QuestionCollection()});	// Create a new homeView with a new QuestionCollection

			var url = app.homeView.collection.url + "displaySearchQuestions/"+searchWord;	// Set the url to search for questions

			// Fetch the collection of questions from the server
			app.homeView.collection.fetch({
				reset: true,
				"url": url,
				// If the fetch is successful, render the homeView
				success: function(collection, response){
					console.log("response: "+ response);
					app.homeView.render();	// Render the homeView
				},
				error: function(model, xhr, options){
					if(xhr.status == 404){
						console.log("error 404");
						app.homeView.render();
					}
					console.log("error");
				}
			});
		}else {

			// If the search form is not valid, return
			app.user = new app.models.User(userJson);
			app.homeView = new app.views.homeView({collection: new app.collections.QuestionCollection()});	// Create a new homeView with a new QuestionCollection

			var url = app.homeView.collection.url + "displayAllQuestions";	// Set the url to display all questions

			// Fetch the collection of questions from the server
			app.homeView.collection.fetch({
				reset: true,
				"url": url,
				// If the fetch is successful, render the homeView
				success: function(collection, response){
					console.log("response: "+ response);
					app.homeView.render();
				},
				error: function(model, xhr, options){
					if(xhr.status == 404){
						console.log("error 404");
						app.homeView.render();
					}
					console.log("error");
				}
			});
		}

	}
});
