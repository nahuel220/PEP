<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Tracker de Gastos Personales</title>
</head>
<body>

    <header>
        <h1>Bienvenido a PEP, Personal Expenses Proyect</h1>
        <p>Aqui podras tener mayor conocimiento de los gastos de tus salidas comidas <br>y gustos que te des</p>
        <center><p>En esta seccion podras ver como funciona nuestro sistema para que puedas guardar tus datos<br> sin ningun peligro</p></center>

        <a href="model/login.php">Logueo</a>
        <a href="model/register.php">Registro</a>
    </header>

    <main>
    <p>Esto conforme vayas ingresando gastos que hayas realizado con un sistema de estadisticas
                te mostrara cuanto es lo que gastas por dia, por semana y por mes. luego se podra mostrar un monto total de todos los gastos que registraste
                durante el año
            </p>
            <?php
            $desc = $_POST['description'];
            $amount = $_POST['amount'];
            $category = $_POST['category'];
            ?>
        <section class="summary">
            <h2>Resumen</h2>
            <div class="card">
                <h3>Gastos Diarios</h3>
                <p>$<?php echo"$amount";?></p>
            </div>
            <div class="card">
                <h3>Gastos Semanales</h3>
                <p>$<?php echo"$amount";?></p>
            </div>
            <div class="card">
                <h3>Gastos Mensuales</h3>
                <p>$<?php echo"$amount";?></p>
            </div>
        </section>

        <section class="expenses">
            <p>Aqui podra ingresar los gastos que vaya realizando con una descripcion del gasto como de porque
                se gasto, el monto de lo que fue gastado y una categoria de el gasto.
            </p>
            <h2>Registro de Gastos</h2>
            <form action="index.php" method="post">
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

                <button type="submit">Registrar Gasto</button>
            </form>
        </section>

        <section class="history">
            <p>Como esto es solo de prueba se mostrara solamente el gasto que ingrese, si usted se encuentra logueado
                tendra un historial completo de todos los gastos con fechas y datos en detalle sobre el gasto
            </p>
            <h2>Historial de Gastos</h2>
            <ul>
                <li>[<?php  echo"$desc"; ?>] - [<?php echo"$amount"; ?>] - [<?php echo" $category"; ?>]</li>
                <!-- Mostrar más elementos según sea necesario -->
            </ul>
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
