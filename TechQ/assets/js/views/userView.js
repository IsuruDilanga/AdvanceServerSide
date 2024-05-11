/**
 * This is the UserView which extends from Backbone.View.
 * It is responsible for rendering the user profile and handling user interactions.
 *
 * @property {String} el - The DOM element associated with this view. It is set to '.container'.
 *
 * @method initialize - This method is called when the view is first created.
 * It sets up a listener for changes to the model and binds event handlers.
 *
 * @method bindEvents - This method binds event handlers to various elements within the view.
 *
 * @method render - This method is responsible for rendering the view.
 * It first compiles the template found in the '#user_template' script tag.
 * It then renders the compiled template into the view's element with the user's attributes.
 * It also creates and renders a NavBarView.
 *
 * @method submitPasswordChange - This method is called when the '#submitPasswordChange' element is clicked.
 * It validates the form, sends a POST request to the server to change the user's password, and handles the server response.
 *
 * @method changePassword - This method is called when the '#edit_userpassword_btn' element is clicked.
 * It shows the password change modal.
 *
 * @method chooseProfilePic - This method is called when the '#edit_userchangedp_btn' element is clicked.
 * It triggers a click event on the '#upload_image_input' element to open the file picker.
 *
 * @method uploadImage - This method is called when a file is selected in the '#upload_image_input' element.
 * It validates the form, sends a POST request to the server to upload the selected image, and handles the server response.
 *
 * @method editUserDetails - This method is called when the '#edit_userdetails_btn' element is clicked.
 * It toggles the state of the form between editing and not editing.
 * When the form is in the editing state, it validates the form, sends a POST request to the server to update the user's details, and handles the server response.
 */
var app = app || {};

