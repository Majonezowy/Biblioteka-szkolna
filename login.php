<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <main class="container">
        <div class="login-form">
            <h2>Logowanie</h2>
            <form action="./php/login.php" method="POST" id="form">
                <label for="email">Adres e-mail</label><br>
                <input type="email" id="email" name="email" required>
                <br><br>
                <label for="password">Hasło</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="checkbox" onclick="showPassword()"><label>Pokaż hasło</label>
                <br><br>
                <input id="submit" type="submit" value="Zaloguj się">
            </form>

            <div class="register-link">
                <p>Nie masz konta? <a href="register.html">Zarejestruj się</a></p>
            </div>
            <!-- <div class="forgot-password-link">
                <p><a href="forgot_password.php">Nie pamiętasz hasła?</a></p>
            </div> -->
        </div>

        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <span class="alert-message"></span>
        </div>
    </main>

    <script src="js/main.js"></script>
        <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <span class="alert-message"></span>
    </div>

    <?php if (isset($_GET['message'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alertBox = document.querySelector('.alert');
            const alertBoxMessage = document.querySelector('.alert-message');
            alertBoxMessage.textContent = <?= json_encode($_GET['message']) ?>;
            alertBox.style.backgroundColor = <?= json_encode($_GET['l'] == 0 ? 'var(--success-color)' : ($_GET['l'] == 1 ? 'var(--warning-color)' : 'var(--danger-color)')) ?>;
            alertBox.classList.add('show');
        });
    </script>
    <?php endif; ?>
    <script>
        function showPassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>
</html>