<?php
session_start();
require __DIR__ . '/../database.php';
header('Content-Type: application/json; charset=utf-8');
$me = (int)($_SESSION['id'] ?? 0);
$other = filter_var($_POST['userId'] ?? null, FILTER_VALIDATE_INT);
$action = $_POST['action'] ?? '';
if (!$me || !$other || $other < 1 || $other === $me) { http_response_code(400); echo json_encode(['error'=>'Invalid member']); exit; }
$pair = $database->prepare('SELECT id,user_id,friend_id,status FROM friendships WHERE (user_id=? AND friend_id=?) OR (user_id=? AND friend_id=?) LIMIT 1');
$pair->execute([$me,$other,$other,$me]);
$friendship = $pair->fetch();
if ($action === 'request') {
    if (!$friendship) {
        $stmt = $database->prepare("INSERT INTO friendships (user_id,friend_id,status) VALUES (?,?,'pending')");
        $stmt->execute([$me,$other]);
    } elseif ($friendship['status'] === 'removed') {
        $stmt = $database->prepare("UPDATE friendships SET user_id=?,friend_id=?,status='pending',created_at=CURRENT_TIMESTAMP WHERE id=?");
        $stmt->execute([$me,$other,$friendship['id']]);
    } elseif ($friendship['status'] === 'pending' && (int)$friendship['user_id'] === $other) {
        $stmt = $database->prepare("UPDATE friendships SET status='accepted' WHERE id=?"); $stmt->execute([$friendship['id']]);
    }
} elseif ($action === 'accept' && $friendship && $friendship['status'] === 'pending' && (int)$friendship['friend_id'] === $me) {
    $stmt = $database->prepare("UPDATE friendships SET status='accepted' WHERE id=?"); $stmt->execute([$friendship['id']]);
} elseif ($action === 'reject' && $friendship && $friendship['status'] === 'pending' && (int)$friendship['friend_id'] === $me) {
    $stmt = $database->prepare("DELETE FROM friendships WHERE id=?"); $stmt->execute([$friendship['id']]);
} elseif ($action === 'remove' && $friendship && $friendship['status'] === 'accepted') {
    $stmt = $database->prepare("UPDATE friendships SET status='removed' WHERE id=?"); $stmt->execute([$friendship['id']]);
} else { http_response_code(400); echo json_encode(['error'=>'Invalid friendship action']); exit; }
if (($_POST['returnTo'] ?? '') === 'Notification.php') { header('Location: ../Notification.php'); exit; }
echo json_encode(['ok'=>true]);
