function submitEntry(postUrl) {
	var name = document.querySelector('#name').value;
	var package = document.querySelector('select[name="type"]').value;
	var nameHint = document.querySelector('#name-hint');
	var number = document.querySelector('#number').value;
	var errorLabel = document.querySelector('#error-label');
	var key = document.querySelector('#key').value;

	var loader = document.querySelector('#loader');

	loader.innerHTML = '<div class="loader"></div>';

	if (name.length <= 0 || number.length <= 0) {
		errorLabel.innerHTML = '<div class="text-danger animate__animated animate__shakeX">Please fill the form to proceed!</div>';
		loader.innerHTML = "";
	}
	else {
		if (package == 'free' && name.length > 8) {
			nameHint.innerHTML = '<div class="text-danger animate__animated animate__shakeX">Sorry, free package does not permit names longer than 8 characters</div>';
			loader.innerHTML = "";
		}
		else if (package == 'free' && name.indexOf(' ') != -1) {
			nameHint.innerHTML = '<div class="text-danger animate__animated animate__shakeX">Sorry, free package does not permit spaces between names</div>';
			loader.innerHTML = "";
		}
		else {
			vars = "name=" + name + "&number=" + number + "&type=" + package + "&key=" + key;

			$.ajax({
				type: "post",
				url: postUrl,
				data: vars,
				cache: false,
				success: function (data) {
					loader.innerHTML = '';
					if (data.indexOf('success') != -1) {
						if (package == 'premium') {
							window.location.replace('/home/payment?key=' + key);
						}
						else if (package == 'free') {
							window.location.replace('/home/entrysuccess?key=' + key);
						}
					}
				},
				error: function (err) {
					loader.innerHTML = '';
					errorLabel.innerHTML = '<div class="alert alert-danger animate__animated animate__shakeY">An error occured. <br/>Error Code: ' + err.status + '</div>';
				}
			});
		}

	}
}