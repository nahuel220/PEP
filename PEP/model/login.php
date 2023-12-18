<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../views/styles.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .form {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .login-title {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }

        .login-input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            font-size: 16px;
        }

        .login-button {
            background-color: #4CAF50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-button:hover {
            background-color: #45a049;
        }

        .link {
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php
require('../controller/conexion.php');
session_start();

if (isset($_POST['username'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['clave']);

    $query = "SELECT id, username FROM `users` WHERE username='$username' AND clave='" . md5($password) . "'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Set the user id in the session
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        header("Location: ../views/dashboard.php");
        exit();
    } else {
        echo "<div class='form'>
              <h3>Nombre de usuario/contraseña incorrectos.</h3><br/>
              <p class='link'>Haz clic aquí para <a href='login.php'>iniciar sesión</a> nuevamente.</p>
              </div>";
    }
} else {
?>
<!-- Your HTML form goes here -->
<form class="form" method="post" name="login">
    <h1 class="login-title">Login</h1>
    <input type="text" class="login-input" name="username" placeholder="Nombre de Usuario" autofocus="true"/>
    <input type="password" class="login-input" name="clave" placeholder="Contraseña"/>
    <input type="submit" value="Iniciar Sesión" name="submit" class="login-button"/>
    <p class="link"><a href="register.php">Nuevo Registro</a></p>
</form>
<?php
}
?>
</body>
</html>
