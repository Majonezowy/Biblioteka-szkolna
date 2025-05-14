<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/upsert.css">
</head>
<body>
    <?php 
        require_once '../php/db.php'; 
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: ../login.html');
            exit();
        }
        if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
            header('Location: ../dashboard/index.php');
            exit();
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM ksiazki WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tytul = htmlspecialchars($row['tytul']);
                $autor = htmlspecialchars($row['autor']);
                $kategoria = htmlspecialchars($row['kategoria']);
                $rok_wydania = htmlspecialchars($row['rok_wydania']);
            } else {
                echo "<script>alert('Nie znaleziono książki o podanym ID.');</script>";
            }
        }
    ?>

<form id="editForm" method="post" action="upsert.php">
    <h2>Dane książki</h2>
    <input type="hidden" name="id" id="id" value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>">

    <label for="tytul">Tytuł:</label><br>
    <input type="text" name="tytul" id="tytul" value="<?= isset($tytul) ? $tytul : '' ?>" required>
    <br>

    <label for="autor">Autor:</label><br>
    <input type="text" name="autor" id="autor" value="<?= isset($autor) ? $autor : '' ?>" required>
    <br>

    <label for="kategoria">Kategoria:</label><br>
    <input type="text" name="kategoria" id="kategoria" value="<?= isset($kategoria) ? $kategoria : '' ?>" required>
    <br>

    <label for="rok_wydania">Rok wydania:</label><br>
    <input type="number" name="rok_wydania" id="rok_wydania" value="<?= isset($rok_wydania) ? $rok_wydania : '' ?>" required>
    <br>
    <button type="submit">Zapisz</button>
</form>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $id = $_POST['id'] ?? '';
        $tytul = $_POST['tytul'] ?? '';
        $autor = $_POST['autor'] ?? '';
        $kategoria = $_POST['kategoria'] ?? '';
        $rok_wydania = $_POST['rok_wydania'] ?? '';

        if ($id) {
            $stmt = $conn->prepare("UPDATE ksiazki SET tytul = ?, autor = ?, kategoria = ?, rok_wydania = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $tytul, $autor, $kategoria, $rok_wydania, $id);
            $stmt->close();
        } else {
            $stmt = $conn->prepare("INSERT INTO ksiazki (tytul, autor, kategoria, rok_wydania, dostepna) VALUES (?, ?, ?, ?, 1)");
            $stmt->bind_param("ssss", $tytul, $autor, $kategoria, $rok_wydania);
            $stmt->close();
        }

        header('Location: ../admin/index.php');
        exit();
    }
?>
</body>
</html>