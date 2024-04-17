var app = app || {};

app.views.AnswerQuestionView = Backbone.View.extend({
	el: '.container',

	render:function(){
		console.log('rendering answer question view');
		if (this.model) {
			console.log("app.attribute: " , this.model.attributes);
			template = _.template($('#answer-question-template').html());
			this.$el.html(template(this.model.attributes));
		} else {
			console.error("Model is undefined");
		}
	}

})
