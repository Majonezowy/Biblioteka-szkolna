<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wypożyczanie</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/upsert.css">
</head>
<body>
    <?php 
        require_once '../php/db.php'; 
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: ../login.php');
            exit();
        }
        if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
            header('Location: ../dashboard/index.php');
            exit();
        }
    ?>

<form id="editForm" method="post" action="borrow.php">
    <h2>Wypożyczanie</h2>
    <input type="hidden" name="id" id="id" value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>">
    <select name="id_uzytkownika" required>
        <option value="">Wybierz użytkownika</option>
        <?php
            $sql = "SELECT * FROM users WHERE isAdmin = 0 ORDER BY imie ASC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['imie'] . ' ' . $row['nazwisko']) . "</option>";
                }
            }
        ?>
    </select>
    <br>
    <label for="termin_wypozyczenia">Termin zwrotu:</label><br>    
    <input type="date" name="termin_zwrotu" required>
    <br>
    
    <button type="submit">Wypożycz</button>
</form>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $id = $_POST['id'] ?? '';
        $id_uzytkownika = $_POST['id_uzytkownika'] ?? '';
        $termin_zwrotu = $_POST['termin_zwrotu'] ?? '';

        $id_uzytkownika = isset($_POST['id_uzytkownika']) ? (int)$_POST['id_uzytkownika'] : 0;
        if ($id_uzytkownika <= 0) {
            header('Location: ../admin/index.php?message=' . urlencode('Nieprawidłowy użytkownik.') . '&l=2');
            exit();
        }

        $result = $conn->query("SELECT * FROM wypozyczenia WHERE id_uzytkownika = $id_uzytkownika AND oddana = 0");
        if ($result && $result->num_rows >= 2) {
            header('Location: ../admin/index.php?message=' . urlencode('Użytkownik osiągnął limit wypożyczeń.') . '&l=1');
            exit();
        }

        $stmt = $conn->prepare("UPDATE ksiazki SET dostepna = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            header('Location: ../admin/index.php?message=' . urlencode('Nie można zaktualizować dostępności książki.') . '&l=2');
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO wypozyczenia (id_ksiazki, id_uzytkownika, data_wypozyczenia, termin_zwrotu) VALUES (?, ?, CURDATE(), ?)");
        $stmt->bind_param("iis", $id, $id_uzytkownika, $termin_zwrotu);
        if ($stmt->execute()) {
            header('Location: ../admin/index.php?message=' . urlencode('Książka została wypożyczona pomyślnie.') . '&l=0');
            exit();
        } else {
            header('Location: ../admin/index.php?message=' . urlencode('Wystąpił błąd podczas wypożyczania książki.') . '&l=2');
            exit();
        }
    }
?>
</body>
</html>