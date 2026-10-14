<?php
session_start();
//Vérification si l'user a bien été authentifier
if(!$_SESSION['auth']){
    header("Location:Login.php");
    exit();
}


?>