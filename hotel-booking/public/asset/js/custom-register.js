// custom-register.js
document.addEventListener('DOMContentLoaded', function() {
    var registerButton = document.getElementById('registerButton');
    var registerModal = document.getElementById('registerModal');

    registerButton.addEventListener('click', function() {
        registerModal.style.display = 'block';
    });

    window.addEventListener('click', function(event) {
        if (event.target == registerModal) {
            registerModal.style.display = 'none';
        }
    });
});
