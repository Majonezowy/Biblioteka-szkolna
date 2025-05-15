<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['isAdmin'] = $user['isAdmin'];
            $_SESSION['imie'] = $user['imie'];
            $_SESSION['nazwisko'] = $user['nazwisko'];
            $_SESSION['id_klasa'] = $user['id_klasa'];
            header('Location: ../admin/index.php?message=' . urlencode('Zalogowano pomyślnie.') . '&l=0');
            $stmt->close();
            exit();
        } else {
            header('Location: ../login.php?message=' . urlencode('Nieprawidłowe hasło.') . '&l=1');
            $stmt->close();
            exit();
        }
    } else {
        header('Location: ../login.php?message=' . urlencode('Nie znaleziono użytkownika o podanym adresie email.') . '&l=2');
        $stmt->close();
        exit();
    }
}
?>