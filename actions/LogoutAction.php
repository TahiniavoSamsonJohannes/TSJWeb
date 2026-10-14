<?php
session_start();
//Détruire toutes les sessions (variables de $_SESSION inclus)
session_destroy();
//Redirection vers la page Login
header("Location:../Login.php");


?>