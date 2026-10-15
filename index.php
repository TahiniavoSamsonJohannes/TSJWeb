<?php
session_start();

if (!empty($_SESSION['auth'])) {
    header('Location: Home.php');
    exit();
}

header('Location: Login.php');
exit();
