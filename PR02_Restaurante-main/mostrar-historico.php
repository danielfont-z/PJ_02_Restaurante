<?php
include_once("./conexion/conexion.php");
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ./login.php");
    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;
if ($records_per_page <= 0) $records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Parámetros de filtro (ajusta según sea necesario)
$filter_tableId = isset($_GET['tableId']) && $_GET['tableId'] !== '' ? '%' . $_GET['tableId'] . '%' : null;
$filter_roomName = isset($_GET['roomName']) && $_GET['roomName'] !== '' ? '%' . $_GET['roomName'] . '%' : null;
$filter_fullName = isset($_GET['fullName']) && $_GET['fullName'] !== '' ? '%' . $_GET['fullName'] . '%' : null;

try {
    // Preparar la consulta principal
    $sqlHistorico = $pdo->prepare("SELECT tr.id, t.name as table_name, r.name, tr.table_id, tr.set_available, DATE_FORMAT(`date`, '%d/%m - %H:%i') as date, u.fullName 
    FROM tableRegister tr
    JOIN `table` t ON tr.table_id = t.id
    JOIN room r ON t.room_id = r.id
    JOIN user u ON tr.user_id = u.id
    WHERE (:tableId IS NULL OR t.name LIKE :tableId) AND (:roomName IS NULL OR r.name LIKE :roomName) AND (:fullName IS NULL OR u.fullName LIKE :fullName)
    ORDER BY tr.id DESC
    LIMIT :offset, :records_per_page");

    // Vincular parámetros
    $sqlHistorico->bindParam(':tableId', $filter_tableId);
    $sqlHistorico->bindParam(':roomName', $filter_roomName);
    $sqlHistorico->bindParam(':fullName', $filter_fullName);
    $sqlHistorico->bindParam(':offset', $offset, PDO::PARAM_INT);
    $sqlHistorico->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);

    // Ejecutar
    $sqlHistorico->execute();

    // Datos para JSON
    $resultadoHistorico = $sqlHistorico->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para la paginación
    $query_total = $pdo->prepare("SELECT COUNT(*) AS total FROM tableRegister tr
        JOIN `table` t ON tr.table_id = t.id
        JOIN room r ON t.room_id = r.id
        JOIN user u ON tr.user_id = u.id
        WHERE (:tableId IS NULL OR t.name LIKE :tableId) AND (:roomName IS NULL OR r.name LIKE :roomName) AND (:fullName IS NULL OR u.fullName LIKE :fullName)");

    $query_total->bindParam(':tableId', $filter_tableId);
    $query_total->bindParam(':roomName', $filter_roomName);
    $query_total->bindParam(':fullName', $filter_fullName);

    $query_total->execute();

    $resultadoQueryTotal = $query_total->fetchAll(PDO::FETCH_ASSOC);
    $total_pages = ceil($resultadoQueryTotal[0]['total'] / $records_per_page);

    // Formatear datos de paginación
    $pagination = [
        'page' => $page,
        'total_pages' => $total_pages,
        'records_per_page' => $records_per_page
    ];

    // Verificar si hay datos en el historial
    if (!empty($resultadoHistorico)) {
        // Agregar datos de historial al resultado JSON
        $response = [
            'historico' => $resultadoHistorico,
            'pagination' => $pagination
        ];
    } else {
        // No hay datos en el historial
        $response = [
            'message' => 'No hay datos en el historial',
            'pagination' => $pagination
        ];
    }

    // Devolver datos en formato JSON
    echo json_encode($response);

    // Cerrar conexión y liberar recursos
    $pdo = null;
} catch (Exception $e) {
    echo "Error al obtener el historial: " . $e->getMessage();
    $pdo = null;
    die();
}
?>
