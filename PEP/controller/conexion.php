<?php
// Datos de conexión a la base de datos
$host = "localhost";
$usuario = "root"; // Reemplaza con tu nombre de usuario de MySQL
$contrasena = ""; // Reemplaza con tu contraseña de MySQL
$base_de_datos = "tracker_gastos"; // Reemplaza con el nombre de tu base de datos

// Conectar a la base de datos
$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// echo "Conexión exitosa a la base de datos";

// Puedes realizar consultas y operaciones en la base de datos aquí


?>
