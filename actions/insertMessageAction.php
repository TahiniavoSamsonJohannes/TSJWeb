<?php
session_start();
require __DIR__ . '/../database.php';

if (!isset($_SESSION['id']) || !isset($_POST['message'], $_POST['toUserId'])) {
    http_response_code(400);
    exit;
}

$toUserId = filter_var($_POST['toUserId'], FILTER_VALIDATE_INT);
$message = trim((string) $_POST['message']);
$image = $_FILES['message_image'] ?? null;

if ($toUserId === false || $toUserId < 1 || ($message === '' && (!$image || $image['error'] === UPLOAD_ERR_NO_FILE))) {
    http_response_code(400);
    exit;
}

$imagePath = null;
if ($image && $image['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($image['error'] !== UPLOAD_ERR_OK || $image['size'] > 5 * 1024 * 1024) { http_response_code(400); exit; }
    $finfo = new finfo(FILEINFO_MIME_TYPE); $mime = $finfo->file($image['tmp_name']);
    $types = ['image/jpeg'=>'jpg','image/png'=>'png','image/gif'=>'gif','image/webp'=>'webp'];
    if (!isset($types[$mime])) { http_response_code(400); exit; }
    $directory = dirname(__DIR__) . '/uploads/messages';
    if (!is_dir($directory) && !mkdir($directory,0755,true)) { http_response_code(500); exit; }
    $name = bin2hex(random_bytes(16)).'.'.$types[$mime];
    if (!move_uploaded_file($image['tmp_name'],$directory.'/'.$name)) { http_response_code(500); exit; }
    $imagePath = 'uploads/messages/'.$name;
}
$exists = $database->prepare('SELECT id FROM users WHERE id=?'); $exists->execute([$toUserId]);
if (!$exists->fetchColumn()) { http_response_code(404); exit; }
$insertMessage = $database->prepare("INSERT INTO chatbox (fromUser, toUser, messages, image_path) VALUES (?, ?, ?, ?)");
$insertMessage->execute([(int)$_SESSION['id'], $toUserId, $message, $imagePath]);

?>
