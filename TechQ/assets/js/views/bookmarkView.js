var app = app || {};

app.views.bookmarkView = Backbone.View.extend({
	el: ".container",

	render: function(){
		console.log("rendering bookmark view");
		template = _.template($("#bookmark_View").html());
		console.log("app.user.attributes", app.user.attributes);
		this.$el.html(template(app.user.attributes));

		this.collection.each(function(question){
			var questionView = new app.views.QuestionView({model: question});
			questionView.render();
		})
	}
})
