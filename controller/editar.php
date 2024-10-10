<?php
include('../conexion.php');

// Validar si la solicitud es POST y si los campos requeridos están presentes
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['nombre'], $_POST['precio'], $_POST['stock'])) {
    $idProducto = $_POST['id'];
    //pasar a mayusculas
    $nombre = strtoupper($_POST['nombre']);
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    
    // Conexión a la base de datos
    $db = new Database();
    $con = $db->getConnection();
    
    // Preparar la consulta de actualización
    $stmt = mysqli_prepare($con, "UPDATE productos SET nombre = ?, precio = ?, stock = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'sdii', $nombre, $precio, $stock, $idProducto);  // s = string, d = double, i = integer
    
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
