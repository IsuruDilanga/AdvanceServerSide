var app = app || {};

app.routers.AppRouter = Backbone.Router.extend({

	routes: {
		"": "login",
		"home": "home",
		"home/askquestion": "askquestion",
		"home/answerquestion/:questionid": "answerquestion",
		"home/bookmark/:userid": "bookmark",
		"home/user/:userid": "user",
		"logout": "logout"
	},

	login: function () {
		console.log("login route");
		userJson = JSON.parse(localStorage.getItem("user"));
		if(userJson == null){
			console.log("if");
			if(!app.loginView) {
				app.user = new app.models.User();
				app.loginView = new app.views.LoginFormView({ model: app.user });
				app.loginView.render();
			}
		}else {
			this.home();
		}
	},

	user: function (userid){
		console.log("user route");
		console.log("userid: "+ userid);
		userJson = JSON.parse(localStorage.getItem("user"));

		if(userJson != null) {
			app.user = new app.models.User(userJson);
			console.log("if");

			app.userView = new app.views.UserView({model: new app.models.User()});

			app.userView.render();

			// var url = app.user.urlAskQuestion + "getUser/" + userid;
			// console.log("url: " + url);
			//
			// app.userView = new app.views.UserView({model: new app.models.User()});
			//
			// app.userView.model.fetch({
			// 	"url": url,
			// 	success: function (model, response) {
			// 		console.log("response: " + response);
			// 		app.userView.render();
			// 	},
			// 	error: function (model, xhr, options) {
			// 		if (xhr.status == 404) {
			// 			console.log("error 404");
			// 			app.userView.render();
			// 		}
			// 		console.log("error");
			// 	}
			// });
		}

	},

	bookmark: function(userid){
		console.log("bookmark route");
		userJson = JSON.parse(localStorage.getItem("user"));
		$userid = userJson.user_id;
		console.log("user"+userJson);
		if(userJson != null){
			app.user = new app.models.User(userJson);
			console.log("if");

			var url = app.user.urlAskQuestion + "bookmarkQuestions/"+$userid;
			console.log("url: "+ url);

			app.bookmarkView = new app.views.bookmarkView({collection: new app.collections.QuestionCollection()});

			app.bookmarkView.collection.fetch({
				reset: true,
				"url": url,
				success: function(collection, response){
					console.log("response: "+ response);
					app.bookmarkView.render();
				},
				error: function(model, xhr, options){
					if(xhr.status == 404){
						console.log("error 404");
						app.bookmarkView.render();
					}
					console.log("error");
				}
			});
		}else {
			app.appRouter.navigate("", {trigger: true});
			console.log("else")
		}
	},

	home: function(){
		console.log("home route");
		userJson = JSON.parse(localStorage.getItem("user"));
		console.log(userJson);

		if (userJson != null){
			app.user = new app.models.User(userJson);
			console.log("user: "+ app.user);

			// Render the home view and fetch questions
			app.homeView = new app.views.homeView({collection: new app.collections.QuestionCollection()});

			var url = app.homeView.collection.url + "displayAllQuestions";
			// console.log("url: "+ url);
			app.homeView.collection.fetch({
				reset: true,
				"url": url,
				success: function(collection, response){
					console.log("response: "+ response);

					app.homeView.render();
				},
				error: function(model, xhr, options){
					if(xhr.status == 404){
						// console.log("error 404");
						app.homeView.render();
					}
					// console.log("error");
				}
			});
		} else {
			app.appRouter.navigate("", {trigger: true});
			console.log("else")
		}
	},


	// home: function(){
	// 	console.log("home route");
	// 	userJson = JSON.parse(localStorage.getItem("user"));
	// 	console.log(userJson);
	//
	// 	if (userJson != null){
	// 		app.user = new app.models.User(userJson);
	// 		console.log("user: "+ app.user);
	// 		// app.homeView = new app.views.homeView();
	// 		app.navView = new app.views.NavBarView({model: app.user});
	// 		app.homeView = new app.views.homeView({collection: new app.collections.QuestionCollection()});
	//
	// 		var url = app.homeView.collection.url + "displayAllQuestions";
	// 		// console.log("url: "+ url);
	// 		app.homeView.collection.fetch({
	// 			reset: true,
	// 			"url": url,
	// 			success: function(collection, response){
	// 				console.log("response: "+ response);
	//
	// 				app.navView.render();
	// 				app.homeView.render();
	// 			},
	// 			error: function(model, xhr, options){
	// 				if(xhr.status == 404){
	// 					// console.log("error 404");
	// 					app.navView.render();
	// 					app.homeView.render();
	// 				}
	// 				// console.log("error");
	// 			}
	// 		});
	// 		// app.homeView.render();
	// 	}else {
	// 		app.appRouter.navigate("", {trigger: true});
	// 		console.log("else")
	// 	}
	//
	// },

	askquestion: function (){
		console.log("askQuestion route");
		userJson = JSON.parse(localStorage.getItem("user"));
		console.log("user"+userJson);
		if(userJson != null){
			app.user = new app.models.User(userJson);
			console.log("if");

			app.askQuestionView = new app.views.AddQuestionView({model: app.user});
			app.askQuestionView.render();
		}else {
			app.appRouter.navigate("", {trigger: true});
			console.log("else")
		}
	},

	answerquestion:function (questionid){
		console.log("answerQuestion route : "+ questionid);
		userJson = JSON.parse(localStorage.getItem("user"));
		$user_id = userJson.user_id;
		console.log("user"+userJson);
		if(userJson != null){
			app.user = new app.models.User(userJson);

			var url = app.user.urlAskQuestion + "displayAllQuestions/" + questionid;

			app.user.fetch({
				"url": url,
				success: function(model, responseQ){
					console.log("sucess");
					responseQ['username'] = app.user.get("username");
					var questionModel = new app.models.Questions(responseQ);
					// questionModel['user_id'] = $user_id;
					// var urlBookmark = app.user.urlAskQuestion + "getBookmark/?questionid=" + questionid + "&userid=" + $userid;

					var urlBookmark = app.user.urlAskQuestion + "getBookmark";
					console.log("urlBookmark: "+ urlBookmark);

					$.ajax({
						url: urlBookmark,
						type: "POST",
						data: {
							"questionid": questionid,
							"userid": $user_id
						},
						success: function(responseB){
							console.log("response: "+ responseB.is_bookmark);
							// responseB['user_id'] = $user_id;
							if(responseB.is_bookmark){
								questionModel.set("is_bookmark", true);
								console.log("true bookmarked");
								app.ansQuestionView = new app.views.AnswerQuestionView({
									model: questionModel,
									collection: new app.collections.AnswerCollection(),
									bookmark: true
								});
							}else {
								questionModel.set("is_bookmark", false);
								console.log("false bookmarked");
								app.ansQuestionView = new app.views.AnswerQuestionView({
									model: questionModel,
									collection: new app.collections.AnswerCollection(),
									bookmark: false
								});
							}

							var answerUrl = app.ansQuestionView.collection.url + "getAnswers/" + questionid;

							app.ansQuestionView.collection.fetch({
								reset: true,
								"url": answerUrl,
								success: function (collection, response) {
									console.log("response: " + response);
									app.ansQuestionView.render();
								},
								error: function (model, xhr, options) {
									if (xhr.status == 404) {
										console.log("error 404");
									}
									console.log("error");
								}
							});

							// app.ansQuestionView.render();
						},
						error: function(model, xhr, options){
							if(xhr.status == 404){
								console.log("error 404");
							}
							console.log("error");
						}
					});

					// var questionModel = new app.models.Questions(response);
					//
					// app.ansQuestionView = new app.views.AnswerQuestionView({
					// 	model: questionModel,
					// 	collection: new app.collections.AnswerCollection()
					// });
					//
					// var answerUrl = app.ansQuestionView.collection.url + "getAnswers/" + questionid;
					//
					// app.ansQuestionView.collection.fetch({
					// 	reset: true,
					// 	"url": answerUrl,
					// 	success: function(collection, response) {
					//
					// 		app.ansQuestionView.render();
					// 	},
					// 	error: function(model, xhr, options) {
					// 		if (xhr.status == 404) {
					// 			console.log("error 404");
					// 		}
					// 	}
					// });
					//


					// var questionModel = new app.models.Questions(response);
					//
					// app.ansQuestionView = new app.views.AnswerQuestionView({
					// 	model: questionModel,
					// 	collection: new app.collections.AnswerCollection()
					// });
					//
					// var answerUrl = app.ansQuestionView.collection.url + "getAnswers/" + questionid;
					//
					// app.ansQuestionView.collection.fetch({
					// 	reset: true,
					// 	"url": answerUrl,
					// 	success: function(collection, response) {
					//
					// 		app.ansQuestionView.render();
					// 	},
					// 	error: function(model, xhr, options) {
					// 		if (xhr.status == 404) {
					// 			console.log("error 404");
					// 		}
					// 	}
					// });

				},
				error: function(model, xhr, options){
					if(xhr.status == 404){
						console.log("error 404");
						// app.ansQuestionView = new app.views.AnswerQuestionView({model: app.askQue});
						// app.ansQuestionView.render();
					}
					console.log("error");
				}
			})

		}else {
			app.appRouter.navigate("", {trigger: true});
			console.log("else")
		}
	},

	logout: function(){
		console.log("logout route");
		localStorage.clear();


		var url = app.user.url + "logout";

		$.ajax({
			url: url,
			type: "POST",
			success: function (response) {
				window.location.href = "";

			},

			error: function(model, xhr, options){
				if(xhr.status == 404){
					console.log("error 404");
					// app.ansQuestionView = new app.views.AnswerQuestionView({model: app.askQue});
					// app.ansQuestionView.render();
				}
				console.log("error");
			}
		});

		// $.post('/logout', function(response) {
		//    if (response.success) {
		//        // Redirect to the login page or any other page as needed
		//        window.location.href = "/login";
		//    }
		// });
		// window.location.href = "";
	}
});
