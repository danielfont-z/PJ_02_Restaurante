<?php
$email = $_POST["email"];
$password = $_POST["password"];

include_once("../conexion/conexion.php");

$sql = $pdo->prepare('SELECT id, rol, pwd FROM user WHERE email = :email');

$sql->bindParam(":email", $email);

$sql->execute();

if($sql->rowCount() > 0){
    $sql->bindColumn('id', $id);
    $sql->bindColumn('rol', $rol);
    $sql->bindColumn('pwd', $pwd);
    $sql->fetch();

    if (password_verify($password, $pwd)){
        session_start();
        $_SESSION["user"] = $id;
        $_SESSION["rol"] = $rol;
        header('location: ../index.php');
    } else{
        header('location: ../login.php?passwordMal=true');
    }
} else {
    require_once("./funciones.php");
    if(ValidaCampoVacio($email)){
        header('location: ../login.php?emailEmpty=true');
    }else{
        header('location: ../login.php?emailMal=true');
    }
}
?>