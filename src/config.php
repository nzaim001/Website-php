<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webproject";

$mail = "michel.9.vann@gmail.com"; // Déclaration de l'adresse de destination.

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully<br/>"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
