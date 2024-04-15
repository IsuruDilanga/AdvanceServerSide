var app = app || {};

app.views.AddQuestionView = Backbone.View.extend({
	el: '.container',

	render:function () {
		console.log('rendering add question view');
		template = _.template($('#add_question_template').html());
		this.$el.html(template(this.model.attributes));
	},

	events: {
		'click #submit_question': 'submitquestion'
	},
	submitquestion:function(e){
		e.preventDefault();
		e.stopPropagation();

		console.log('submitting question');

		var valiteQuestionForm = validateQuestionAddForm();
		if(!valiteQuestionForm){
			new Noty({
				type: 'error',
				text: 'Please chech the requirment satisfied or not',
				timeout: 2000
			}).show();
		}else{
			this.model.set(valiteQuestionForm);
			var url = this.model.urlAskQuestion + "addquestion";
			console.log("url",url);
			this.model.save(this.model.attributes, {
				"url": url,
				success: function(model, response){
					console.log('success', model, response);
					new Noty({
						type: 'success',
						text: 'Question added successfully',
						timeout: 2000
					}).show();
					// Backbone.history.navigate('questions', {trigger: true});
				},
				error: function(model, response){
					console.log('error', model, response);
					new Noty({
						type: 'error',
						text: 'Error adding question',
						timeout: 2000
					}).show();
				}
			})
		}

		$('#inputQuestionTitle').val('');
		$('#inputQuestionDetails').val('');
		$('#inputQuestionExpectation').val('');
		$('#inputQuestionTags').val('');
		$('#questionCategory').val('');
	}
})
