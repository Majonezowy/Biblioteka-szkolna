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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM ksiazki WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    header('Location: ../admin/index.php');