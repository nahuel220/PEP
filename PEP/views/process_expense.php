<?php
session_start();
include("../controller/conexion.php");

// Check if the user is not logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        // Retrieve the user_id from the session
        $user_id = $_SESSION['id'];
        $desc = $_POST['description'];
        $monto = $_POST['amount'];
        $category = $_POST['category'];

        // Perform the database insertion here
        $query = "INSERT INTO gastos (user_id, descripcion, monto, categoria, fecha) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isds", $user_id, $desc, $monto, $category);

        try {
            if ($stmt->execute()) {
                echo "Su monto fue cargado correctamente.";
            } else {
                echo "Error al cargar el monto.";
            }
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
        }

        $stmt->close();
    } else {
        echo "Por favor complete todos los campos del formulario.";
    }
}

$conn->close();
?>
