<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("location: index.php");
    exit();
}
?>
<html>
<head>
    <title>Sistema de Pruebas UNACH</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cerulean/bootstrap.min.css">
    <link href="css/cmce-styles.css" rel="stylesheet">
    <!-- jQuery para la validación -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand"><b>Nombre de usuario:</b> <?php echo $_SESSION['nomusuario']; ?></a>
        <a href="cerrar.php"><button class="btn btn-warning">Cerrar Sesión</button></a>
    </div>
</nav>
<center>
    <br><br><br><br>

    <form action="dashboard.php" method="GET">
        <div class="formpanel" id="f1">
            <b>Buscar producto por precio mayor a:</b> <input type="text" name="pre" size="4">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    
    <br><br>
    <hr>
    <br><br>

    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
        Nuevo Producto
    </button>

    <br><br>
<?php
// Incluimos la clase Database para gestionar la conexión
include('conexion.php');
$db = new Database();
$con = $db->getConnection();

// Preparación de la consulta, con un valor por defecto para "pre"
if (isset($_GET['pre']) && is_numeric($_GET['pre'])) {
    $precio = $_GET['pre'];
    $stmt = mysqli_prepare($con, "SELECT id, nombre, precio FROM productos WHERE precio > ?");
    mysqli_stmt_bind_param($stmt, "d", $precio);  // "d" indica que estamos esperando un double
} else {
    $stmt = mysqli_prepare($con, "SELECT id, nombre, precio FROM productos");
}

// Ejecutamos la consulta y mostramos los resultados
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

echo "<table class='table' style='width:570px;'>";
echo "<thead class='table-dark'>";
echo "<th>Nombre</th>";
echo "<th>Precio</th>";
echo "<th></th>";
echo "</thead>";
echo "<tbody>";

while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>".$fila['nombre']."</td>";
    echo "<td>".$fila['precio']."</td>";
    echo "<td><a href='#' class='eliminar' data-id='".$fila['id']."'><img src='iconoeliminar.png' width='20' height='20'></a></td>";
    echo "</tr>";
}

echo "</tbody></table>";

// Cerramos la conexión
$db->closeConnection();
?>

<br><br>

<!-- Modal para registrar nuevo producto -->
<div class="modal fade" id="nuevoProductoModal" tabindex="-1" aria-labelledby="nuevoProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoProductoLabel">Registrar nuevo producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="nuevoProductoForm">
                    <div class="mb-3">
                        <label for="nombreProducto" class="form-label">Nombre del producto</label>
                        <input type="text" class="form-control" id="nombreProducto" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="precioProducto" class="form-label">Precio</label>
                        <input type="number" step="0.01" class="form-control" id="precioProducto" name="precio" required>
                    </div>
                    <div class="mb-3">
                        <label for="existenciaProducto" class="form-label">Existencia</label>
                        <input type="number" class="form-control" id="existenciaProducto" name="existencia" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="guardarProductoBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>

</center>

<!-- Footer -->
<footer class="footer bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white"><b>UC: Desarrollo de aplicaciones web y móviles [Dr. Christian Mauricio Castillo Estrada]</b></p>
    </div>
</footer>

<script>
$(document).ready(function() {

	// Actualizar producto
    $('#actualizarProductoBtn').click(function() {
        // Envío AJAX
        $.ajax({
            url: 'controller/editar.php',
            type: 'POST',
            data: $('#editarProductoForm').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Producto actualizado exitosamente');
                    $('#editarProductoModal').modal('hide');
                    location.reload(); // Recarga la página para mostrar los cambios
                } else {
                    alert('Error al actualizar el producto');
                }
            },
            error: function() {
                alert('Error en la solicitud');
            }
        });
    });

	
    // Validación y envío del formulario al hacer clic en "Guardar"
    $('#guardarProductoBtn').click(function() {
        var nombre = $('#nombreProducto').val();
        var precio = $('#precioProducto').val();
        var existencia = $('#existenciaProducto').val();
        
        // Validación básica
        if (nombre === '' || precio === '' || existencia === '') {
            alert('Todos los campos son obligatorios');
            return;
        }
        
        // Envío AJAX
        $.ajax({
            url: 'controller/insertar.php',
            type: 'POST',
            data: $('#nuevoProductoForm').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Producto registrado exitosamente');
                    $('#nuevoProductoModal').modal('hide');
                    location.reload(); // Recarga la página para mostrar el nuevo producto
                } else {
                    alert('Error al registrar el producto');
                }
            },
            error: function() {
                alert('Error en la solicitud');
            }
        });
    });

    // Eliminar producto
    $('.eliminar').click(function(e) {
        e.preventDefault();
        var idProducto = $(this).data('id');
        
        if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
            $.ajax({
                url: 'controller/eliminar.php',
                type: 'POST',
                data: { idp: idProducto },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Producto eliminado exitosamente');
                        location.reload(); // Recargar la página para actualizar la lista
                    } else {
                        alert('Error al eliminar el producto');
                    }
                },
                error: function() {
                    alert('Error en la solicitud');
                }
            });
        }
    });
});
</script>

</body>
</html>
