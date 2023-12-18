<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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

        .message-container {
            text-align: center;
            max-width: 300px;
            margin: 0 auto;
        }

        .success-message {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .error-message {
            background-color: #e74c3c;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php
        require('../controller/conexion.php');

        if (isset($_POST['username'])) {
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($conn, $username);
            $email    = stripslashes($_REQUEST['email']);
            $email    = mysqli_real_escape_string($conn, $email);
            $password = stripslashes($_REQUEST['clave']);
            $password = mysqli_real_escape_string($conn, $password);

            $query    = "INSERT into `users` (username, clave, email) VALUES ('$username', '" . md5($password) . "', '$email')";
            $result   = mysqli_query($conn, $query) or die(mysqli_error($conn));

            if ($result) {
                echo "<div class='message-container'>
                        <div class='success-message'>
                            <h3>Registro exitoso.</h3>
                        </div>
                        <p class='link'>Haz clic aquí para <a href='login.php'>iniciar sesión</a></p>
                      </div>";
            } else {
                echo "<div class='message-container'>
                        <div class='error-message'>
                            <h3>Faltan campos obligatorios.</h3>
                        </div>
                        <p class='link'>Haz clic aquí para <a href='register.php'>registrarte</a> nuevamente.</p>
                      </div>";
            }
        } else {
    ?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Registro</h1>
        <input type="text" class="login-input" name="username" placeholder="Nombre de Usuario" required />
        <input type="text" class="login-input" name="email" placeholder="Correo Electrónico">
        <input type="password" class="login-input" name="clave" placeholder="Contraseña">
        <input type="submit" name="submit" value="Registrar" class="login-button">
        <p class="link"><a href="login.php">Haz clic para iniciar sesión</a></p>
    </form>
    <?php
        }
    ?>
</body>
</html>
