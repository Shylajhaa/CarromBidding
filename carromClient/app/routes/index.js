import Route from '@ember/routing/route';

export default Route.extend({

	// model() {
	// 	return Ember.$.ajax({
	// 		url: 'http://localhost/CarromBidding/getTeams.json',
	// 		method: 'GET',
	// 		dataType: 'json'
	// 	}).then((teams) => {
	// 		return teams;
	// 	}, (err) => {
	// 		console.log(err);
	// 	});
	// }

	model() {
		return Ember.$.ajax({
			url: 'https://ra-movie-review-app.herokuapp.com/get-all-movie-images',
			method: 'GET',
			dataType: 'json'
		}).then((movies) => {
			console.log("Succesfull");
			return movies;
		}, (err) => {
			// console.log("error")
			console.log(err);
		});
	}


});
