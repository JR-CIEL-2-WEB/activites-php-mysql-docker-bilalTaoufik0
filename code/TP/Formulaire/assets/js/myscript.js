function verifierFormulaire() {
    var name = document.querySelector('input[name="name"]');
    var prénom = document.querySelector('input[name="prénom"]');
    var email = document.querySelector('input[name="email"]');
    var password = document.querySelector('input[name="password"]');
    var message = document.querySelector('textarea[name="message"]');
    var checkbox = document.querySelector('input[name="of_age"]');
    var isValid = true;

    [name, prénom, email, password, message].forEach(input => input.style.borderColor = '');
    checkbox.style.outline = '';
    document.querySelector('.text-danger').classList.add('invisible');

    if (name.value.trim() === '') {
        name.style.borderColor = 'red';
        isValid = false;
    } else {
        name.style.borderColor = 'green';
    }

    if (prénom.value.trim() === '') {
        prénom.style.borderColor = 'red';
        isValid = false;
    } else {
        prénom.style.borderColor = 'green';
    }

    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (email.value.trim() === '') {
        email.style.borderColor = 'red';
        isValid = false;
    } else if (!emailPattern.test(email.value.trim())) {
        email.style.borderColor = 'red';
        isValid = false;
    } else {
        email.style.borderColor = 'green';
    }

    if (password.value.trim() === '' || password.value.trim().length < 8) {
        password.style.borderColor = 'red';
        document.querySelector('.text-danger').classList.remove('invisible');
        isValid = false;
    } else {
        password.style.borderColor = 'green';
    }

    if (message.value.trim() === '') {
        message.style.borderColor = 'red';
        isValid = false;
    } else {
        message.style.borderColor = 'green';
    }

    if (!checkbox.checked) {
        checkbox.style.outline = '2px solid red';
        isValid = false;
    } else {
        checkbox.style.outline = '2px solid green';
    }

    return isValid;
}
