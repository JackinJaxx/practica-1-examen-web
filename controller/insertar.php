<?php
include('../conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validamos que se reciban los datos
    if (isset($_POST['nombre'], $_POST['precio'], $_POST['existencia'])) {
        //pasar a mayusulas
        $nombre = strtoupper($_POST['nombre']);
        $precio = $_POST['precio'];
        $existencia = $_POST['existencia'];
        
        // Conexión a la base de datos
        $db = new Database();
        $con = $db->getConnection();
        
        // Preparamos la consulta de inserción
        $stmt = mysqli_prepare($con, "INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sdi', $nombre, $precio, $existencia); // sdi: string, double, int
        
        // Ejecutamos y comprobamos si fue exitoso
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        
        // Cerramos la conexión
        $db->closeConnection();
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
