<?php
try{
    $database = new PDO("mysql:host=localhost;dbname=tsjweb;charset=utf8mb4;","root","", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}
?>
