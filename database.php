<?php
$dbHost = 'sql208.infinityfree.com';
$dbPort = 3306;
$dbName = 'if0_43180411_tsjweb';
$dbUsername = 'if0_43180411';
$dbPassword = '12345678TSJ';

try {
    $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
    $database = new PDO($dsn, $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    echo "Database connection error.";
}
?>
