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

    $sql = "SELECT * FROM wypozyczenia WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    $sql = "UPDATE ksiazki SET dostepna = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $result->fetch_assoc()['id_ksiazki']);
    if (!$stmt->execute()) {
        header('Location: ../admin/borrowed.php?message=' . urlencode('Nie można zwrócić książki.') . '&l=1');
        exit();
    }

    $sql = "UPDATE wypozyczenia SET oddana = 1, data_zwrotu = CURDATE() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);
    if ($stmt->execute()) {
        header('Location: ../admin/borrowed.php?message=' . urlencode('Książka została zwrócona pomyślnie.') . '&l=0');
    } else {
        header('Location: ../admin/borrowed.php?message=' . urlencode('Wystąpił błąd podczas zwracania książki.') . '&l=2');
    }
    $stmt->close();