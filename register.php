<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <main class="container">
        <div class="login-form">
            <h2>Rejestracja</h2>
            <form action="" method="POST" id="form">
                <label for="imie">Imię</label><br>
                <input type="text" id="imie" name="imie" required>
                <br><br>

                <label for="nazwisko">Nazwisko</label><br>
                <input type="text" id="nazwisko" name="nazwisko" required>
                <br><br>

                <label for="email">Adres e-mail</label><br>
                <input type="email" id="email" name="email" required>
                <br><br>

                <label for="password">Hasło</label><br>
                <input type="password" id="password" name="password" required minlength="8" maxlength="64">
                <br><br>

                <label for="repeat-password">Powtórz hasło</label><br>
                <input type="password" id="repeatPassword" name="r-password" required minlength="8" maxlength="64">
                <br><br>

                <label for="klasa">Klasa</label><br>
                <select id="klasa" name="klasa" required>
                    <option value="1A">1A</option>
                    <option value="1B">1B</option>
                    <option value="2A">2A</option>
                    <option value="2B">2B</option>
                    <option value="3A">3A</option>
                    <option value="3B">3B</option>
                </select>
                <br><br>

                <input id="submit" type="submit" value="Zarejestruj się">
            </form>
        </div>

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

    </main>
</body>
</html>