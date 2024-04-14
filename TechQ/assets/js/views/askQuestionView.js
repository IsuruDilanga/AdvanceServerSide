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
			console.log("if")
		}else{
			console.log("else")
		}
	}
})
