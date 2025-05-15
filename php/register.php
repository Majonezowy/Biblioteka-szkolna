<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $imie = $_POST['imie'] ?? '';
    $nazwisko = $_POST['nazwisko'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $klasa = $_POST['klasa'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header('Location: ../register.php?message=' . urlencode('Użytkownik o podanym adresie email już istnieje.') . '&l=1');
        $stmt->close();
        exit;
    }

    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $isAdmin = ($userCount == 0) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO users (imie, nazwisko, email, password, klasa, isAdmin) VALUES (?, ?, ?, ?, ?)");
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt->bind_param("sssss", $imie, $nazwisko, $email, $hashed_password, $klasa, $isAdmin);
    $stmt->execute();
    $stmt->close();

    header('Location: ../login.php?message=' . urlencode('Rejestracja zakończona sukcesem. Możesz się teraz zalogować.') . '&l=0');
}
?>