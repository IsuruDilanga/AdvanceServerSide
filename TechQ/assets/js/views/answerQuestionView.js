var app = app || {};

app.views.AnswerQuestionView = Backbone.View.extend({
	el: '.container',

	render:function(){
		console.log('rendering answer question view');
		console.log("app.attribute: " , this.model.attributes);
		template = _.template($('#answer-question-template').html());
		this.$el.html(template(this.model.attributes));

		app.navView = new app.views.NavBarView({model: app.user});
		app.navView.render();

		this.collection.each(function(answer){
			var answerView = new app.views.AnswerView({model: answer});
			answerView.render();
		});
	},

	events: {
		'click #submit_answer': 'submitAnswer',
		'click #up-question-view': 'upQuestionView',
		'click #down-question-view': 'downQuestionView',
		'click #remove-bookmark': 'removeBookmark',
		'click #add-bookmark': 'addBookmark'
	},

	addBookmark: function (){
		console.log('addBookmark');

		$questionid = this.model.attributes.questionid;
		$userid = this.model.attributes.userid;
		var $bookmarkIcon = $('#add-bookmark');

		console.log('questionid: ', $questionid);
		console.log('userid: ', $userid);

		var rBookmark = {
			questionid: $questionid,
			userid: $userid
		};

		var url = this.model.url + 'add_bookmark';
		if($questionid != "" && $questionid != null) {
			app.user.fetch({
				"url": url,
				type: 'POST',
				data: rBookmark,
				success: (response) => {
					console.log('bookmark add');
					$bookmarkIcon.removeClass('fa-regular').addClass('fa-solid'); // Change icon to solid
					$bookmarkIcon.attr('id', 'remove-bookmark');
					new Noty({
						type: 'success',
						text: 'Bookmark add',
						timeout: 2000
					}).show();

				},
				error: (xhr, status, error) => {
					console.error('Error adding bookmark:', error);
					new Noty({
						type: 'error',
						text: 'Error adding bookmark',
						timeout: 2000
					}).show();
				}
			});
		}
	},

	removeBookmark: function (){
		console.log('removeBook');

		$questionid = this.model.attributes.questionid;
		$userid = this.model.attributes.userid;
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
