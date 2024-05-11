/**
 * This is the QuestionView which extends from Backbone.View.
 * It is responsible for rendering individual questions in the application.
 *
 * @property {String} el - The DOM element associated with this view. It is set to '#question'.
 *
 * @method render - This method is responsible for rendering the view.
 * It first compiles the template found in the '#question_template' script tag.
 * It then appends the compiled template into the view's element with the model's attributes.
 */
var app = app || {};

app.views.QuestionView = Backbone.View.extend({
	el: '#question',	// The DOM element associated with this view

	// render question by compiling the template with the model's attributes
	render:function (){
		template = _.template($('#question_template').html());
		this.$el.append(template(this.model.attributes));
	}
});
