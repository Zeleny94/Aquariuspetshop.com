<?php
$servername = "localhost";
$username = "username";
$db_name = "db_name";
$password = "password";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    // set the PDO error mode to exception
    $conn -> exec("SET CHARACTER SET utf8");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Kod greske: " . $e->getMessage();
    }
?>