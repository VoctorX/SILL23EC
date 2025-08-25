<?php
session_start();
require("conexion.php");

// Variable para almacenar mensajes de error
$error_message = '';

// Eliminar Salida
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $codigo = $_POST['codigo'];
    $sql = "DELETE FROM salida WHERE codigo = '$codigo'";
    if (mysqli_query($conexion, $sql)) {
        header("Location: registrarSalida.php");
        exit();
    } else {
        $error_message = "Error al eliminar: " . mysqli_error($conexion);
    }
}

// Registrar Salida
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $fechaDeSalida = $_POST['fechaDeSalida'];
    $horaDeSalida = $_POST['horaDeSalida'];
    $fechaFabricacion = $_POST['fechaFabricacion'];
    $fechaVencimiento = $_POST['fechaVencimiento'];

    $sql = "INSERT INTO salida (producto, cantidad, fechaDeSalida, horaDeSalida, fechaFabricacion, fechaVencimiento) 
            VALUES ('$producto', '$cantidad', '$fechaDeSalida', '$horaDeSalida', '$fechaFabricacion', '$fechaVencimiento')";

    try {
        if (!mysqli_query($conexion, $sql)) {
            throw new Exception(mysqli_error($conexion));
        }
        header("Location: registrarSalida.php");
        exit();
    } catch (Exception $e) {
        $error_message = "Error al registrar salida: " . $e->getMessage();
    }
}

if (isset($_SESSION['documento'])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro de Salida</title>
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
        <div class ="dropdown">
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
                        <h2>Registrar <b>Salida</b></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="#addSalidaModal" class="btn btn-success" data-toggle="modal">
                            <i class="material-icons">&#xE147;</i> <span>Agregar Salida</span>
                        </a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Fecha de Salida</th>
                        <th>Hora de Salida</th>
                        <th>Fecha de Fabricacion</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT s.codigo, s.cantidad, s.fechaDeSalida, s.horaDeSalida, s.fechaFabricacion, s.fechaVencimiento, p.nombre AS producto, pr.nombres AS proveedor 
                            FROM salida s 
                            JOIN producto p ON s.producto = p.codigo 
                            JOIN proveedor pr ON p.proveedor = pr.codigo";
                    $resultado = mysqli_query($conexion, $sql);
                    while($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>
                                <td>{$row['codigo']}</td>
                                <td>{$row['producto']}</td>
                                <td>{$row['cantidad']}</td>
                                <td>{$row['fechaDeSalida']}</td>
                                <td>{$row['horaDeSalida']}</td>
                                <td>{$row['fechaFabricacion']}</td>
                                <td>{$row['fechaVencimiento']}</td>
                                <td>
                                    <a href='actualizarSalida.php'><i class='material-icons' style='color: black; title='Editar'>&#xE254;</i></a>
                                    <form method='post' action='registrarSalida.php' style='display:inline;'>
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

    <!-- Ingresar Salida -->
<div id="addSalidaModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="registrarSalida.php">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Salida</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="producto">Producto</label>
                        <select class="form-control" name="producto" id="producto" required onchange="cargarFechas(this)">
                            <option value="">Selecciona un producto</option>
                            <?php
                            $sql = "SELECT * FROM producto"; // Asegúrate de que la tabla 'producto' existe
                            $resultado = mysqli_query($conexion, $sql);
                            while($row = mysqli_fetch_assoc($resultado)) {
                                // Asegúrate de que los datos de fecha están disponibles
                                echo "<option value='{$row['codigo']}' data-fecha-fabricacion='{$row['fechaFabricacion']}' data-fecha-vencimiento='{$row['fechaVencimiento']}'>{$row['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha de Salida</label>
                        <input type="date" name="fechaDeSalida" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Hora de Salida</label>
                        <input type="time" name="horaDeSalida" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha de Fabricación</label>
                        <input type="date" name="fechaFabricacion" id="fechaFabricacion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha de Vencimiento</label>
                        <input type="date" name="fechaVencimiento" id="fechaVencimiento" class="form-control" required>
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

<script>
function cargarFechas(select) {
    const selectedOption = select.options[select.selectedIndex];

    // Obtener las fechas de fabricación y vencimiento de los atributos de la opción seleccionada
    const fechaFabricacion = selectedOption.getAttribute('data-fecha-fabricacion');
    const fechaVencimiento = selectedOption.getAttribute('data-fecha-vencimiento');

    // Asignar las fechas a los campos correspondientes
    document.getElementById('fechaFabricacion').value = fechaFabricacion ? fechaFabricacion : '';
    document.getElementById('fechaVencimiento').value = fechaVencimiento ? fechaVencimiento : '';
}
</script>

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