<?php 
session_start();
require("conexion.php");

if (isset($_SESSION['documento'])) {
    // Verifica si se ha actualizado un producto
    if (isset($_POST['actualizar'])) {
        $codigo = $_POST['codigo']; // Captura el código de la categoria
        $nombre = $_POST['nombre'];

        $sql = "UPDATE categoria SET nombre = '$nombre' WHERE codigo = '$codigo'";
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            // Redirigir a la misma página para mostrar el cambio
            header("Location: " . $_SERVER['PHP_SELF']);
            exit(); // Asegúrate de salir después de redirigir
        } else {
            echo "Error al actualizar la categoria";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Actualizar Categoria</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" >
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<style>
    .form-container {
        width: 600px;
        background-color: rgba(128, 128, 128, 0.2); 
        padding: 5px; 
 border-radius: 10px; 
        margin: 0 auto; 
    }
    .form-group {
        margin-bottom: 0.5rem; 
    }
    .form-control {
        border-radius: 0.25rem; 
    }
</style>
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
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Actualizar <b>Categoria</b></h2>
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
                                    <td style='display: flex;  align-items: center; text-align: center;'>
                                        <button class='btn btn-warning' onclick=\"openModal('{$row['codigo']}', '{$row['nombre']}')\" style='border: none; background: none; padding: 0; cursor: pointer;'>
                                            <i class='material-icons' style='color: black; font-size: 24px;' title='Actualizar'>edit</i>
                                        </button>
                                        <a href='registrarCategoria.php' style='margin-left: 10px;'><i class='material-icons' style='color: black;' title='Agregar'>add_circle</i></a>
                                    </td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Editar Producto -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Actualizar Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="" id="updateForm">
                        <input type="hidden" name="codigo" id="codigo">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required pattern="[A-Za-z\s]+" title="Por favor, ingresa solo letras.">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="actualizar">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(codigo, nombre) {
            document.getElementById('codigo').value = codigo;
            document.getElementById('nombre').value = nombre;
            $('#updateModal').modal('show');
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
} else {
  header("Location: inicioSesion.php");
}
?>