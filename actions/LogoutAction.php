<?php
session_start();
require_once __DIR__ . '/../database.php';
if (isset($_SESSION['id'])) {
    $offline = $database->prepare('UPDATE users SET last_seen=DATE_SUB(NOW(), INTERVAL 2 MINUTE) WHERE id=?');
    $offline->execute([(int)$_SESSION['id']]);
}
//Détruire toutes les sessions (variables de $_SESSION inclus)
session_destroy();
//Redirection vers la page Login
header("Location:../Login.php");


?>
