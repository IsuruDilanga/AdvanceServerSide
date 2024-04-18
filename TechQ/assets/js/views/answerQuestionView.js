var app = app || {};

app.views.AnswerQuestionView = Backbone.View.extend({
	el: '.container',

	render:function(){
		console.log('rendering answer question view');
		console.log("app.attribute: " , this.model.attributes);
		template = _.template($('#answer-question-template').html());
		this.$el.html(template(this.model.attributes));

		this.collection.each(function(answer){
			var answerView = new app.views.AnswerView({model: answer});
			answerView.render();
		});
	},

	events: {
		'click #submit_answer': 'submitAnswer',
	},

	submitAnswer: function(e){
		e.preventDefault();
		e.stopPropagation();

		console.log('submitting answer');

		var validateAnswer = validateAnswerForm();

		if(!validateAnswer){
			new Noty({
				type: 'error',
				text: 'Please check if the requirements are satisfied or not',
				timeout: 2000
			}).show();
		}else {
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

							this.collection.add(model);

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

		}
	}

})
