<?php
// Iniciar la sesión
session_start();
include("../controller/conexion.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: ../index.php");
    exit();
}

// Obtener el nombre de usuario y el id de la sesión
$username = $_SESSION['username'];
$user_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Tracker de Gastos Personales</title>
</head>
<body>

    <header>
        <h1>Tracker de Gastos Personales</h1>
        <p>Bienvenido, <?php echo $username; ?></p>
    </header>

    <main>
    <?php
// Obtener la fecha actual
$currentDate = date('Y-m-d');

// Calcular la fecha de inicio de la semana actual
$startOfWeek = date('Y-m-d', strtotime('monday this week', strtotime($currentDate)));

// Calcular la fecha de inicio del mes actual
$startOfMonth = date('Y-m-01', strtotime($currentDate));

// Fetch expense history from the database
$query = "SELECT fecha, monto FROM gastos WHERE user_id = ? ORDER BY fecha DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Inicializar variables para los cálculos
$totalDailyExpenses = 0;
$totalWeeklyExpenses = 0;
$totalMonthlyExpenses = 0;

// Iterar a través del historial de gastos
while ($row = $result->fetch_assoc()) {
    $fecha = $row['fecha'];
    $monto = $row['monto'];

    // Verificar si la fecha está dentro del rango diario, semanal y mensual
    if ($fecha == $currentDate) {
        $totalDailyExpenses += $monto;
    }

    if ($fecha >= $startOfWeek && $fecha <= $currentDate) {
        $totalWeeklyExpenses += $monto;
    }

    if ($fecha >= $startOfMonth && $fecha <= $currentDate) {
        $totalMonthlyExpenses += $monto;
    }
}

// Cerrar el result set
$result->close();
?>

<section class="summary">
    <h2>Resumen</h2>
    <div class="card">
        <h3>Gastos Diarios</h3>
        <p>$<?php echo number_format($totalDailyExpenses, 2); ?></p>
    </div>
    <div class="card">
        <h3>Gastos Semanales</h3>
        <p>$<?php echo number_format($totalWeeklyExpenses, 2); ?></p>
    </div>
    <div class="card">
        <h3>Gastos Mensuales</h3>
        <p>$<?php echo number_format($totalMonthlyExpenses, 2); ?></p>
    </div>
</section>


        <section class="expenses">
            <h2>Registro de Gastos</h2>
            <form action="process_expense.php" method="post">
                <label for="description">Descripción:</label>
                <input type="text" name="description" required>

                <label for="amount">Monto:</label>
                <input type="number" name="amount" required>

                <label for="category">Categoría:</label>
                <select name="category" required>
                    <option value="comida">Comida</option>
                    <option value="transporte">Transporte</option>
                    <option value="entretenimiento">Entretenimiento</option>
                    <!-- Agregar más opciones según sea necesario -->
                </select>

                <button type="submit" name="submit">Registrar Gasto</button>
            </form>
        </section>

        <section class="history">
    <h2>Historial de Gastos</h2>
    <style>
details {
        margin-bottom: 10px;
        border: 3px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer; /* Agregamos el cursor pointer a details */
    }

    summary {
        cursor: inherit; /* Hacemos que herede el cursor de su contenedor (details) */
        font-weight: bold;
        font-size: 20px;
        width:20px;
        display: list-item; /* Ajustamos el display para mejorar la apariencia del cursor */
        list-style-type: none; /* Eliminamos el marcador de lista predeterminado */
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin-bottom: 5px;
    }
    </style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Manejar el evento de clic en los elementos de resumen
        var summaryElements = document.querySelectorAll("summary");
        summaryElements.forEach(function (summary) {
            summary.addEventListener("click", function (event) {
                // Detener la propagación del evento clic para evitar cerrar y abrir nuevamente el details
                event.stopPropagation();

                // Obtener el elemento details asociado al summary
                var details = summary.parentNode;

                // Alternar el estado abierto/cerrado al hacer clic
                details.open = !details.open;
            });
        });

        // Añadir evento clic al propio details para desplegar/cerrar
        var detailsElements = document.querySelectorAll("details");
        detailsElements.forEach(function (details) {
            details.addEventListener("click", function (event) {
                // Detener la propagación del evento clic para evitar cerrar y abrir nuevamente el details
                event.stopPropagation();

                // Alternar el estado abierto/cerrado al hacer clic
                details.open = !details.open;
            });
        });
    });
</script>


<?php
// Fetch expense history from the database
$query = "SELECT YEAR(fecha) AS year, MONTH(fecha) AS month, fecha, descripcion, monto, categoria FROM gastos WHERE user_id = ? ORDER BY fecha DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Initialize variables to track the current month and year
$currentYear = 0;
$currentMonth = 0;
$firstIteration = true;

// Iterate through the expense history and display each entry
while ($row = $result->fetch_assoc()) {
    $year = $row['year'];
    $month = $row['month'];
    $fecha = $row['fecha'];
    $descripcion = $row['descripcion'];
    $monto = $row['monto'];

    // Check if 'categoria' key exists in the row
    $categoria = isset($row['categoria']) ? $row['categoria'] : '';

    // Format the date as needed
    $formattedFecha = date("d/m/Y", strtotime($fecha));

    // Check if a new year has started
    if ($currentYear != $year || $currentMonth != $month) {
        // Close the previous month if it exists
        if (!$firstIteration) {
            echo "</ul></details>";
        }

        // Start a new month section
        echo "<details>";
        echo "<summary>" . strftime('%B', mktime(0, 0, 0, $month, 1)) . "</summary>";
        echo "<ul>";

        // Update the current month
        $currentMonth = $month;
    }

    // Display the expense entry with category
    echo "<li>$formattedFecha - $descripcion - $$monto - Categoría: $categoria</li>";

    // Update the current year
    $currentYear = $year;

    // Set the first iteration flag to false
    $firstIteration = false;
}

// Close the last month section
if (!$firstIteration) {
    echo "</ul></details>";
}

// Close the result set
$result->close();
?>  

</section>


    </main>
    <br>
    <br>
    <br>
    <footer>
        <p>© 2023 Tracker de Gastos Personales</p>
    </footer>

</body>
</html>
