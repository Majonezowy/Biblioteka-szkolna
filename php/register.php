<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $imie = $data['imie'] ?? '';
    $nazwisko = $data['nazwisko'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $klasa = $data['klasa'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists']);
        $stmt->close();
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (imie, nazwisko, email, password, klasa) VALUES (?, ?, ?, ?, ?)");
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt->bind_param("sssss", $imie, $nazwisko, $email, $hashed_password, $klasa);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => true, 'message' => 'Registration successful']);
}
?>