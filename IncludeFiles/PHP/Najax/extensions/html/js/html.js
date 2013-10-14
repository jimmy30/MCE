najax.html = {};

najax.html.onCallCompleted = function(response) {

	if (typeof(response.html) == 'string') {

		if (response.html.length > 0) {

			try {

				eval(response.html);

			} catch (e) {};
		}
	}
};

najax.addObserver(najax.html);