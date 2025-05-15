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
            header('Location: ../login.php');
            exit();
        }
        if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
            header('Location: ../dashboard/index.php');
            exit();
        }
    ?>

    <nav class="navbar">
        <a class="active" href="index.php"><i class="fa fa-fw fa-book"></i> Książki</a>
        <a href="borrowed.php"><i class="fa fa-fw fa-list-alt"></i> Wypożyczone książki</a>
        <a href="users.php"><i class="fa fa-fw fa-user"></i> Użytkownicy</a>
        <a href="stats.php"><i class="fa fa-fw fa-calculator"></i> Statystyki</a>
        <a href="../php/logout.php" class="split"><i class="fa fa-fw fa-sign-out"></i> Wyloguj się</a>
        <a href="#" class="split"><?= $_SESSION['imie'] . ' ' . $_SESSION['nazwisko'] ?></a>
    </nav>
    
    <?php
        $sql = "SELECT * FROM ksiazki WHERE dostepna = 1 ORDER BY tytul ASC";
        $result = $conn->query($sql);
        $dostepne = $result->num_rows;
    ?>

    <div class="header-bar">
        <h2>Dostępne książki (<?=$dostepne?>)</h2>
        <button class="add-button" onclick="window.location.href='../php/upsert.php'">
            <i class="fa fa-plus"></i> Dodaj książkę
        </button>
    </div>

    
    <table>
        <tr>
            <th>Tytuł</th>
            <th>Autor</th>
            <th>Gatunek</th>
            <th>Rok wydania</th>
            <th>Akcja</th>
        </tr>
        <?php
            if ($dostepne > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['tytul']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['autor']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['kategoria']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['rok_wydania']) . "</td>";
                    echo "<td>
                        <div class='action-buttons'>
                            <a href='../php/upsert.php?id=" . $row['id'] . "' class='fa fa-pencil'> Edytuj</a>
                            <a href='../php/delete.php?id=" . $row['id'] . "' class='fa fa-trash'> Usuń</a>
                            <a href='../php/borrow.php?id=" . $row['id'] . "' class='fa fa-book'> Wypożycz</a>
                        </div>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Brak książek w bazie danych.</td></tr>";
            }
        ?>
    </table>

    <?php
        $sql = "SELECT * FROM ksiazki";
        $result = $conn->query($sql);
        $wszystkie = $result->num_rows;
    ?>

    <div class="header-bar">
        <h2>Wszystkie książki (<?=$wszystkie?>)</h2>
    </div>

    
    <table>
        <tr>
            <th>Tytuł</th>
            <th>Autor</th>
            <th>Gatunek</th>
            <th>Rok wydania</th>
            <th>Akcja</th>
        </tr>
        <?php
            
            if ($wszystkie > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['tytul']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['autor']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['kategoria']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['rok_wydania']) . "</td>";
                    echo "<td>
                        <div class='action-buttons'>
                            <a href='../php/upsert.php?id=" . $row['id'] . "' class='fa fa-pencil'> Edytuj</a>
                            <a href='../php/delete.php?id=" . $row['id'] . "' class='fa fa-trash'> Usuń</a>
                        </div>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Brak książek w bazie danych.</td></tr>";
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
    
    <script src="../js/main.js"></script>
</body>
</html>