var app = app || {};

app.routers.AppRouter = Backbone.Router.extend({

	routes: {
		"": "login",
		"home": "home",
		"home/askquestion": "askquestion",
		"home/answerquestion/:questionid": "answerquestion",
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

	home: function(){
		console.log("home route");
		userJson = JSON.parse(localStorage.getItem("user"));
		console.log(userJson);

		if (userJson != null){
			app.user = new app.models.User(userJson);
			console.log("user: "+ app.user);
			// app.homeView = new app.views.homeView();
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
			// app.homeView.render();
		}else {
			app.appRouter.navigate("", {trigger: true});
			console.log("else")
		}


		// if (userJson != null){
		// 	console.log("if");
		// 	app.user = new app.models.User(userJson);
		// 	app.questionView = new app.views.QuestionView({collection: new app.collections.QuestionCollection()});
		// 	console.log("questionView", app.questionView);
		//
		// 	// var url = app.questionView.collection.url + "displayAllQuestions?user_id=" + app.user.get("user_id");
		// 	var url = app.questionView.collection.url + "displayAllQuestions";
		// 	console.log("url: "+ url);
		//
		// 	app.questionView.collection.fetch({
		// 		reset: true,
		// 		"url": url,
		// 		success: function(collection, response){
		// 			console.log("response: "+ response);
		// 			app.questionView.render();
		// 		},
		// 		error: function(model, xhr, options){
		// 			if(xhr.status == 404){
		// 				console.log("error 404");
		// 				app.questionView.render();
		// 			}
		// 			console.log("error");
		// 		}
		// 	});
		// }else {
		// 	app.appRouter.navigate("#", {trigger: true, replace: true});
		// }
	},

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
		console.log("user"+userJson);
		if(userJson != null){
			app.user = new app.models.User(userJson);
			// app.askQue = new app.models.Questions({question_id: questionid, usename: app.user.get("username")});

			console.log("app.user :" , app.user);
			console.log("app.askQue :" , app.askQue);
			console.log("if");

			var url = app.user.urlAskQuestion + "displayAllQuestions/" + questionid;

			app.user.fetch({
				"url": url,
				success: function(model, response){
					console.log("sucess");
					response['username'] = app.user.get("username");
					var questionModel = new app.models.Questions(response);
					app.ansQuestionView = new app.views.AnswerQuestionView({ model: questionModel });
					app.ansQuestionView.render();
				},
				error: function(model, xhr, options){
					if(xhr.status == 404){
						console.log("error 404");
						// app.ansQuestionView = new app.views.AnswerQuestionView({model: app.askQue});
						app.ansQuestionView.render();
					}
					console.log("error");
				}
			})

			app.ansQuestionView = new app.views.AnswerQuestionView({model: app.askQue});
			app.ansQuestionView.render();

			// app.askQue.fetch({
			// 	"url": url,
			// 	success: function(model, response){
			// 		console.log("sucess");
			// 		response['usename'] = app.user.get("username");
			// 		var questionModel = new app.models.Questions(response);
			//
			// 		app.ansQuestionView = new app.views.AnswerQuestionView({ model: questionModel });
			//
			// 		app.ansQuestionView.render();
			// 	},
			// 	error: function(model, xhr, options){
			// 		if(xhr.status == 404){
			// 			console.log("error 404");
			// 			// app.ansQuestionView = new app.views.AnswerQuestionView({model: app.askQue});
			// 			app.ansQuestionView.render();
			// 		}
			// 		console.log("error");
			// 	}
			// });

		}else {
			app.appRouter.navigate("", {trigger: true});
			console.log("else")
		}
	},

	logout: function(){
		console.log("logout route");
		localStorage.clear();
		window.location.href = "";
	}
});
