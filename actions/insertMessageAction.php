<?php
session_start();
require __DIR__ . '/../database.php';

if (!isset($_SESSION['id']) || !isset($_POST['message'], $_POST['toUserId'])) {
    http_response_code(400);
    exit;
}

$toUserId = filter_var($_POST['toUserId'], FILTER_VALIDATE_INT);
$message = trim((string) $_POST['message']);

if ($toUserId === false || $toUserId < 1 || $message === '') {
    http_response_code(400);
    exit;
}

// Insertion du message dans la table chatbox.
$insertMessage = $database->prepare("INSERT INTO chatbox (fromUser, toUser, messages) VALUES (?, ?, ?)");
$insertMessage->execute(array($_SESSION['id'], $toUserId, $message));

?>