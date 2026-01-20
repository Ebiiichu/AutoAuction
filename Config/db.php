<?php
// Parametrii de conexiune conform portului nou
$host = "localhost"; 
$user = "root";
$pass = ""; // În XAMPP parola este goală implicit
$db_name = "autoaction";

// Realizarea conexiunii folosind funcția mysqli_connect
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Verificăm dacă a funcționat (Handled Error)
if (!$conn) {
    die("Conexiunea la baza de date a eșuat: " . mysqli_connect_error());
}
?>