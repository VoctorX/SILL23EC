<?php 
session_start();
require("conexion.php");

// Variable para almacenar mensajes de error
$error_message = '';

if (isset($_SESSION['documento'])) {
    // Verifica si se ha actualizado un producto
    if (isset($_POST['actualizar'])) {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombreProducto'];
        $valor = $_POST['valor'];
        $proveedor = $_POST['proveedor'];
        $marca = $_POST['marca'];
        $categoria = $_POST['categoria'];
        $presentacion = $_POST['presentacion'];
        $tamañoUnidad = $_POST['tamañoUnidad'];
        $unidad = $_POST['unidad'];

        // Verificar si el proveedor existe
        $sql = "SELECT * FROM proveedor WHERE codigo = '$proveedor'";
        $resultado = mysqli_query($conexion, $sql);
        
        if ($resultado === false) {
            $error_message = "Error al verificar proveedor: " . mysqli_error($conexion);
        } elseif (mysqli_num_rows($resultado) == 0) {
            // Si el proveedor no existe, mostrar un mensaje de error
            $error_message = "El proveedor con el código '$proveedor' no existe. Por favor, registre el proveedor antes de actualizar el producto.";
        } else {
            // Actualizar el producto solo si el proveedor existe
            $sql = "UPDATE producto SET nombre = '$nombre', valor = '$valor', proveedor = '$proveedor', marca = '$marca', categoria = '$categoria', presentacion = '$presentacion', tamañoUnidad = '$tamañoUnidad', unidad = '$unidad' WHERE codigo = '$codigo'";
            try {
                $resultado = mysqli_query($conexion, $sql);
                if ($resultado === false) {
                    throw new Exception("Error en la actualización: " . mysqli_error($conexion));
                }
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (Exception $e) {
                $error_message = "Error al actualizar ingreso: " . $e->getMessage();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Actualizar Salida</title>
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
                        <h2>Actualizar <b>Productos</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Valor</ th>
                        <th>Proveedor</th>
                        <th>Marca</th>
                        <th>Categoria</th>
                        <th>Presentacion</th>
                        <th>Tamaño de Unidad</th>
                        <th>Unidad</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                     $sql = " SELECT p.*, c.nombre AS categoria_nombre, pr.nombres AS proveedor_nombre, m.nombre AS marca_nombre 
                     FROM producto p 
                     LEFT JOIN categoria c ON p.categoria = c.codigo
                     LEFT JOIN proveedor pr ON p.proveedor = pr.codigo
                     LEFT JOIN marca m ON p.marca = m.codigo";
                 $resultado = mysqli_query($conexion, $sql);
                 while ($fila = mysqli_fetch_assoc($resultado)): ?>
                     <tr>
                         <td><?php echo $fila['codigo']; ?></td>
                         <td><?php echo $fila['nombre']; ?></td>
                         <td><?php echo $fila['valor']; ?></td>
                         <td><?php echo $fila['proveedor_nombre']; ?></td> <!-- Muestra el nombre del proveedor -->
                         <td><?php echo $fila['marca_nombre']; ?></td> <!-- Muestra el nombre de la marca -->
                         <td><?php echo $fila['categoria_nombre']; ?></td> <!-- Muestra el nombre de la categoría -->
                         <td><?php echo $fila['presentacion']; ?></td>
                         <td><?php echo $fila['tamañoUnidad']; ?></td>
                         <td><?php echo $fila['unidad']; ?></td>
                         <td><?php echo $fila['stock']; ?></td>
                         <td style='display: flex; align-items: center; text-align: center;'>
                            <button class='btn btn-warning' data-toggle="modal" data-target="#editar<?php echo $fila['codigo']; ?>" style='border: none; background: none; padding: 0; cursor: pointer;'>
                                <i class='material-icons' style='color: black; font-size: 24px;' title='Editar'>edit</i>
                            </button>
                            <a href='registrarProducto.php' style='margin-left: 10px;'>
                                <i class='material-icons' style='color: black;' title='Agregar'>add_circle</i>
                            </a>
                        </td>
                        </tr>
                        <!-- Modal para editar -->
                        <div class="modal fade" id="editar<?php echo $fila['codigo']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Producto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                            <div class="form-group">
                                                <label for="codigo">Código:</label>
                                                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $fila['codigo']; ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nombreProducto">Nombre del Producto:</label>
                                                <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" value="<?php echo $fila['nombre']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="valor">Valor:</label>
                                                <input type="number" step="any" min="1" class="form-control" id="valor" name="valor" value="<?php echo $fila['valor']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="proveedor">Proveedor:</label>
                                                <select class="form-control" id="proveedor" name="proveedor" required>
                                                    <?php
                                                    // Consulta para obtener todas las proveedor
                                                    $sql_proveedor = "SELECT * FROM proveedor";
                                                    $resultado_proveedor = mysqli_query($conexion, $sql_proveedor);
                                                    while ($fila_proveedor = mysqli_fetch_assoc($resultado_proveedor)): ?>
                                                        <option value="<?php echo $fila_proveedor['codigo']; ?>" <?php echo ($fila_proveedor['codigo'] == $fila['proveedor']) ? 'selected' : ''; ?>>
                                                            <?php echo $fila_proveedor['nombres']; ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="marca">Marca:</label>
                                                <select class="form-control" id="marca" name="marca" required>
                                                    <?php
                                                    // Consulta para obtener todas las marca
                                                    $sql_marca = "SELECT * FROM marca";
                                                    $resultado_marca = mysqli_query($conexion, $sql_marca);
                                                    while ($fila_marca = mysqli_fetch_assoc($resultado_marca)): ?>
                                                        <option value="<?php echo $fila_marca['codigo']; ?>" <?php echo ($fila_marca['codigo'] == $fila['marca']) ? 'selected' : ''; ?>>
                                                            <?php echo $fila_marca['nombre']; ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="categoria">Categoria:</label>
                                                <select class="form-control" id="categoria" name="categoria" required>
                                                    <?php
                                                    // Consulta para obtener todas las categorías
                                                    $sql_categorias = "SELECT * FROM categoria";
                                                    $resultado_categorias = mysqli_query($conexion, $sql_categorias);
                                                    while ($fila_categoria = mysqli_fetch_assoc($resultado_categorias)): ?>
                                                        <option value="<?php echo $fila_categoria['codigo']; ?>" <?php echo ($fila_categoria['codigo'] == $fila['categoria']) ? 'selected' : ''; ?>>
                                                            <?php echo $fila_categoria['nombre']; ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="presentacion">Presentación:</label>
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
                                                <label for="tamañoUnidad">Tamaño de Unidad:</label>
                                                <input type="number" step="any" min="1" class="form-control" id="tamañoUnidad" name="tamañoUnidad" value="<?php echo $fila['tamañoUnidad']; ?>">
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
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary" name="actualizar">Actualizar</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
} else {
  header("Location: inicioSesion.php");
}
?>