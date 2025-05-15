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

        $data = [];
        $labels = [];

        $sql = "SELECT DATE(data_wypozyczenia) as dzien, COUNT(*) as liczba FROM wypozyczenia GROUP BY dzien ORDER BY dzien ASC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $labels[] = $row['dzien'];
                $data[] = $row['liczba'];
            }
        }
    ?>


    <nav class="navbar">
        <a href="index.php"><i class="fa fa-fw fa-book"></i> Książki</a>
        <a href="borrowed.php"><i class="fa fa-fw fa-list-alt"></i> Wypożyczone książki</a>
        <a href="users.php"><i class="fa fa-fw fa-user"></i> Użytkownicy</a>
        <a class="active" href="stats.php"><i class="fa fa-fw fa-calculator"></i> Statystyki</a>
        <a href="../php/logout.php" class="split"><i class="fa fa-fw fa-sign-out"></i> Wyloguj się</a>
        <a href="#" class="split"><?= $_SESSION['imie'] . ' ' . $_SESSION['nazwisko'] ?></a>
    </nav>

    <h2>Statystyki wypożyczeń</h2>
    <canvas id="topKsiazkiChart" width="400" height="100"></canvas>

    <?php
        $sql = "SELECT ksiazki.tytul, COUNT(*) as liczba
        FROM wypozyczenia
        JOIN ksiazki ON wypozyczenia.id_ksiazki = ksiazki.id
        GROUP BY ksiazki.tytul
        ORDER BY liczba DESC
        LIMIT 1";

        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            echo "<h3>Najczęściej wypożyczana książka: <strong>{$row['tytul']}</strong> ({$row['liczba']} razy)</h3><br>";
        }

        $sql = "SELECT users.imie, users.nazwisko, COUNT(*) as liczba
        FROM wypozyczenia
        JOIN users ON wypozyczenia.id_uzytkownika = users.id
        WHERE MONTH(wypozyczenia.data_wypozyczenia) = MONTH(CURDATE())
        AND YEAR(wypozyczenia.data_wypozyczenia) = YEAR(CURDATE())
        GROUP BY users.id
        ORDER BY liczba DESC
        LIMIT 1";

        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            echo "<h3>Najaktywniejszy użytkownik tego miesiąca: <strong>{$row['imie']} {$row['nazwisko']}</strong> ({$row['liczba']} wypożyczeń)</h3><br>";
        }

        $sql = "SELECT COUNT(*) as liczba
        FROM wypozyczenia
        WHERE termin_zwrotu < CURDATE()
        AND data_zwrotu IS NULL";

        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            echo "<h3>Przetrzymane książki: <strong>{$row['liczba']}</strong> szt. (stan na dziś)</h3><br>";
        }

        $sql = "SELECT ksiazki.tytul, COUNT(*) as liczba
        FROM wypozyczenia
        JOIN ksiazki ON wypozyczenia.id_ksiazki = ksiazki.id
        GROUP BY ksiazki.tytul
        ORDER BY liczba DESC
        LIMIT 5";

        $result = $conn->query($sql);
        $labels = [];
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['tytul'];
            $data[] = $row['liczba'];
        }

    ?>


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
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxTop = document.getElementById('topKsiazkiChart').getContext('2d');
    new Chart(ctxTop, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Top 5 książek',
                data: <?= json_encode($data) ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>