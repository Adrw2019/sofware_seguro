<?php
$host = "localhost";
$user = "root";
$pass = ""; // tu contraseña de MySQL, normalmente vacía en WAMP
$dbname = "inventario";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>