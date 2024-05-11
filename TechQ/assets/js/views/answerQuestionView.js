var app = app || {};

/**
 * This is the AnswerQuestionView class which extends from Backbone.View.
 * It is responsible for rendering the view for answering a question.
 * It listens to changes in the model and the collection, and re-renders the view when these changes occur.
 * It also binds the necessary events for the view during initialization.
 *
 * @class AnswerQuestionView
 * @extends {Backbone.View}
 * @author Isuru Dissanayake
 */
app.views.AnswerQuestionView = Backbone.View.extend({
	// Specify the DOM element to which this view is attached
	el: '.container',

	/**
	 * This is the initialize function of the AnswerQuestionView class.
	 * It sets up event listeners for changes in the model and the collection.
	 * It also binds the necessary events for the view.
	 */
	initialize: function() {
		// Listen for any changes in the model. If the model changes, the render function is called.
		this.listenTo(this.model, 'change', this.render);

		// Listen for any reset events in the collection. If the collection is reset, the render function is called.
		this.listenTo(this.collection, 'reset', this.render);

		// Call the bindEvents function to bind the necessary events for the view.
		this.bindEvents();
	},

	/**
	 * This function binds the necessary events to the DOM elements of the view.
	 * It uses jQuery's on and off methods to first remove any previous event handlers and then attach new ones.
	 * The events are bound to the methods of this view with the correct context (this) using the bind method.
	 */
	bindEvents: function() {
		// Remove any previous click event handlers on the '#submit_answer' element and attach a new one that calls the submitAnswer method
		this.$el.off('click', '#submit_answer').on('click', '#submit_answer', this.submitAnswer.bind(this));

		// Remove any previous click event handlers on the '#up-question-view' element and attach a new one that calls the upQuestionView method
		this.$el.off('click', '#up-question-view').on('click', '#up-question-view', this.upQuestionView.bind(this));

		// Remove any previous click event handlers on the '#down-question-view' element and attach a new one that calls the downQuestionView method
		this.$el.off('click', '#down-question-view').on('click', '#down-question-view', this.downQuestionView.bind(this));

		// Remove any previous click event handlers on the '#remove-bookmark' element and attach a new one that calls the removeBookmark method
		this.$el.off('click', '#remove-bookmark').on('click', '#remove-bookmark', this.removeBookmark.bind(this));

		// Remove any previous click event handlers on the '#add-bookmark' element and attach a new one that calls the addBookmark method
		this.$el.off('click', '#add-bookmark').on('click', '#add-bookmark', this.addBookmark.bind(this));

		// Remove any previous click event handlers on the '#delete_question' element and attach a new one that calls the deleteQuestion method
		this.$el.off('click', '#delete_question').on('click', '#delete_question', this.deleteQuestion.bind(this));

		// Remove any previous click event handlers on the '#delete_answer' element and attach a new one that calls the deleteAnswer method
		this.$el.off('click', '#delete_answer').on('click', '#delete_answer', this.deleteAnswer.bind(this));
	},

	/**
	 * This function is responsible for rendering the AnswerQuestionView.
	 * It first logs the start of the rendering process and the attributes of the model.
	 * It then compiles the template found in the '#answer-question-template' script tag using underscore's template function.
	 * The compiled template is then rendered into the view's element with the model's attributes.
	 * A new NavBarView is created with the user model and rendered.
	 * Finally, for each answer in the collection, a new AnswerView is created and rendered.
	 *
	 * @author Isuru Dissanayake
	 */
	render: function() {
		// Compile the template found in the '#answer-question-template' script tag
		template = _.template($('#answer-question-template').html());
		// Render the compiled template into the view's element with the model's attributes
		this.$el.html(template(this.model.attributes));

		// Create a new NavBarView with the user model and render it
		app.navView = new app.views.NavBarView({ model: app.user });
		app.navView.render();

		// For each answer in the collection, create a new AnswerView and render it
		this.collection.each(function(answer) {
			var answerView = new app.views.AnswerView({ model: answer });
			answerView.render();
		});
	},

	/**
	 * This is the events hash for the AnswerQuestionView.
	 * It maps DOM events to methods on the view.
	 * When a DOM event happens on the view's element, the corresponding method is called.
	 *
	 * @property {Object} events
	 * @property {Function} events.'click #submit_answer' - Calls the 'submitAnswer' method when the element with id 'submit_answer' is clicked.
	 * @property {Function} events.'click #up-question-view' - Calls the 'upQuestionView' method when the element with id 'up-question-view' is clicked.
	 * @property {Function} events.'click #down-question-view' - Calls the 'downQuestionView' method when the element with id 'down-question-view' is clicked.
	 * @property {Function} events.'click #remove-bookmark' - Calls the 'removeBookmark' method when the element with id 'remove-bookmark' is clicked.
	 * @property {Function} events.'click #add-bookmark' - Calls the 'addBookmark' method when the element with id 'add-bookmark' is clicked.
	 * @property {Function} events.'click #delete_question' - Calls the 'deleteQuestion' method when the element with id 'delete_question' is clicked.
	 * @property {Function} events.'click #delete_answer' - Calls the 'deleteAnswer' method when the element with id 'delete_answer' is clicked.
	 */
	events: {
		'click #submit_answer': 'submitAnswer',
		'click #up-question-view': 'upQuestionView',
		'click #down-question-view': 'downQuestionView',
		'click #remove-bookmark': 'removeBookmark',
		'click #add-bookmark': 'addBookmark',
		'click #delete_question': 'deleteQuestion',
		'click #delete_answer': 'deleteAnswer',
	},

	/**
	 * This function is responsible for deleting an answer.
	 * It first retrieves the answerid, userid, and answerimage from the clicked button's data attributes.
	 * It then constructs an object with these values and sends a POST request to the server to delete the answer.
	 * If the deletion is successful, it shows a success notification, decreases the answer count of the user, and reloads the page.
	 * If there is an error during the deletion process, it shows an error notification.
	 *
	 * @param {Event} event - The event object from the click event.
	 */
	deleteAnswer: function (event){

		// Retrieve answerid and userid from the clicked button's data attributes
		var answerid = $(event.currentTarget).data('answerid');
		var userid = $(event.currentTarget).data('userid');
		var answerimage = $(event.currentTarget).data('answerimage');

		// Construct an object with the retrieved values
		var dltanswer = {
			answerid: answerid,
			userid: userid,
			answerimage: answerimage
		};

		var url = this.model.urlAns +  'delete_answer';

		// If the answerid is not empty or null, send a POST request to the server to delete the answer
		if(answerid != "" && answerid != null) {
			app.user.fetch({
				"url": url,
				type: 'POST',
				data: dltanswer,
				success: (response) => {

					// Show a success notification
					new Noty({
						type: 'success',
						text: 'Answer deleted',
						timeout: 2000
					}).show();

					// Retrieve the user data from local storage
					$userJson = JSON.parse(localStorage.getItem("user"));

					// Decrease the answer count of the user
					$userJson['answerquestioncnt'] = parseInt($userJson['answerquestioncnt']) - 1;

					// Update the user data in local storage
					localStorage.setItem("user", JSON.stringify($userJson));

					// Reload the page
					window.location.reload();
				},
				error: (xhr, status, error) => {
					console.error('Error deleting answer:', error);
					new Noty({
						type: 'error',
						text: 'Error deleting answer',
						timeout: 2000
					}).show();
				}
			});
		}
	},

	/**
	 * This function is responsible for deleting a question.
	 * It first retrieves the questionid from the current URL and the userid from the local storage.
	 * It then constructs an object with these values and sends a POST request to the server to delete the question.
	 * If the deletion is successful, it shows a success notification, decreases the question count of the user, and navigates to the home page.
	 * If there is an error during the deletion process, it shows an error notification.
	 */
	deleteQuestion: function(){

		var currentUrl = window.location.href;

		// Extract the last part of the URL after the last '/'
		var lastPart = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);

		// Extract the numeric part from the last part (assuming it's always at the end)
		var $questionid = parseInt(lastPart.match(/\d+$/)[0]);

		$userJson = JSON.parse(localStorage.getItem("user")); // Retrieve the user data from local storage
		$userid = $userJson['user_id']; // Extract the userid from the user data

		// Construct an object with the retrieved questionid and userid
		var dltquestion = {
			questionid: $questionid,
			userid: $userid
		};

		var url = this.model.url + 'delete_question';	  // Construct the URL for the delete question request

		// If the questionid is not empty or null, send a POST request to the server to delete the question
		if($questionid != "" && $questionid != null) {
			app.user.fetch({
				"url": url,
				type: 'POST',
				data: dltquestion,
				success: (response) => {

					// Show a success notification
					new Noty({
						type: 'success',
						text: 'Question deleted',
						timeout: 2000
					}).show();

					// Retrieve the user data from local storage
					$userJson = JSON.parse(localStorage.getItem("user"));
					$userJson['askquestioncnt'] = parseInt($userJson['askquestioncnt']) - 1;	// Decrease the question count of the user

					localStorage.setItem("user", JSON.stringify($userJson));	 // Update the user data in local storage
					// window.location.href = '/';
					app.appRouter.navigate("home", {trigger: true});	 // Navigate to the home page

				},
				error: (xhr, status, error) => {
					console.error('Error deleting question:', error);
					new Noty({
						type: 'error',
						text: 'Error deleting question',
						timeout: 2000
					}).show();
				}
			});
		}

	},

	/**
	 * This function is responsible for adding a bookmark to a question.
	 * It first retrieves the questionid and userid from the current URL and the local storage.
	 * It then constructs an object with these values and sends a POST request to the server to add the bookmark.
	 * If the addition is successful, it shows a success notification and changes the bookmark icon to a solid icon.
	 * If there is an error during the addition process, it shows an error notification.
	 */
	addBookmark: function (){

		var currentUrl = window.location.href;

		// Extract the last part of the URL after the last '/'
		var lastPart = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);

		// Extract the numeric part from the last part (assuming it's always at the end)
		var $questionid = parseInt(lastPart.match(/\d+$/)[0]);

		$userJson = JSON.parse(localStorage.getItem("user")); // Retrieve the user data from local storage
		$userid = $userJson['user_id'];	// Extract the userid from the user data

		var $bookmarkIcon = $('#add-bookmark'); // Retrieve the bookmark icon element

		// Construct an object with the retrieved questionid and userid
		var rBookmark = {
			questionid: $questionid,
			userid: $userid
		};

		var url = this.model.url + 'add_bookmark'; 	// Construct the URL for the add bookmark request

		//send a POST request to the server to add the bookmark
		$.ajax({
			"url": url,
			type: 'POST',
			data: rBookmark,
			success: (response) => {

				$bookmarkIcon.removeClass('fa-regular').addClass('fa-solid'); // Change icon to solid
				$bookmarkIcon.attr('id', 'remove-bookmark');
				new Noty({
					type: 'success',
					text: 'Bookmark add',
					timeout: 2000,
				}).show();

			},
			error: (xhr, status, error) => {
				console.error('Error adding bookmark:', error);
				new Noty({
					type: 'error',
					text: 'Error adding bookmark',
					timeout: 2000
				}).show();

			},
		});

	},

	/**
	 * This function is responsible for removing a bookmark from a question.
	 * It first retrieves the questionid and userid from the current URL and the local storage.
	 * It then constructs an object with these values and sends a POST request to the server to remove the bookmark.
	 * If the removal is successful, it shows a warning notification and changes the bookmark icon to a regular icon.
	 * If there is an error during the removal process, it shows an error notification.
	 */
	removeBookmark: function (){

		var currentUrl = window.location.href;

		// Extract the last part of the URL after the last '/'
		var lastPart = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);

		// Extract the numeric part from the last part (assuming it's always at the end)
		var $questionid = parseInt(lastPart.match(/\d+$/)[0]);


		$userJson = JSON.parse(localStorage.getItem("user")); // Retrieve the user data from local storage
		$userid = $userJson['user_id']; // Extract the userid from the user data

		var $bookmarkIcon = $('#remove-bookmark');	// Retrieve the bookmark icon element

		// Construct an object with the retrieved questionid and userid
		var rBookmark = {
			questionid: $questionid,
			userid: $userid
		};

		var url = this.model.url + 'remove_bookmark';	// Construct the URL for the remove bookmark request

		// If the questionid is not empty or null, send a POST request to the server to remove the bookmark
		if($questionid != "" && $questionid != null) {
			app.user.fetch({
				"url": url,
				type: 'POST',
				data: rBookmark,
				success: (response) => {
					$bookmarkIcon.removeClass('fa-solid').addClass('fa-regular'); // Change icon to regular
					$bookmarkIcon.attr('id', 'add-bookmark');
					new Noty({
						type: 'warning',
						text: 'Bookmark removed',
						timeout: 2000
					}).show();

				},
				error: (xhr, status, error) => {
					console.error('Error removing bookmark:', error);
					new Noty({
						type: 'error',
						text: 'Error removing bookmark',
						timeout: 2000
					}).show();
				}
			});
		}
	},

	/**
	 * This function is responsible for upvoting a question.
	 * It first retrieves the questionid from the current URL.
	 * It then constructs a URL with the questionid and sends a GET request to the server to upvote the question.
	 * If the upvote is successful, it increments the view status of the question and disables the upvote button.
	 * If there is an error during the upvoting process, it shows an error notification.
	 */
	upQuestionView: function(){

		// If the button is already clicked, return
		if ($(this).data('clicked')) {
			console.log('Button already clicked.');
			return;
		}

		userJson = JSON.parse(localStorage.getItem("user")); // Retrieve the user data from local storage

		$questionid = this.model.attributes.questionid;	// Retrieve the questionid from the current URL

		var url = this.model.url + 'upvote/' + $questionid;	// Construct the URL for the upvote request

		// If the questionid is not empty or null, send a GET request to the server to upvote the question
		if($questionid != "" && $questionid != null) {
			app.user.fetch({
				"url": url,
				type: 'GET',
				// If the upvote is successful, increment the view status of the question and disable the upvote button
				success: (response) => {

					// Increment the view status of the question
					var currentViewStatus = parseInt($('#question-view-status').text());
					$('#question-view-status').text(currentViewStatus + 1);

					// Disable the upvote button
					this.$el.find('#up-question-view').data('clicked', true).css('pointer-events', 'none');

				},
				error: (xhr, status, error) => {
					console.error('Error upvoting:', error);
					new Noty({
						type: 'error',
						text: 'Error upvoting',
						timeout: 2000
					}).show();
				}
			});

		}else {
			new Noty({
				type: 'error',
				text: 'Error in upvoting',
				timeout: 2000
			}).show();
		}
	},

	/**
	 * This function is responsible for downvoting a question.
	 * It first retrieves the questionid from the current URL.
	 * It then constructs a URL with the questionid and sends a GET request to the server to downvote the question.
	 * If the downvote is successful, it decrements the view status of the question and disables the downvote button.
	 * If there is an error during the downvoting process, it shows an error notification.
	 */
	downQuestionView: function(){

		// If the button is already clicked, return
		if ($(this).data('clicked')) {
			console.log('Button already clicked.');
			return;
		}

		userJson = JSON.parse(localStorage.getItem("user"));	// Retrieve the user data from local storage
		$questionid = this.model.attributes.questionid; 		// Retrieve the questionid from the current URL

		var url = this.model.url + 'downvote/' + $questionid; 		// Construct the URL for the downvote request

		// If the questionid is not empty or null, send a GET request to the server to downvote the question
		if($questionid != "" && $questionid != null) {
			app.user.fetch({
				"url": url,
				type: 'GET',
				success: (response) => {

					// Decrement the view status of the question
					var currentViewStatus = parseInt($('#question-view-status').text());
					$('#question-view-status').text(currentViewStatus - 1);

					// Disable the downvote button
					this.$el.find('#down-question-view').data('clicked', true).css('pointer-events', 'none');

				},
				error: (xhr, status, error) => {
					console.error('Error downvote:', error);
					new Noty({
						type: 'error',
						text: 'Error downvote',
						timeout: 2000
					}).show();
				}
			});

		}else {
			new Noty({
				type: 'error',
				text: 'Error in downvot',
				timeout: 2000
			}).show();
		}
	},

	/**
	 * This function is responsible for submitting an answer to a question.
	 * It first retrieves the user data from the local storage and the answer details from the form.
	 * It then validates the answer details using the validateAnswerForm function.
	 * If the answer is valid, it uploads the image to the server and constructs an object with the answer details.
	 * It then sends a POST request to the server to add the answer.
	 * If the submission is successful, it shows a success notification, increments the answer count of the user, and renders the new answer.
	 * If there is an error during the submission process, it shows an error notification.
	 *
	 * @param {Event} e - The event object from the click event.
	 */
	submitAnswer: function(e){
		userJson = JSON.parse(localStorage.getItem("user"));	// Retrieve the user data from local storage
		$userid = userJson['user_id'];	// Extract the userid from the user data

		e.preventDefault();	// Prevent the default action of the event
		e.stopPropagation();	// Stop the event from propagating

		var validateAnswer = validateAnswerForm();	// Validate the answer details using the validateAnswerForm function

		// If the answer is valid, upload the image to the server and construct an object with the answer details
		if (validateAnswer){
			var formData = new FormData();	// Create a new FormData object
			var imageFIle  = $('#answerImageUpload')[0].files[0];	// Retrieve the image file from the form
			formData.append('image', imageFIle);	// Append the image file to the FormData object

			// Send a POST request to the server to upload the image
			$.ajax({
				url: this.model.urlAns + 'ans_image',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				// If the image is uploaded successfully, set the answerimage attribute of the model and save the model
				success: (response) => {

					validateAnswer.answerimage = response.imagePath; // Set the answerimage attribute of the model
					validateAnswer.answeraddeduserid = $userid;	// Set the answeraddeduserid attribute of the model
					this.model.set(validateAnswer);	// Set the attributes of the model

					$questionid = this.model.attributes.questionid;	// Retrieve the questionid from the model

					var url = this.model.urlAns + "add_answer";	// Construct the URL for the add answer request
					// Send a POST request to the server to add the answer
					this.model.save(this.model.attributes, {
						"url": url,
						// If the submission is successful, show a success notification, increment the answer count of the user, and render the new answer
						success: (model, response) => {
							new Noty({
								type: 'success',
								text: 'Answer submitted successfully',
								timeout: 2000
							}).show();

							$userJson = JSON.parse(localStorage.getItem("user"));	// Retrieve the user data from local storage
							$userJson['answerquestioncnt'] = parseInt($userJson['answerquestioncnt']) + 1;	// Increment the answer count of the user

							localStorage.setItem("user", JSON.stringify($userJson));	// Update the user data in local storage

							this.collection.add(model);	// Add the model to the collection

							// Create and render a new view for the added answer
							var newAnswerView = new app.views.AnswerView({ model: model });
							newAnswerView.render();
						},
						error: (model, response) => {
							console.log('error in submitting answer');
							new Noty({
								type: 'error',
								text: 'Error in submitting answer',
								timeout: 2000
							}).show();
						}
					})
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

			// Clear the form fields
			$('#inputQuestionDetails').val('');
			$('#answerImageUpload').val('');
			$('#questionrate').val('');
		}else{
			setTimeout(function() {
				new Noty({
					type: 'error',
					text: 'Please check if the requirements are satisfied or not',
					timeout: 2000
				}).show();
				console.log('answer is not valid');
			}, 1500);
		}
	}

})
