<?php
session_start();
require("conexion.php");

// Variable para almacenar mensajes de error
$error_message = '';

// Eliminar Categoria
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $codigo = $_POST['codigo'];
    $sql = "DELETE FROM categoria WHERE codigo = '$codigo'";

    try {
        if (!mysqli_query($conexion, $sql)) {
            throw new Exception(mysqli_error($conexion));
        }
        header("Location: registrarCategoria.php");
        exit();
    } catch (Exception $e) {
        // Cambiar el mensaje de error si es por clave foránea
        if (mysqli_errno($conexion) == 1451) { // 1451 es el código de error para la restricción de clave foránea
            $error_message = "No se puede eliminar la categoría porque hay productos asociados a ella.";
        } else {
            $error_message = "Error al eliminar categoría: " . $e->getMessage();
        }
    }
}

// Registrar Categoria
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['eliminar'])) {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';

    $sql = "INSERT INTO categoria (nombre) VALUES ('$nombre')";

    try {
        if (!mysqli_query($conexion, $sql)) {
            throw new Exception(mysqli_error($conexion));
        }
        header("Location: registrarCategoria.php");
        exit();
    } catch (Exception $e) {
        $error_message = "Error al registrar categoría: " . $e->getMessage();
    }
}

if (isset($_SESSION['documento'])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro de Categorias</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
<div class="navbar">
        <!-- Dropdown Categoria -->
        <div class="dropdown">
            <button class="dropbtn">Gestionar Categoria 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="registrarCategoria.php">Registrar</a>
                <a href="actualizarCategoria.php">Actualizar</a>
            </div>
        </div> 
        
        <!-- Dropdown Ingresos -->
        <div class="dropdown">
            <button class="dropbtn">Gestionar Ingresos 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="registrarIngreso.php">Registrar</a>
                <a href="actualizarIngreso.php">Actualizar</a>
            </div>
        </div>
        
        <!-- Dropdown Marca -->
        <div class="dropdown">
            <button class="dropbtn">Gestionar Marca 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
            <a href="registrarMarca.php">Registrar</a>
            <a href="actualizarMarca.php">Actualizar</a>
            </div>
        </div>
        
        <!-- Dropdown Producto -->
        <div class="dropdown">
            <button class="dropbtn">Gestionar Productos 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
            <a href="registrarProducto.php">Registrar</a>
            <a href="actualizarProducto.php">Actualizar</a>
            </div>
        </div>

         <!-- Dropdown Proveedor -->
         <div class="dropdown">
            <button class="dropbtn">Gestionar Proveedor 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
            <a href="registrarProveedor.php">Registrar</a>
            <a href="actualizarProveedor.php">Actualizar</a>
            </div>
        </div>

        <!-- Dropdown Salida -->
        <div class="dropdown">
            <button class="dropbtn">Gestionar Salida 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
            <a href="registrarSalida.php">Registrar</a>
            <a href="actualizarSalida.php">Actualizar</a>
            </div>
        </div>

        <a href="cerrarSesion.php" class="right">Cerrar Sesion</a>
    </div>

<br><br>
<div class="container-xl">
    <?php if ($error_message): ?>
        <div class="alert alert-danger">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Registrar <b>Categorias</b></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="#addCategoriaModal" class="btn btn-success" data-toggle="modal">
                            <i class="material-icons">&#xE147;</i> <span>Agregar Categoria</span>
                        </a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT c.codigo, c.nombre
                            FROM categoria c";
                    $resultado = mysqli_query($conexion, $sql);
                    while($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>
                                <td>{$row['codigo']}</td>
                                <td>{$row['nombre']}</td>
                                <td>
                                    <a href='actualizarCategoria.php'><i class='material-icons' style='color: black; title='Editar'>&#xE254;</i></a>
                                    <form method='post' action='registrarCategoria.php' style='display:inline;'>
                                        <input type='hidden' name='codigo' value='{$row['codigo']}'>
                                        <button type='submit' name='eliminar' class='delete' style='border:none; background:none; cursor:pointer;'>
                                            <i class='material-icons' title='Eliminar'>&#xE872;</ i>
                                        </button>
                                    </form>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Ingresar categoria -->
    <div id="addCategoriaModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="registrarCategoria.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Categoria</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" required pattern="[A-Za-z\s]+" title="Por favor, ingresa solo letras.">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Agregar">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
<?php
} else {
  header("Location: inicioSesion.php");
}
?>
