<?php
session_start();
require_once __DIR__ . '/../database.php';
if (isset($_SESSION['id'])) {
    $touch = $database->prepare('UPDATE users SET last_seen=NOW() WHERE id=?');
    $touch->execute([(int)$_SESSION['id']]);
    http_response_code(204);
} else {
    http_response_code(401);
}
