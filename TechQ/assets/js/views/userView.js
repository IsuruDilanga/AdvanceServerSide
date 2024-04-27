var app = app || {};

app.views.UserView = Backbone.View.extend({
	el: ".container",

	render: function(){
		console.log("userView render")
		template = _.template($('#user_template').html());
		console.log("render view: " + app.user.attributes.username);
		this.$el.html(template(app.user.attributes));
	},

	events:{
		'click #edit_userdetails_btn': 'editUserDetails',
		'click #edit_userpassword_btn': 'changePassword',
		'click #edit_userchangedp_btn': 'chooseProfilePic',
		'change #upload_image_input': 'uploadImage',
	},


	changePassword: function(){
		console.log("changePassword");
	},

	chooseProfilePic: function (){
		console.log("chooseProfilePic");
		$('#upload_image_input').click();
	},

	uploadImage: function (){
		userJson = JSON.parse(localStorage.getItem("user"));
		var user_id = userJson['user_id'];
		console.log("user_id", user_id);
		console.log("uploadImage");

		var validateUpdateUserProfile = validateUpdateUserProfileForm();
		validateUpdateUserProfile['user_id'] = user_id;

		console.log("validateUpdateUserProfile", validateUpdateUserProfile.userimage, validateUpdateUserProfile.user_id);

		if(validateUpdateUserProfile){
			console.log("validateUpdateUserProfile is valid", validateUpdateUserProfile);

			var formData = new FormData();
			var imageFile = $('#upload_image_input')[0].files[0];
			formData.append('image', imageFile);
			formData.append('user_id', user_id);

			console.log("formData", formData.image);

			var url = this.model.url + "edit_user_image";
			console.log("url", url);
			console.log("formData", formData);

			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: (response) =>{
					console.log("response", response);
					validateUpdateUserProfile.userimage = response.imagePath;

					console.log("validateUpdateUserProfile", validateUpdateUserProfile.userimage);
					this.model.set(validateUpdateUserProfile);

					$updateImage = this.model.attributes.userimage;
					console.log("$updateImage", $updateImage);

					var url = this.model.url + "upload_image";
					console.log("attriibuetes", this.model.attributes);
					this.model.save(this.model.attributes,{
						"url": url,
						success: (model, response) => {
							console.log("success");
							console.log("model", model);
							console.log("response", response);

							// Update localStorage with the updated model
							// localStorage.setItem("user", JSON.stringify(model));
							userJson['userimage'] = $updateImage;
							localStorage.setItem("user", JSON.stringify(userJson));

							new Noty({
								type: 'success',
								text: 'Profile picture updated successfully',
								timeout: 2000
							}).show();

							window.location.reload();
							// var updated = new app.views.UserView({model: app.user});
							// updated.render();
							// app.appRouter.navigate('home/user/'+user_id, {trigger: true});
						},
						error: (model, response) => {
							console.error("Error:", response);
							new Noty({
								type: 'error',
								text: 'Failed to update profile picture. Please try again.',
								timeout: 2000
							}).show();
						}
					});

				},
				error: function(response){
					console.error("Error:", response);
					new Noty({
						type: 'error',
						text: 'Failed to update profile picture. Please try again.',
						timeout: 2000
					}).show();
				}
			});
		}
	},

	editUserDetails: function() {
		var userJson = JSON.parse(localStorage.getItem("user"));
		console.log("userJson", userJson);
		console.log("userJson", userJson['user_id']);
		console.log("editUserDetails");

		var $editButton = this.$('#edit_userdetails_btn');

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
				console.log("editUserDetailsForm is valid", validateEditUserDetailsForm);

				// Update model with edited details
				this.model.set(validateEditUserDetailsForm);

				var url = this.model.url + "edit_user";
				console.log("url", url);
				console.log("this.model.attributes", this.model.attributes);

				// Save the updated model to the server
				this.model.save(this.model.attributes, {
					"url": url,
					success: (model, response) => {
						console.log("success");
						console.log("model", model);
						console.log("response", response);

						// Update localStorage with the updated model
						localStorage.setItem("user", JSON.stringify(model));

						app.appRouter.navigate('home/user/'+userJson['user_id'], {trigger: true});

						// Reload the page
						// window.location.reload();
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


	// editUserDetails: function() {
	// 	var userJson = JSON.parse(localStorage.getItem("user"));
	// 	console.log("userJson", userJson);
	// 	console.log("userJson", userJson['user_id']);
	// 	console.log("editUserDetails");
	//
	// 	// Change button text to "Update Details"
	// 	this.$('#edit_userdetails_btn').text('Update Details');
	//
	// 	// Enable input fields
	// 	this.$('input').prop('disabled', false);
	// 	this.$('select').prop('disabled', false);
	//
	// 	// Change event listener to listen for the "Update Details" button click
	// 	this.$('#edit_userdetails_btn').off('click').on('click', function() {
	// 		var validateEditUserDetailsForm = validateEditUserDetailsAddForm();
	// 		validateEditUserDetailsForm['user_id'] = userJson['user_id'];
	//
	// 		if (validateEditUserDetailsForm) {
	// 			console.log("editUserDetailsForm is valid", validateEditUserDetailsForm);
	//
	// 			// Update model with edited details
	// 			this.model.set(validateEditUserDetailsForm);
	//
	// 			var url = this.model.url + "edit_user";
	// 			console.log("url", url);
	// 			console.log("this.model.attributes", this.model.attributes);
	//
	//
	// 			// Save the updated model to the server
	// 			this.model.save(this.model.attributes, {
	// 				"url": url,
	// 				success: (model, response) => {
	//
	// 					if(response.status === true){
	//
	// 						console.log("response True");
	//
	// 						console.log("success");
	// 						console.log("model", model);
	// 						console.log("response", response);
	//
	// 						// Update localStorage with the updated model
	// 						localStorage.setItem("user", JSON.stringify(model));
	//
	// 						window.location.reload();
	//
	//
	// 					}else if(response.status === false){
	// 						console.log("response False");
	// 					}
	//
	// 					// Reset button text back to "Edit User Details"
	// 					this.$('#edit_userdetails_btn').text('Edit User Details');
	//
	// 					// Disable input fields
	// 					this.$('input').prop('disabled', true);
	// 					this.$('select').prop('disabled', true);
	//
	// 				},
	// 				error: (model, response) => {
	// 					console.error("Error:", response);
	// 					new Noty({
	// 						type: 'error',
	// 						text: 'Failed to update user details. Please try again.',
	// 						timeout: 2000
	// 					}).show();
	// 				}
	// 			});
	//
	// 		} else {
	// 			new Noty({
	// 				type: 'error',
	// 				text: 'Please check if the requirements are satisfied or not',
	// 				timeout: 2000
	// 			}).show();
	// 		}
	// 	}.bind(this)); // Ensure the context of "this" inside the click handler is correct
	// },
})
