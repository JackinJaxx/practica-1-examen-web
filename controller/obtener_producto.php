<?php
include('../conexion.php');

// Verificar si se ha recibido el ID del producto
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idProducto = $_GET['id'];
    
    // Conexión a la base de datos
    $db = new Database();
    $con = $db->getConnection();
    
    // Preparar la consulta para obtener los detalles del producto
    $stmt = mysqli_prepare($con, "SELECT id, nombre, precio, stock FROM productos WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $idProducto);
    
    // Ejecutar la consulta y devolver los datos en formato JSON
    if (mysqli_stmt_execute($stmt)) {
        $resultado = mysqli_stmt_get_result($stmt);
        $producto = mysqli_fetch_assoc($resultado);
        
        echo json_encode(['success' => true, 'data' => $producto]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos']);
    }
    
    // Cerrar la conexión
    $db->closeConnection();
} else {
    echo json_encode(['success' => false, 'message' => 'ID no válido']);
}
?>
