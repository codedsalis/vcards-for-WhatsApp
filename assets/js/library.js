function submitEntry() {
    var name = document.querySelector('#name').value;
    var package = document.querySelector('select[name="type"]').value;
    var nameHint = document.querySelector('#name-hint');
    var number = document.querySelector('#number').value;
    var errorLabel = document.querySelector('#error-label');

    var loader = document.querySelector('#loader');

    loader.innerHTML = '<div class="loader"></div>';

    if (name.length <= 0 || number.length <= 0) {
        errorLabel.innerHTML = '<span class="text-danger">Please fill the form to proceed!</span>';
        loader.innerHTML = "";
    }
    else {
        if (package == 'free') {
            if (name.length > 8) {
                nameHint.innerHTML = '<span class="text-danger">Sorry, free package does not permit names longer than 8 characters</span>';
                loader.innerHTML = "";
            }
            else if (name.indexOf(' ') != -1) {
                nameHint.innerHTML = '<span class="text-danger">Sorry, free package does not permit spaces between names</span>';
                loader.innerHTML = "";
            }
        }

        console.log(name, number, package);

    }
}



