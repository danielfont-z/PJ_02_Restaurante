<?php
$dbserver = "mysql:dbname=db_pr01_restaurante;host=localhost";
$dbusername = "root";
$dbpassword = "";

try{
    $pdo = new PDO($dbserver, $dbusername, $dbpassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e){
    echo "Conexion fallida" .$e->getMessage();
}