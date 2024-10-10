<?php
include('../conexion.php');

// Validar si la solicitud es POST y si el parámetro 'idp' está presente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idp'])) {
    $idProducto = $_POST['idp'];
    
    // Conexión a la base de datos
    $db = new Database();
    $con = $db->getConnection();
    
    // Preparar la consulta de eliminación
    $stmt = mysqli_prepare($con, "DELETE FROM productos WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $idProducto);  // "i" indica que esperamos un entero
    
    // Ejecutar la consulta y devolver una respuesta en formato JSON
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    
    // Cerrar la conexión
    $db->closeConnection();
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
}
?>
