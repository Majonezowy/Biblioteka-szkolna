const alertBox = document.querySelector('.alert');
const alertBoxMessage = document.querySelector('.alert-message');

function showAlert(message) {
    alertBoxMessage.textContent = message;
    alertBox.classList.add('show');
}

function hideAlert() {
    alertBox.classList.remove('show');
}