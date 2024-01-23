<?php
require_once "conexion/conexion.php";
session_start();
// Verifica el rol del usuario
if (isset($_SESSION["rol"])) {
    $rol = $_SESSION["rol"];

    // Consulta para obtener la información de las salas
    $sql_salas = $pdo->prepare("SELECT r.id as room_id, 
                        CASE 
                            WHEN r.name LIKE '%Terraza%' THEN 'terrace'
                            WHEN r.name LIKE '%Comedor%' THEN 'hall'
                            WHEN r.name LIKE '%privada%' THEN 'private'
                            ELSE r.name 
                        END as room_name,
                        count(1) as table_count, 
                        SUM(IF(t.available=1, 1, 0)) as table_available 
                        FROM 
                        room r 
                        INNER JOIN 
                        `table` t ON t.room_id = r.id 
                        GROUP BY 
                        r.id");
    $sql_salas->execute();
    $resultado_salas = $sql_salas->fetchAll(PDO::FETCH_ASSOC);

    // Devuelve el resultado como JSON
    echo json_encode($resultado_salas);
} else {
    // Si el rol no está definido, devuelve un error
    http_response_code(400);
    echo json_encode(["error" => "Rol no definido"]);
}
?>
