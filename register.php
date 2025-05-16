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
                    <option value="" disabled selected>Wybierz klasę</option>
                    <?php
                        $sql = "SELECT * FROM klasy ORDER BY klasa ASC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['klasa']) . "</option>";
                            }
                        }
                    ?>
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