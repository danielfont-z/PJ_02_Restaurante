<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
<?php
    require_once "conexion/conexion.php";
    session_start();
    if(!isset($_SESSION["user"])){
        header("location: login.php");
    }
?> 

<!-- hacer ifs que dependiendo del id, o mejor rol, del usuario muestre una estructura u 
otra para que el usuario administrador web tenga unas funciones, los 
camareros otra y el gerente otra -->
<div id="gerente">
    <div class="container">
        <div class="row">
            <div class="column-1 header">
                <div class="header-left"></div>
                <div class="header-center">
                    <!-- botones gestion, historico, salir -->
                    <button id="gestion-gerente" class="header-center-index">Gestión</button>
                    <button id="historico-gerente" class="header-center-historic">Histórico</button>
                    <button class="salir header-center-exit">Salir</button>
                </div>
                <div class="header-right"></div>
            </div>
        </div>
        <div class="content-gestion">
            <div class="row content-gestion-header">
                <div class="column-79 content-gestion-header-title" id="selecciona-la">
                    <!-- h1 donde irá "Selecciona la sala/Selecciona la mesa" -->
                </div>
                <div class="column-5 content-gestion-header-return">
                    <h1>Atrás</h1>
                </div>
            </div>
            <!-- divs donde se imprimen los datos dependiendo del boton clicado -->
            <div id="listado-gestion-gerente" class="row content-gestion-content">

            </div>
            <div id="listado-historico-gerente">
                <form method="get" class="historic_content">
                    <input class="pagination_input" style="width: 20%" type="text" name="tableId" placeholder="ID de mesa" value="<?php echo $_GET['tableId'] ?? ''; ?>">
                    <input class="pagination_input" style="width: 35%" type="text" name="roomName" placeholder="Nombre de Sala" value="<?php echo $_GET['roomName'] ?? ''; ?>">
                    <input class="pagination_input" style="width: 30%" type="text" name="fullName" placeholder="Encargado" value="<?php echo $_GET['fullName'] ?? ''; ?>">
                    <input class="pagination_input" style="width: 15%; cursor: pointer;" type="submit" value="Buscar">
                </form>
            </div>
        </div>
    </div>
</div>
<div id="camarero">
    <div class="container">
        <div class="row">
            <div class="column-1 header">
                <div class="header-left"></div>
                <div class="header-center">
                    <!-- botones gestion, salir -->
                    <button id="gestion-camarero" class="header-center-index">Gestión</button>
                    <button class="salir header-center-exit">Salir</button>
                </div>
                <div class="header-right"></div>
            </div>
        </div>
        <div class="content-gestion">
            <div class="row content-gestion-header">
                <div class="column-79 content-gestion-header-title" id="selecciona-la">
                    <!-- h1 donde irá "Selecciona la sala/Selecciona la mesa" -->
                </div>
                <div class="column-5 content-gestion-header-return">
                    <h1>Atrás</h1>
                </div>
            </div>
            <!-- divs donde se imprimen los datos dependiendo del boton clicado -->
            <div id="listado-gestion-camarero" class="row content-gestion-content">

            </div>
            <div id="listado-historico-gerente">

            </div>
        </div>
    </div>
</div>
<div id="mantenimiento">
    <!-- botones mantenimiento (gestion para reparar sillas o retirarlas y poner en mantenimiento), salir -->
    <button id="mantenimiento-mantenimiento">Mantenimiento</button>
    <button class="salir">Salir</button>
    <!-- divs donde se imprimen los datos dependiendo del boton clicado -->
    <div id="listado-mantenimiento">

    </div>
</div>
<div id="administrador">
<!-- botones administrar (editar, eliminar), alta (crear), salir -->
    <button id="administrar-administrador">Administrar</button>
    <button id="alta-administrador">Alta</button>
    <button class="salir">salir</button>
    <!-- divs donde se imprimen los datos dependiendo del boton clicado -->
    <div id="listado-administrar">

    </div>
    <div id="listado-alta">

    </div>
</div>

<script src="script.js"></script>
</body>
</html>