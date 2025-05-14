function showAlert(message) {
    const alertBox = document.querySelector('.alert');
    const alertBoxMessage = document.querySelector('.alert-message');
    alertBoxMessage.textContent = message;
    alertBox.classList.add('show');
}

document.getElementById("form").addEventListener('submit', async (e) => {
    e.preventDefault();

    const imie = document.getElementById("imie").value;
    const nazwisko = document.getElementById("nazwisko").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const repeatPassword = document.getElementById("repeatPassword").value;
    const klasa = document.getElementById("klasa").value;

    if (password !== repeatPassword) {
        showAlert("Hasła nie są takie same!");
        return;
    }

    try {
        const response = await axios.post('php/register.php', {imie, nazwisko, email, password, klasa});

        if (response.data.success) {
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 200);
        }

    } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
            showAlert(error.response.data.message);
        } else {
            showAlert('Błąd połączenia z serwerem.');
        }
    }
    
});