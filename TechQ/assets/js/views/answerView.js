var app = app || {}

/**
 * This is the AnswerView which extends from Backbone.View.
 * It is responsible for rendering the answers in the application.
 *
 * @property {String} el - The DOM element associated with this view. It is set to '#answer'.
 *
 * @method render - This method is responsible for rendering the view.
 * It first compiles the template found in the '#answer-template' script tag.
 * If there is no 'h1' element in the view's element, it appends an 'h1' element with the text 'Answers' and sets the display style to 'block'.
 * It then appends the compiled template into the view's element with the model's attributes.
 * Finally, it logs the model's attributes.
 */
app.views.AnswerView = Backbone.View.extend({
	el: '#answer',

	render: function(){
		// Compile the template found in the '#answer-template' script tag
		template = _.template($('#answer-template').html())

		// If there is no 'h1' element in the view's element, append an 'h1' element with the text 'Answers' and set the display style to 'block'
		if (this.$el.find('h1').length === 0) {
			this.$el.append('<h1>Answers</h1>');
			this.$el.css('display', 'block');
		}

		// Append the compiled template into the view's element with the model's attributes
		this.$el.append(template(this.model.attributes));
	}
});
