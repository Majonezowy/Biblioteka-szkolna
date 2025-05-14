function showAlert(message) {
    const alertBox = document.querySelector('.alert');
    const alertBoxMessage = document.querySelector('.alert-message');
    alertBoxMessage.textContent = message;
    alertBox.classList.add('show');
}

document.getElementById("form").addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = form.email.value;
    const password = form.password.value;

    try {
        const response = await axios.post('php/login.php', {email,password});

        if (response.data.success) {
            setTimeout(() => {
                window.location.href = 'index.html';
            }, 2000);
        }

    } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
            showAlert(error.response.data.message);
        } else {
            showAlert('Błąd połączenia z serwerem.');
        }
    }
    
});