app.views.UserView = Backbone.View.extend({
	el: ".container",	// The DOM element associated with this view

	// initialize function is called when the view is first created
	initialize: function(){
		this.listenTo(this.model, 'change', this.render);	// Listen for changes to the model
		this.bindEvents();	// Bind event handlers
	},

	// Bind event handlers to various elements within the view
	bindEvents:function(){
		this.$el.off('click', '#edit_userdetails_btn').on('click', '#edit_userdetails_btn', this.editUserDetails.bind(this));	// Ensure the context of "this" inside the click handler is correct
		this.$el.off('click', '#edit_userpassword_btn').on('click', '#edit_userpassword_btn', this.changePassword.bind(this));	// Ensure the context of "this" inside the click handler is correct
		this.$el.off('click', '#edit_userchangedp_btn').on('click', '#edit_userchangedp_btn', this.chooseProfilePic.bind(this));	// Ensure the context of "this" inside the click handler is correct
		// this.$el.off('change', '#upload_image_input').on('change', '#upload_image_input', this.uploadImage.bind(this));
		this.$el.off('click', '#submitPasswordChange').on('click', '#submitPasswordChange', this.submitPasswordChange.bind(this));	// Ensure the context of "this" inside the click handler is correct
	},

	// Render the view
	render: function(){
		template = _.template($('#user_template').html());	// Load the user_template script tag and compile it using underscore
		this.$el.html(template(app.user.attributes));	// Render the compiled template into the view's element with the user's attributes

		app.navView = new app.views.NavBarView({model: app.user});	// Create a new NavBarView
		app.navView.render();	// Render the NavBarView
	},

	// Event handlers
	events:{
		'click #edit_userdetails_btn': 'editUserDetails',	// Call the editUserDetails method when the '#edit_userdetails_btn' element is clicked
		'click #edit_userpassword_btn': 'changePassword',	// Call the changePassword method when the '#edit_userpassword_btn' element is clicked
		'click #edit_userchangedp_btn': 'chooseProfilePic',	// Call the chooseProfilePic method when the '#edit_userchangedp_btn' element is clicked
		'change #upload_image_input': 'uploadImage',	// Call the uploadImage method when a file is selected in the '#upload_image_input' element
		'click #submitPasswordChange': 'submitPasswordChange',	// Call the submitPasswordChange method when the '#submitPasswordChange' element is clicked
	},

	// submitPasswordChange function is called when the '#submitPasswordChange' element is clicked
	submitPasswordChange: function (){	// Validate the form, send a POST request to the server to change the user's password, and handle the server response
		userJson = JSON.parse(localStorage.getItem("user"));	// Get the user's details from localStorage
		var user_id = userJson['user_id'];	// Get the user's ID

		$oldPassword = $("input#oldPassword").val();
		$newPassword = $("input#newPassword").val();
		$confirmPassword = $("input#confirmPassword").val();

		if($newPassword != $confirmPassword){	// Check if the new password and confirm password match
			new Noty({
				type: 'error',
				text: 'New password and confirm password do not match',
				timeout: 2000
			}).show();
		}else{

			var userPass = {	// Create an object with the user's ID, old password, new password, and confirm password
				'user_id': user_id,
				'oldpassword': $("input#oldPassword").val(),
				'newpassword': $("input#newPassword").val(),
				'confirmpassword': $("input#confirmPassword").val()
			};

			var url = this.model.url + "change_password";	// Set the URL to send the POST request to

			// Send a POST request to the server to change the user's password
			$.ajax({
				url: url,
				type: 'POST',
				data: userPass,
				success: (response) =>{	// Handle the server response
					if(response.status === true){	// If the response status is true
						new Noty({
							type: 'success',
							text: 'Password changed successfully',
							timeout: 2000
						}).show();
						$('#passwordModal').modal('hide');	// Hide the password change modal
					}else if(response.status === false){
						new Noty({
							type: 'error',
							text: 'Old password is incorrect',
							timeout: 2000
						}).show();
					}
				},
				error: function(response){
					console.error("Error:", response);
					new Noty({
						type: 'error',
						text: 'Failed to update password. Please try again.',
						timeout: 2000
					}).show();
				}

			})

		}

		// Clear the input fields
		$("input#oldPassword").val("");
		$("input#newPassword").val(""),
		$("input#confirmPassword").val("");
	},

	// changePassword function is called when the '#edit_userpassword_btn' element is clicked
	changePassword: function(){
		$('#passwordModal').modal('show');	// Show the password change modal
	},

	// chooseProfilePic function is called when the '#edit_userchangedp_btn' element is clicked
	chooseProfilePic: function (){
		$('#upload_image_input').click();	// Trigger a click event on the '#upload_image_input' element to open the file picker
	},

	// uploadImage function is called when a file is selected in the '#upload_image_input' element
	uploadImage: function (){
		userJson = JSON.parse(localStorage.getItem("user"));	// Get the user's details from localStorage
		var user_id = userJson['user_id'];	// Get the user's ID

		var validateUpdateUserProfile = validateUpdateUserProfileForm();	// Validate the form
		validateUpdateUserProfile['user_id'] = user_id;	// Add the user's ID to the form

		// Check if the form is valid
		if(validateUpdateUserProfile){

			var formData = new FormData();	// Create a new FormData object
			var imageFile = $('#upload_image_input')[0].files[0];	// Get the selected image file
			formData.append('image', imageFile);	// Add the image file to the FormData object
			formData.append('user_id', user_id);	// Add the user's ID to the FormData object

			var url = this.model.url + "edit_user_image";	// Set the URL to send the POST request to

			// Send a POST request to the server to upload the selected image
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,	// Set the data to the FormData object
				contentType: false,
				processData: false,
				success: (response) =>{	// Handle the server response
					validateUpdateUserProfile.userimage = response.imagePath;

					this.model.set(validateUpdateUserProfile);

					$updateImage = this.model.attributes.userimage;

					var url = this.model.url + "upload_image";
					this.model.save(this.model.attributes,{	// Save the updated model to the server
						"url": url,
						success: (model, response) => {	// Handle the server response

							// Update localStorage with the updated model
							userJson['userimage'] = $updateImage;
							localStorage.setItem("user", JSON.stringify(userJson));

							new Noty({
								type: 'success',
								text: 'Profile picture updated successfully',
								timeout: 2000
							}).show();

							window.location.reload();	// Reload the page
						},
						error: (model, response) => {
							new Noty({
								type: 'error',
								text: 'Failed to update profile picture. Please try again.',
								timeout: 2000
							}).show();
						}
					});

				},
				error: function(response){
					new Noty({
						type: 'error',
						text: 'Failed to update profile picture. Please try again.',
						timeout: 2000
					}).show();
				}
			});
		}
	},

	// editUserDetails function is called when the '#edit_userdetails_btn' element is clicked
	editUserDetails: function() {

		var userJson = JSON.parse(localStorage.getItem("user"));	// Get the user's details from localStorage

		var $editButton = this.$('#edit_userdetails_btn');	// Get the '#edit_userdetails_btn' element

		// Toggle button text between "Edit User Details" and "Update Details"
		if ($editButton.text() === 'Edit User Details') {
			$editButton.text('Update Details');

			// Enable input fields
			this.$('input').prop('disabled', false);
			this.$('select').prop('disabled', false);
		} else {
			// Change button text back to "Edit User Details"
			$editButton.text('Edit User Details');

			// Disable input fields
			this.$('input').prop('disabled', true);
			this.$('select').prop('disabled', true);

			// Get the updated user details from the input fields
			var validateEditUserDetailsForm = validateEditUserDetailsAddForm();
			validateEditUserDetailsForm['user_id'] = userJson['user_id'];

			if (validateEditUserDetailsForm) {

				// Update model with edited details
				this.model.set(validateEditUserDetailsForm);

				var url = this.model.url + "edit_user";	// Set the URL to send the POST request to

				// Save the updated model to the server
				this.model.save(this.model.attributes, {
					"url": url,
					success: (model, response) => {

						$userJson = JSON.parse(localStorage.getItem("user"));	// Get the user's details from localStorage
						$userJson['username'] = validateEditUserDetailsForm['username'];	// Update the user's username
						$userJson['name'] = validateEditUserDetailsForm['name'];	// Update the user's name
						$userJson['email'] = validateEditUserDetailsForm['email'];	// Update the user's email
						$userJson['occupation'] = validateEditUserDetailsForm['occupation'];	// Update the user's occupation

						localStorage.setItem("user", JSON.stringify($userJson));

						window.location.reload();	// Reload the page
					},
					error: (model, response) => {
						console.error("Error:", response);
						new Noty({
							type: 'error',
							text: 'Failed to update user details. Please try again.',
							timeout: 2000
						}).show();
					}
				});
			} else {
				new Noty({
					type: 'error',
					text: 'Please check if the requirements are satisfied or not',
					timeout: 2000
				}).show();
			}
		}
	},
})
