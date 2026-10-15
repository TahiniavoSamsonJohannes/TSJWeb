<?php
session_start();
require_once __DIR__ . '/../database.php';
//Vérification si l'user a bien été authentifier
if(!$_SESSION['auth']){
    header("Location:Login.php");
    exit();
}
$presenceDatabase = $database ?? null;
if ($presenceDatabase && isset($_SESSION['id'])) {
    $presenceTouch = $presenceDatabase->prepare('UPDATE users SET last_seen=NOW() WHERE id=?');
    $presenceTouch->execute([(int)$_SESSION['id']]);
}


?>
