<?php
session_start();

$responseRol = isset($_SESSION["rol"]) ? $_SESSION["rol"] : "guest";

header('Content-Type: application/json');
echo json_encode(array('rol' => $responseRol));