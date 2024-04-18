var app = app || {}

app.views.AnswerView = Backbone.View.extend({
	el: '#answer',

	render: function(){
		console.log('rendering answer view')
		template = _.template($('#answer-template').html())
		this.$el.append(template(this.model.attributes));
	}
})
