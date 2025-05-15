<!DOCTYPE html>
<html lang="pl">
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
        if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
            header('Location: ../dashboard/index.php');
            exit();
        }
    ?>

    <nav class="navbar">
        <a href="index.php"><i class="fa fa-fw fa-book"></i> Książki</a>
        <a class="active" href="borrowed.php"><i class="fa fa-fw fa-list-alt"></i> Wypożyczone książki</a>
        <a href="users.php"><i class="fa fa-fw fa-user"></i> Użytkownicy</a>
        <a href="stats.php"><i class="fa fa-fw fa-calculator"></i> Statystyki</a>
        <a href="../php/logout.php" class="split"><i class="fa fa-fw fa-sign-out"></i> Wyloguj się</a>
        <a href="#" class="split"><?= $_SESSION['imie'] . ' ' . $_SESSION['nazwisko'] ?></a>
    </nav>

    <h2>Przetrzymane książki</h2>
    <table>
        <tr>
            <th>Tytuł</th>
            <th>Osoba wypożyczająca</th>
            <th>Data wypożyczenia</th>
            <th>Termin zwrotu</th>
            <th>Akcja</th>
            <th>Kara</th>
        </tr>
        <?php
            $sql = "SELECT * FROM wypozyczenia WHERE termin_zwrotu < CURDATE() AND oddana = 0 ORDER BY termin_zwrotu ASC";
            $result = $conn->query($sql);
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

                    $userSql = "SELECT * FROM users WHERE id = ?";
                    $userStmt = $conn->prepare($userSql);
                    $userStmt->bind_param("i", $row['id_uzytkownika']);
                    $userStmt->execute();
                    $userResult = $userStmt->get_result();
                    $userRow = $userResult->fetch_assoc();
                    echo "<td>" . htmlspecialchars($userRow['imie'] . ' ' . $userRow['nazwisko']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['data_wypozyczenia']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['termin_zwrotu']) . "</td>";

                    echo "<td>
                        <div class='action-buttons'>
                            <a href='../php/zwroc.php?id=" . $row['id'] . "' class='fa fa-undo'> Zwróć</a>
                        </div>
                    </td>";
                    echo "<td>";
                        $now = time();
                        $earlier_date = strtotime($row['termin_zwrotu']);
                        $difference = $now - $earlier_date;
                        $days = round($difference / (60 * 60 * 24));

                        echo $days * 0.1 . " zł";
                    echo "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Brak przetrzymanych książek.</td></tr>";
            }
        ?>
    </table>

    <h2>Wypożyczone książki</h2>
    <table>
        <tr>
            <th>Tytuł</th>
            <th>Osoba wypożyczająca</th>
            <th>Data wypożyczenia</th>
            <th>Termin zwrotu</th>
            <th>Akcja</th>
        </tr>
        <?php
            $sql = "SELECT * FROM wypozyczenia WHERE oddana = 0 ORDER BY (termin_zwrotu < CURDATE()) DESC, termin_zwrotu ASC";
            $result = $conn->query($sql);
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
                    $userSql = "SELECT * FROM users WHERE id = ?";
                    $userStmt = $conn->prepare($userSql);
                    $userStmt->bind_param("i", $row['id_uzytkownika']);
                    $userStmt->execute();
                    $userResult = $userStmt->get_result();
                    $userRow = $userResult->fetch_assoc();
                    echo "<td>" . htmlspecialchars($userRow['imie'] . ' ' . $userRow['nazwisko']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['data_wypozyczenia']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['termin_zwrotu']) . "</td>";
                    echo "<td>
                        <div class='action-buttons'>
                            <a href='../php/zwroc.php?id=" . $row['id'] . "' class='fa fa-undo'> Zwróć</a>
                        </div>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Brak wypożyczonych książek.</td></tr>";
            }
        ?>
    </table>

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