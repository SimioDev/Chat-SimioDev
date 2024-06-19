<?php
include('db.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $chatName = $_POST['name'];
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare('INSERT INTO chats (name, created_by) VALUES (?, ?)');
    if ($stmt->execute([$chatName, $userId])) {
        echo json_encode(['id' => $pdo->lastInsertId(), 'name' => $chatName]);
    } else {
        echo json_encode(['error' => 'Error al crear el chat']);
    }
}
?>
