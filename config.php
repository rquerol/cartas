<?php
$servername = "localhost";
$username = "root";
$password = "Dn20032003";
$dbname = "carta";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Puedes redirigir a una página de error o simplemente mostrar el mensaje de error
    die("Connection failed: " . $e->getMessage());
}
?>
