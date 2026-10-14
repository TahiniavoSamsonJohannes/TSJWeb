<?php
try{
    $database = new PDO("mysql:host=localhost;dbname=tsjweb;","root","");
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}
?>