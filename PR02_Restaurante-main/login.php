<?php
    include 'conexion/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <!--Contenedor Iniciar sesión -->
    <div class="login-container">
        <div class="login-title">
            <h2 style="text-align: center;">Login</h2>
        </div>

        <!--Contenedor Usuario y Contraseña -->
        <form action="validaciones/validar-login.php" method="POST">
            <div>
                <span><i class="fa-solid fa-user"></i></span>
                <label for="email" name="email">E-mail</label>
                <input type="email" name="email" id="email">

                <span><i class="fa-solid fa-lock"></i></span>
                <label for="password" name="password">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control password">
                <br>
            </div>
            
            <!--Botones submit -->
            <div class="login-button">
                <button name="submit" class="submit-button">Iniciar Sesión</button>
            </div>
        </form>
    </div>
</body>
</html>