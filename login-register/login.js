function Login() {
    var unsigned = window.parent.document.querySelectorAll('.unsigned');
    for (var i = 0; i < unsigned.length; i++) {
        unsigned[i].classList.add('hidden');
    }
    var signed = window.parent.document.querySelector('.signed');
    signed.classList.remove('hidden');
}

// Call the Login function when the page loads
