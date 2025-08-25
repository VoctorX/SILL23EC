<?php
session_start();
require("conexion.php");

// Variable para almacenar mensajes de error
$error_message = '';

// Eliminar Producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $codigo = $_POST['codigo'];
    $sql = "DELETE FROM producto WHERE codigo = '$codigo'";

    try {
        if (!mysqli_query($conexion, $sql)) {
            throw new Exception(mysqli_error($conexion));
        }
        header("Location: registrarProducto.php");
        exit();
    } catch (Exception $e) {
        // Cambiar el mensaje de error
        $error_message = "Error al registrar producto: No se puede eliminar este producto, debido a que el stock no puede ser negativo.";
    }
}

// Registrar Producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['eliminar'])) {
    $nombre = $_POST['nombre'];
    $valor = $_POST['valor'];
    $proveedor = $_POST['proveedor'];
    $marca = $_POST['marca'];
    $categoria = $_POST['categoria'];
    $presentacion = $_POST['presentacion'];
    $tamañoUnidad = $_POST['tamañoUnidad'];
    $unidad = $_POST['unidad'];

    $sql = "INSERT INTO producto (nombre, valor, proveedor, marca, categoria, presentacion, tamañoUnidad, unidad) 
            VALUES ('$nombre', '$valor', '$proveedor', '$marca', '$categoria', '$presentacion', '$tamañoUnidad', '$unidad')";

    if (mysqli_query($conexion, $sql)) {
        header("Location: registrarProducto.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}


if (isset($_SESSION['documento'])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro de Productos</title>
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
                        <h2>Registrar <b>Productos</b></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                    <a href="#addProductModal" class="btn btn-success" data-toggle="modal">
                        <i class="material-icons">&#xE147;</i> <span>Agregar Producto</span>
                    </a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Valor</th>
                        <th>Proveedor</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Presentación</th>
                        <th>Tamaño de Unidad</th>
                        <th>Unidad</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT p.codigo, p.nombre, p.valor, pr.nombres AS proveedor, m.nombre AS marca, c.nombre AS categoria, p.presentacion, p.tamañoUnidad, p.unidad, p.stock 
                            FROM producto p 
                            JOIN proveedor pr ON p.proveedor = pr.codigo 
                            JOIN marca m ON p.marca = m.codigo 
                            JOIN categoria c ON p.categoria = c.codigo";
                    $resultado = mysqli_query($conexion, $sql);
                    while($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>
                                <td>{$row ['codigo']}</td>
                                <td>{$row['nombre']}</td>
                                <td>{$row['valor']}</td>
                                <td>{$row['proveedor']}</td>
                                <td>{$row['marca']}</td>
                                <td>{$row['categoria']}</td>
                                <td>{$row['presentacion']}</td>
                                <td>{$row['tamañoUnidad']}</td>
                                <td>{$row['unidad']}</td>
                                <td>{$row['stock']}</td>
                                <td>
                                    <a href='actualizarProducto.php'><i class='material-icons' style='color: black; title='Editar'>&#xE254;</i></a>
                                    <form method='post' action='registrarProducto.php' style='display:inline;'>
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

    <!-- Ingresar Producto -->
    <div id="addProductModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="registrarProducto.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Producto</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" required pattern="[A-Za-z\s]+" title="Por favor, ingresa solo letras.">
                        </div>
                        <div class="form-group">
                            <label for="valor">Valor</label>
                            <input type="number" step="any" min="1" class="form-control" name="valor" required>
                        </div>
                        <div class="form-group">
                            <label for="proveedor">Proveedor</label>
                            <select class="form-control " name="proveedor" required>
                                <?php
                                $sql = "SELECT * FROM proveedor";
                                $resultado = mysqli_query($conexion, $sql);
                                while($row = mysqli_fetch_assoc($resultado)) {
                                    echo "<option value='{$row['codigo']}'>{$row['nombres']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <select class="form-control" name="marca" required>
                                <?php
                                $sql = "SELECT * FROM marca";
                                $resultado = mysqli_query($conexion, $sql);
                                while($row = mysqli_fetch_assoc($resultado)) {
                                    echo "<option value='{$row['codigo']}'>{$row['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categoria">Categoría</label>
                            <select class="form-control" name="categoria" required>
                                <?php
                                $sql = "SELECT * FROM categoria";
                                $resultado = mysqli_query($conexion, $sql);
                                while($row = mysqli_fetch_assoc($resultado)) {
                                    echo "<option value='{$row['codigo']}'>{$row['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="presentacion">Presentación</label>
                            <select class="form-control" name="presentacion" required>
                              <option value="Botella de Vidrio">Botella de Vidrio</option>
                              <option value="Botella de Plastico">Botella de Plastico</option>
                              <option value="Lata">Lata</option>
                              <option value="Tetrapack">Tetrapack</option>
                              <option value="Paquete">Paquete</option>
                              <option value="Caja">Caja</option>
                              <option value="Bolsa">Bolsa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tamañoUnidad">Tamaño de Unidad</label>
                            <input type="number" step="any" min="1" class="form-control" name="tamañoUnidad" required>
                        </div>
                        <div class="form-group">
                            <label for="unidad">Unidad</label>
                            <select class="form-control" name="unidad" required>
                              <option value="Kg">Kg</option>
                              <option value="Gr">Gr</option>
                              <option value="Ml">Ml</option>
                              <option value="L">L</option>
                              <option value="Cm3">Cm3</option>
                            </select>
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
