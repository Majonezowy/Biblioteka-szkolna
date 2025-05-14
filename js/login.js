const form = document.getElementById("form");

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = form.email.value;
    const password = form.password.value;

    try {
        const response = await axios.post('php/login.php', {email,password});

        if (response.data.success) {
            setTimeout(() => {
                window.location.href = (response.data.isAdmin) ? 'admin/index.php' : 'dashboard/index.php';
            }, 500);
        }

    } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
            showAlert(error.response.data.message);
        } else {
            showAlert('Błąd połączenia z serwerem.');
        }
    }
    
});