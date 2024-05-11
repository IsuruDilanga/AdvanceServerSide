/**
 * This is the bookmarkView which extends from Backbone.View.
 * It is responsible for rendering the bookmarked questions in the application.
 *
 * @property {String} el - The DOM element associated with this view. It is set to '.container'.
 *
 * @method render - This method is responsible for rendering the view.
 * It first compiles the template found in the '#bookmark_View' script tag.
 * It then renders the compiled template into the view's element with the user's attributes.
 * After that, it creates a new NavBarView with the user model and renders it.
 * Finally, it iterates over the collection of bookmarked questions, creates a new QuestionView for each question, and renders it.
 */
var app = app || {};

app.views.bookmarkView = Backbone.View.extend({
	el: ".container",

	render: function(){
		// Compile the template found in the '#bookmark_View' script tag
		template = _.template($("#bookmark_View").html());
		// Render the compiled template into the view's element with the user's attributes
		this.$el.html(template(app.user.attributes));

		// Create a new NavBarView with the user model and render it
		app.navView = new app.views.NavBarView({model: app.user});
		app.navView.render();

		// Iterate over the collection of bookmarked questions
		this.collection.each(function(question){
			// Create a new QuestionView for each question and render it
			var questionView = new app.views.QuestionView({model: question});
			questionView.render();
		})
	}
});
