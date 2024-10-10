<?php
// Incluir la conexión a la base de datos
include('../conexion.php');

// Verificar si los campos de usuario y contraseña han sido enviados
if (isset($_POST['loginUsername']) && isset($_POST['loginPassword'])) {
    
    // Conectar a la base de datos
    $db = new Database();
    $con = $db->getConnection();
    
    // Preparar la consulta SQL para validar el usuario y la contraseña
    $stmt = mysqli_prepare($con, "SELECT nombre_completo FROM usuarios WHERE nombre_usuario = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, 'ss', $_POST['loginUsername'], $_POST['loginPassword']);
    
    // Ejecutar la consulta
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    // Si se encontró un resultado, el usuario es válido
    if (mysqli_num_rows($resultado) == 1) {
        $fila = mysqli_fetch_assoc($resultado);
        
        // Iniciar sesión y almacenar las variables de sesión
        session_start();
        $_SESSION['login'] = "true";
        $_SESSION['nomusuario'] = $fila['nombre_completo'];  // Guardar el nombre completo del usuario
        
        // Responder con éxito
        echo json_encode(array('success' => 1));
    } else {
        // Si las credenciales no coinciden, respuesta con error
        echo json_encode(array('success' => 0));
    }
    
    // Cerrar la conexión a la base de datos
    $db->closeConnection();
} else {
    // Si no se enviaron los campos requeridos, respuesta con error
    echo json_encode(array('success' => 0));
}
?>
