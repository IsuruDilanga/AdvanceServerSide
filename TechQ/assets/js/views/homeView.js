var app = app || {};

app.views.homeView = Backbone.View.extend({
	el: ".container",


	render: function() {
		console.log('rendering home view');
		template = _.template($('#home_template').html());
		this.$el.html(template(app.user.attributes));

		this.collection.each(function(question){
			var questionView = new app.views.QuestionView({model: question});
			questionView.render();
		})
	},
	events:{
		"click #ask_question_btn": "ask_question"
	},
	ask_question: function(e){
		e.preventDefault();
		e.stopPropagation();

		console.log('ask question');
		app.appRouter.navigate("home/askquestion", {trigger: true});
	}
});
