<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        require_once '../php/db.php'; 
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: ../login.html');
            exit();
        }
        if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 0) {
            header('Location: ../admin/index.php');
            exit();
        }
    ?>

    <nav class="navbar">
        <a href="index.php"><i class="fa fa-fw fa-book"></i> Moje wypożyczenia</a>
        <a class="active" href="settings.php"><i class="fa fa-fw fa-cog"></i> Ustawienia</a>
        <a href="../php/logout.php" class="split"><i class="fa fa-fw fa-sign-out"></i> Wyloguj się</a>
        <a href="#" class="split"><?= $_SESSION['imie'] . ' ' . $_SESSION['nazwisko'] ?></a>
    </nav>

    <h2>Ustawienia</h2>
    <br>
    <form id="settingsForm" method="post" action="settings.php">
        <input type="hidden" name="id" id="id" value="<?= isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : '' ?>">
        <label for="klasa">Klasa:</label><br>
        <select name="id_klasa" id="klasa" required>
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
        <button type="submit">Zmień klasę</button>
    </form>
    <br><br>
    <h3>Zmiana hasła</h3>
    <form id="passwordForm" method="post" action="settings.php">
        <label for="password">Obecne hasło:</label><br>
        <input type="password" name="password" id="password" required>
        <br><br>
        <label for="new_password">Nowe hasło:</label><br>
        <input type="password" name="new_password" id="new_password" required>
        <br><br>
        <label for="confirm_password">Potwierdź nowe hasło:</label><br>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <br><br>
        <button type="submit">Zmień hasło</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['id_klasa'])) {
                $id = $_SESSION['user_id'] ?? '';
                $id_klasa = $_POST['id_klasa'] ?? '';

                $stmt = $conn->prepare("UPDATE users SET id_klasa = ? WHERE id = ?");
                $stmt->bind_param("ii", $id_klasa, $id);
                if ($stmt->execute()) {
                    header('Location: settings.php?message=' . urlencode('Klasa została zmieniona.') . '&l=0');
                    exit();
                } else {
                    header('Location: settings.php?message=' . urlencode('Nie udało się zmienić klasy.') . '&l=2');
                    exit();
                }
            }

            if (isset($_POST['password'])) {
                $id = $_SESSION['user_id'] ?? '';
                $password = $_POST['password'] ?? '';
                $new_password = $_POST['new_password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';

                if (empty($password) || empty($new_password) || empty($confirm_password)) {
                    header('Location: settings.php?message=' . urlencode('Wszystkie pola są wymagane.') . '&l=2');
                    exit();
                }

                if ($new_password !== $confirm_password) {
                    header('Location: settings.php?message=' . urlencode('Hasła nie pasują do siebie.') . '&l=2');
                    exit();
                }

                $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                        $stmt->bind_param("si", $hashed_password, $id);
                        if ($stmt->execute()) {
                            header('Location: settings.php?message=' . urlencode('Hasło zostało zmienione.') . '&l=0');
                            exit();
                        } else {
                            header('Location: settings.php?message=' . urlencode('Nie udało się zmienić hasła.') . '&l=2');
                            exit();
                        }
                    } else {
                        header('Location: settings.php?message=' . urlencode('Nieprawidłowe obecne hasło.') . '&l=2');
                        exit();
                    }
                } else {
                    header('Location: settings.php?message=' . urlencode('Nieprawidłowe obecne hasło.') . '&l=2');
                    exit();
                }
            }
        }
    ?>

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
</body>
</html>