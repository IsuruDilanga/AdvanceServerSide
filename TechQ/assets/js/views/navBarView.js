/**
 * This is the NavBarView which extends from Backbone.View.
 * It is responsible for rendering the navigation bar in the application.
 *
 * @property {String} el - The DOM element associated with this view. It is set to '#nav-bar-container'.
 *
 * @method render - This method is responsible for rendering the view.
 * It first compiles the template found in the '#nav-bar-template' script tag.
 * It then renders the compiled template into the view's element with the model's attributes.
 * Finally, it logs the model's attributes and the rendering process.
 */

var app = app || {};

app.views.NavBarView = Backbone.View.extend({
	el: '#nav-bar-container',	// The DOM element associated with this view

	// render view
	render: function(){
		template = _.template($('#nav-bar-template').html());	// compile the template
		this.$el.html(template(this.model.attributes));	// render the template into the view's element
	}
});
