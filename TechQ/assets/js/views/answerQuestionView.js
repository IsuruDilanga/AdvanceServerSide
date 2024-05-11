var app = app || {};

app.views.AnswerQuestionView = Backbone.View.extend({
	el: '.container',
	initialize: function() {
		this.listenTo(this.model, 'change', this.render);
		this.listenTo(this.collection, 'reset', this.render); // Assuming collection reset triggers re-render
		this.bindEvents(); // Call function to bind events
	},

	bindEvents: function() {
		this.$el.off('click', '#submit_answer').on('click', '#submit_answer', this.submitAnswer.bind(this));
		this.$el.off('click', '#up-question-view').on('click', '#up-question-view', this.upQuestionView.bind(this));
		this.$el.off('click', '#down-question-view').on('click', '#down-question-view', this.downQuestionView.bind(this));
		this.$el.off('click', '#remove-bookmark').on('click', '#remove-bookmark', this.removeBookmark.bind(this));
		this.$el.off('click', '#add-bookmark').on('click', '#add-bookmark', this.addBookmark.bind(this));
		this.$el.off('click', '#delete_question').on('click', '#delete_question', this.deleteQuestion.bind(this));
		this.$el.off('click', '#delete_answer').on('click', '#delete_answer', this.deleteAnswer.bind(this));
	},

	render: function() {
		console.log('rendering answer question view');
		console.log("app.attribute: ", this.model.attributes);
		template = _.template($('#answer-question-template').html());
		this.$el.html(template(this.model.attributes));
		console.log('model answerquestionview 24: ', this.model.attributes);

		app.navView = new app.views.NavBarView({ model: app.user });
		app.navView.render();

		this.collection.each(function(answer) {
			var answerView = new app.views.AnswerView({ model: answer });
			answerView.render();
		});
	},

	events: {
		'click #submit_answer': 'submitAnswer',
		'click #up-question-view': 'upQuestionView',
		'click #down-question-view': 'downQuestionView',
		'click #remove-bookmark': 'removeBookmark',
		'click #add-bookmark': 'addBookmark',
		'click #delete_question': 'deleteQuestion',
		'click #delete_answer': 'deleteAnswer',
	},

	deleteAnswer: function (event){
		console.log('deleteAnswer');

		// Retrieve answerid and userid from the clicked button's data attributes
		var answerid = $(event.currentTarget).data('answerid');
		var userid = $(event.currentTarget).data('userid');
		var answerimage = $(event.currentTarget).data('answerimage');

		console.log('answerid: ', answerid);
		console.log('userid: ', userid);

		var dltanswer = {
			answerid: answerid,
			userid: userid,
			answerimage: answerimage
		};

		console.log(this.model.urlAns + 'delete_answer')
		var url = this.model.urlAns +  'delete_answer';

		if(answerid != "" && answerid != null) {
			app.user.fetch({
				"url": url,
				type: 'POST',
				data: dltanswer,
				success: (response) => {
					console.log('answer deleted');
					new Noty({
						type: 'success',
						text: 'Answer deleted',
						timeout: 2000
					}).show();

					$userJson = JSON.parse(localStorage.getItem("user"));
					console.log('userJson: ', $userJson);
					$userJson['answerquestioncnt'] = parseInt($userJson['answerquestioncnt']) - 1;

					localStorage.setItem("user", JSON.stringify($userJson));

					window.location.reload();
					// app.views.AnswerQuestionView.render();
					// window.location.href = '/';
					// app.appRouter.navigate("home", {trigger: true});
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

	deleteQuestion: function(){
		console.log('deleteQuestion');

		var currentUrl = window.location.href;

		// Extract the last part of the URL after the last '/'
		var lastPart = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);

		// Extract the numeric part from the last part (assuming it's always at the end)
		var $questionid = parseInt(lastPart.match(/\d+$/)[0]);

		console.log("questionid form web: " +$questionid);

		$userJson = JSON.parse(localStorage.getItem("user"));
		$userid = $userJson['user_id'];
		console.log('userid: ', $userid);

		var dltquestion = {
			questionid: $questionid,
			userid: $userid
		};

		var url = this.model.url + 'delete_question';

		if($questionid != "" && $questionid != null) {
			app.user.fetch({
				"url": url,
				type: 'POST',
				data: dltquestion,
				success: (response) => {
					console.log('question deleted');
					new Noty({
						type: 'success',
						text: 'Question deleted',
						timeout: 2000
					}).show();

					$userJson = JSON.parse(localStorage.getItem("user"));
					console.log('userJson: ', $userJson);
					$userJson['askquestioncnt'] = parseInt($userJson['askquestioncnt']) - 1;

					localStorage.setItem("user", JSON.stringify($userJson));
					// window.location.href = '/';
					app.appRouter.navigate("home", {trigger: true});

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

	// addBookmark: function (){
	// 	console.log('addBookmark');
	//
	// 	var currentUrl = window.location.href;
	//
	// 	// Extract the last part of the URL after the last '/'
	// 	var lastPart = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);
	//
	// 	// Extract the numeric part from the last part (assuming it's always at the end)
	// 	var $questionid = parseInt(lastPart.match(/\d+$/)[0]);
	//
	// 	console.log("questionid form web: " +$questionid);
	//
	// 	$userJson = JSON.parse(localStorage.getItem("user"));
	// 	$userid = $userJson['user_id'];
	// 	console.log('userid: ', $userid);
	//
	// 	// $questionid = this.model.attributes.questionid;
	// 	// $userid = this.model.attributes.user_id;
	// 	var $bookmarkIcon = $('#add-bookmark');
	//
	// 	console.log('questionid: ', $questionid);
	// 	console.log('userid: ', $userid);
	//
	// 	// var rBookmark = {
	// 	// 	questionid: $questionid,
	// 	// 	userid: $userid
	// 	// };
	//
	// 	var url = this.model.url + 'add_bookmark?qid=' + $questionid + '&uid=' + $userid;
	// 	count = 0;
	// 	console.log('count: ' + count);
	// 	if(count == 0){
	// 		console.log('count 62: ' + count);
	// 		let notificationShowing = false;
	//
	// 		app.user.fetch({
	// 			"url": url,
	// 			type: 'GET',
	// 			success: (response) => {
	// 				console.log('bookmark add');
	// 				$bookmarkIcon.removeClass('fa-regular').addClass('fa-solid'); // Change icon to solid
	// 				$bookmarkIcon.attr('id', 'remove-bookmark');
	// 				new Noty({
	// 					type: 'success',
	// 					text: 'Bookmark add',
	// 					timeout: 2000
	// 				}).show();
	//
	// 			},
	// 			error: (xhr, status, error) => {
	// 				console.error('Error adding bookmark:', error);
	// 				new Noty({
	// 					type: 'error',
	// 					text: 'Error adding bookmark',
	// 					timeout: 2000
	// 				}).show();
	// 			}
	// 		});
	//
	// 	}
	//
	// },

	addBookmark: function (){
		console.log('addBookmark');

		var currentUrl = window.location.href;

		// Extract the last part of the URL after the last '/'
		var lastPart = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);

		// Extract the numeric part from the last part (assuming it's always at the end)
		var $questionid = parseInt(lastPart.match(/\d+$/)[0]);

		console.log("questionid form web: " +$questionid);

		$userJson = JSON.parse(localStorage.getItem("user"));
		$userid = $userJson['user_id'];
		console.log('userid: ', $userid);

		// $questionid = this.model.attributes.questionid;
		// $userid = this.model.attributes.user_id;
		var $bookmarkIcon = $('#add-bookmark');

		console.log('questionid: ', $questionid);
		console.log('userid: ', $userid);

		var rBookmark = {
			questionid: $questionid,
			userid: $userid
		};

		var url = this.model.url + 'add_bookmark';

		$.ajax({
			"url": url,
			type: 'POST',
			data: rBookmark,
			success: (response) => {
				console.log("questionid: " + rBookmark["questionid"])
				console.log('bookmark add');
				$bookmarkIcon.removeClass('fa-regular').addClass('fa-solid'); // Change icon to solid
				$bookmarkIcon.attr('id', 'remove-bookmark');
				new Noty({
					type: 'success',
					text: 'Bookmark add',
					timeout: 2000,
				}).show();


				// $bookmarkIcon.on('click', this.removeBookmark.unbind(this));
			},
			error: (xhr, status, error) => {
				console.error('Error adding bookmark:', error);
				new Noty({
					type: 'error',
					text: 'Error adding bookmark',
					timeout: 2000
				}).show();

				// $bookmarkIcon.on('click', this.addBookmark.bind(this));
			},
			// $("#add-bookmark").unbind();
		});



		if($questionid != "" && $questionid != null) {
			// $.ajax({
			// 	"url": url,
			// 	type: 'POST',
			// 	data: rBookmark,
			// 	success: (response) => {
			// 		rBookmark["questionid"] = "";
			// 		rBookmark["userid"] = "";
			// 		console.log("questionid: " + rBookmark["questionid"])
			// 		console.log('bookmark add');
			// 		$bookmarkIcon.removeClass('fa-regular').addClass('fa-solid'); // Change icon to solid
			// 		$bookmarkIcon.attr('id', 'remove-bookmark');
			// 		new Noty({
			// 			type: 'success',
			// 			text: 'Bookmark add',
			// 			timeout: 2000
			// 		}).show();
			//
			// 		// $bookmarkIcon.on('click', this.removeBookmark.bind(this));
			// 	},
			// 	error: (xhr, status, error) => {
			// 		console.error('Error adding bookmark:', error);
			// 		new Noty({
			// 			type: 'error',
			// 			text: 'Error adding bookmark',
			// 			timeout: 2000
			// 		}).show();
			//
			// 		// $bookmarkIcon.on('click', this.addBookmark.bind(this));
			// 	}
			// });
			// app.user.fetch({
			// 	"url": url,
			// 	type: 'POST',
			// 	data: rBookmark,
			// 	success: (response) => {
			// 		rBookmark["questionid"] = "";
			// 		rBookmark["userid"] = "";
			// 		console.log('bookmark add');
			// 		$bookmarkIcon.removeClass('fa-regular').addClass('fa-solid'); // Change icon to solid
			// 		$bookmarkIcon.attr('id', 'remove-bookmark');
			// 		new Noty({
			// 			type: 'success',
			// 			text: 'Bookmark add',
			// 			timeout: 2000
			// 		}).show();
			//
			// 	},
			// 	error: (xhr, status, error) => {
			// 		console.error('Error adding bookmark:', error);
			// 		new Noty({
			// 			type: 'error',
			// 			text: 'Error adding bookmark',
			// 			timeout: 2000
			// 		}).show();
			// 	}
			// });
		}
	},

	// addBookmark: function (){
	// 	console.log('addBookmark');
	//
	//
	//
	// 	var $bookmarkIcon = $('#add-bookmark');
	//
	// 	// Disable the button to prevent multiple clicks
	// 	$bookmarkIcon.prop('disabled', true);
	//
	// 	// Check if bookmark addition process is already in progress
	// 	if ($bookmarkIcon.hasClass('bookmark-in-progress')) {
	// 		console.log('Bookmark addition process is already in progress.');
	// 		$bookmarkIcon.prop('disabled', false); // Re-enable the button
	// 		return; // Exit function to prevent multiple requests
	// 	}
	//
	// 	// Set flag to indicate bookmark addition process is in progress
	// 	$bookmarkIcon.addClass('bookmark-in-progress');
	//
	// 	$userJson = JSON.parse(localStorage.getItem("user"));
	// 	$userid = $userJson['user_id'];
	// 	console.log('userid: ', $userid);
	//
	// 	$questionid = this.model.attributes.questionid;
	//
	// 	console.log('questionid: ', $questionid);
	// 	console.log('userid: ', $userid);
	//
	// 	var rBookmark = {
	// 		questionid: $questionid,
	// 		userid: $userid
	// 	};
	//
	// 	var url = this.model.url + 'add_bookmark';
	// 	if($questionid != "" && $questionid != null) {
	// 		$.ajax({
	// 			"url": url,
	// 			type: 'POST',
	// 			data: rBookmark,
	// 			success: (response) => {
	// 				rBookmark["questionid"] = "";
	// 				rBookmark["userid"] = "";
	// 				console.log('bookmark add');
	// 				$bookmarkIcon.removeClass('fa-regular').addClass('fa-solid');
	// 				$bookmarkIcon.attr('id', 'remove-bookmark');
	// 				new Noty({
	// 					type: 'success',
	// 					text: 'Bookmark add',
	// 					timeout: 2000
	// 				}).show();
	// 			},
	// 			error: (xhr, status, error) => {
	// 				console.error('Error adding bookmark:', error);
	// 				new Noty({
	// 					type: 'error',
	// 					text: 'Error adding bookmark',
	// 					timeout: 2000
	// 				}).show();
	// 			},
	// 			complete: () => {
	// 				// Enable the button after the request completes
	// 				$bookmarkIcon.prop('disabled', false);
	//
	// 				// Reset flag after the request completes
	// 				$bookmarkIcon.removeClass('bookmark-in-progress');
	// 			}
	// 		});
	// 	}
	// },



	removeBookmark: function (){
		console.log('removeBook');

		var currentUrl = window.location.href;

		// Extract the last part of the URL after the last '/'
		var lastPart = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);

		// Extract the numeric part from the last part (assuming it's always at the end)
		var $questionid = parseInt(lastPart.match(/\d+$/)[0]);

		console.log("questionid form web: " +$questionid);

		$userJson = JSON.parse(localStorage.getItem("user"));
		$userid = $userJson['user_id'];

		// $questionid = this.model.attributes.questionid;
		// $userid = this.model.attributes.userid;
		var $bookmarkIcon = $('#remove-bookmark');

		console.log('questionid: ', $questionid);
		console.log('userid: ', $userid);

		var rBookmark = {
			questionid: $questionid,
			userid: $userid
		};

		var url = this.model.url + 'remove_bookmark';
		if($questionid != "" && $questionid != null) {
			app.user.fetch({
				"url": url,
				type: 'POST',
				data: rBookmark,
				success: (response) => {
					rBookmark["questionid"] = "";
					rBookmark["userid"] = "";
					console.log('bookmark removed');
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

	upQuestionView: function(){

		if ($(this).data('clicked')) {
			console.log('Button already clicked.');
			return;
		}

		userJson = JSON.parse(localStorage.getItem("user"));

		$questionid = this.model.attributes.questionid;

		var url = this.model.url + 'upvote/' + $questionid;

		if($questionid != "" && $questionid != null) {
			app.user.fetch({
				"url": url,
				type: 'GET',
				success: (response) => {
					console.log('upvoted');

					var currentViewStatus = parseInt($('#question-view-status').text());
					$('#question-view-status').text(currentViewStatus + 1);

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

	downQuestionView: function(){
		console.log('downQuestionView');

		if ($(this).data('clicked')) {
			console.log('Button already clicked.');
			return;
		}

		userJson = JSON.parse(localStorage.getItem("user"));

		$questionid = this.model.attributes.questionid;

		var url = this.model.url + 'downvote/' + $questionid;

		if($questionid != "" && $questionid != null) {
			app.user.fetch({
				"url": url,
				type: 'GET',
				success: (response) => {
					console.log('downvote');

					var currentViewStatus = parseInt($('#question-view-status').text());
					$('#question-view-status').text(currentViewStatus - 1);

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


	submitAnswer: function(e){
		userJson = JSON.parse(localStorage.getItem("user"));
		$userid = userJson['user_id'];

		e.preventDefault();
		e.stopPropagation();

		console.log('submitting answer');

		var validateAnswer = validateAnswerForm();

		if (validateAnswer){
			console.log('answer is valid');
			var formData = new FormData();
			var imageFIle  = $('#answerImageUpload')[0].files[0];
			formData.append('image', imageFIle);
			console.log(this.model.urlAns);

			$.ajax({
				url: this.model.urlAns + 'ans_image',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: (response) => {
					console.log('image uploaded', response);
					validateAnswer.answerimage = response.imagePath;
					validateAnswer.answeraddeduserid = $userid;
					this.model.set(validateAnswer);

					$questionid = this.model.attributes.questionid;
					console.log('questionid: ', $questionid);

					console.log('model asda: ', this.model.attributes);
					var url = this.model.urlAns + "add_answer";
					this.model.save(this.model.attributes, {
						"url": url,
						success: (model, response) => {
							console.log('answer submitted');
							new Noty({
								type: 'success',
								text: 'Answer submitted successfully',
								timeout: 2000
							}).show();

							$userJson = JSON.parse(localStorage.getItem("user"));
							console.log('userJson: ', $userJson);
							$userJson['answerquestioncnt'] = parseInt($userJson['answerquestioncnt']) + 1;

							localStorage.setItem("user", JSON.stringify($userJson));

							this.collection.add(model);
							console.log('model: ', model);
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
