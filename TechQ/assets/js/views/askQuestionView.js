/**
 * This is the AddQuestionView which extends from Backbone.View.
 * It is responsible for adding a new question to the application.
 *
 * @property {String} el - The DOM element associated with this view. It is set to '.container'.
 *
 * @method initialize - This method is called when the view is first created. It sets up event listeners and binds events.
 * @method bindEvents - This method binds the 'click' event on the '#submit_question' element to the 'submitquestion' method.
 * @method render - This method is responsible for rendering the view. It compiles the template found in the '#add_question_template' script tag and renders it into the view's element.
 * @method submitquestion - This method is called when the '#submit_question' element is clicked. It validates the form, uploads the image, and sends a POST request to the server to add the question.
 * @method home_search - This method is called when the '#homesearch' element is clicked. It validates the search form and sends a GET request to the server to search for questions.
 */
var app = app || {};

app.views.AddQuestionView = Backbone.View.extend({
	// The DOM element associated with this view
	el: '.container',

	// This method is called when the view is first created
	initialize:function (){
		// Set up event listeners
		this.listenTo(this.model, 'change', this.render);
		// Bind events
		this.bindEvents();
	},

	// This method binds the 'click' event on the '#submit_question' element to the 'submitquestion' method
	bindEvents: function(){
		this.$el.off('click', '#submit_question').on('click', '#submit_question', this.submitquestion.bind(this));
	},

	// This method is responsible for rendering the view
	render:function () {
		// Compile the template found in the '#add_question_template' script tag
		template = _.template($('#add_question_template').html());
		this.$el.html(template(this.model.attributes));        // Render the compiled template into the view's element with the model's attributes

		// Create a new NavBarView with the user model and render it
		app.navView = new app.views.NavBarView({model: app.user});
		app.navView.render();

	},

	// The events hash maps DOM events to methods on the view
	events: {
		'click #submit_question': 'submitquestion',
		"click #homesearch": "home_search"
	},

	// This method is called when the '#submit_question' element is clicked
	submitquestion: function(e) {

		// Prevent the default action and stop the event propagation
		e.preventDefault();
		e.stopPropagation();

		// console.log('submitting question');
		// userJson = JSON.parse(localStorage.getItem('user'));
		// app.user = new app.models.User(userJson);

		var validateQuestionForm = validateQuestionAddForm(); // Validate the question form

		// If the form is not valid, show an error message
		if (!validateQuestionForm) {
			new Noty({
				type: 'error',
				text: 'Please check if the requirements are satisfied or not',
				timeout: 2000
			}).show();
		} else {
			var formData = new FormData();	// Create a new FormData object
			var imageFile = $('#imageUpload')[0].files[0];	// Get the image file from the form
			formData.append('image', imageFile);	// Append the image file to the FormData object


			// Upload the image to the server
			$.ajax({
				url: this.model.url + 'ask_question_image',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: (response) => {
					validateQuestionForm.questionimage = response.imagePath; // Assuming the server returns the image path
					this.model.set(validateQuestionForm);	// Set the model attributes to the validated form data
					var url = this.model.urlAskQuestion + "addquestion";	// Set the URL for the POST request

					// Save the model to the server
					this.model.save(this.model.attributes, {
						"url": url,
						success: (model, response) => {
							new Noty({
								type: 'success',
								text: 'Question added successfully',
								timeout: 2000
							}).show();

							$userJson = JSON.parse(localStorage.getItem("user"));	// Get the user from local storage
							$userJson['askquestioncnt'] = parseInt($userJson['askquestioncnt']) + 1;	// Increment the ask question count

							localStorage.setItem("user", JSON.stringify($userJson));	// Save the user to local storage

							// Clear the form fields
							$('#inputQuestionTitle').val('');
							$('#inputQuestionDetails').val('');
							$('#inputQuestionExpectation').val('');
							$('#inputQuestionTags').val('');
							$('#questionCategory').val('');
							$('#imageUpload').val('');
						},
						error: (model, response) => {
							console.log('error', model, response);
							new Noty({
								type: 'error',
								text: 'Error adding question',
								timeout: 2000
							}).show();
						}
					});
				},
				error: (xhr, status, error) => {
					console.error('Error uploading image:', error);
					new Noty({
						type: 'error',
						text: 'Error uploading image',
						timeout: 2000
					}).show();
				}
			});
		}

	},

	// This method is called when the '#homesearch' element is clicked
	home_search: function(e){
		e.preventDefault();	// Prevent the default action
		e.stopPropagation();	// Stop the event propagation

		var validateAnswer = validateSearchForm();	// Validate the search form

		var searchWord = $("#searchHome").val();	// Get the search word from the form

		// If the form is not valid, show an error message
		if(searchWord != ""){

			app.user = new app.models.User(userJson);	// Create a new User model

			// Create a new homeView with a new QuestionCollection
			app.homeView = new app.views.homeView({collection: new app.collections.QuestionCollection()});

			var url = app.homeView.collection.url + "displaySearchQuestions/"+searchWord;	// Set the URL for the GET request

			// Fetch the collection from the server
			app.homeView.collection.fetch({
				reset: true,
				"url": url,
				success: function(collection, response){
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
		}else {

			app.user = new app.models.User(userJson);	// Create a new User model

			// Create a new homeView with a new QuestionCollection
			app.homeView = new app.views.homeView({collection: new app.collections.QuestionCollection()});

			var url = app.homeView.collection.url + "displayAllQuestions";	// Set the URL for the GET request

			// Fetch the collection from the server
			app.homeView.collection.fetch({
				reset: true,
				"url": url,
				success: function(collection, response){
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

})
