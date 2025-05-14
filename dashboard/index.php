<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
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
        <a class="active" href="index.php"><i class="fa fa-fw fa-book"></i> Moje wypożyczenia</a>
        <a href="#"><i class="fa fa-fw fa-cog"></i> Ustawienia</a>
        <a href="../php/logout.php" class="split"><i class="fa fa-fw fa-sign-out"></i> Wyloguj się</a>
        <a href="#" class="split"><?= $_SESSION['imie'] . ' ' . $_SESSION['nazwisko'] ?></a>
    </nav>

    <h2>Wypożyczone książki książki</h2>
    <table>
        <tr>
            <th>Tytuł</th>
            <th>Autor</th>
            <th>Data wypożyczenia</th>
        </tr>
        <?php
            $sql = "SELECT * FROM wypozyczenia WHERE id_uzytkownika = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    $bookSql = "SELECT * FROM ksiazki WHERE id = ?";
                    $bookStmt = $conn->prepare($bookSql);
                    $bookStmt->bind_param("i", $row['id_ksiazki']);
                    $bookStmt->execute();
                    $bookResult = $bookStmt->get_result();
                    $bookRow = $bookResult->fetch_assoc();
                    echo "<td>" . htmlspecialchars($bookRow['tytul']) . "</td>";
                    echo "<td>" . htmlspecialchars($bookRow['autor']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['data_wypozyczenia']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Brak wypożyczonych książek.</td></tr>";
            }
        ?>
</body>
</html>