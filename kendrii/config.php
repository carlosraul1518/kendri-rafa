<?php
$servername = "localhost"; 
$username = "root"; 
$password = "Carlos12345";
$dbname = "kendriudb";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>