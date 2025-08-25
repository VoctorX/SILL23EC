<?php
session_start();
require("conexion.php");

// Variable para almacenar mensajes de error
$error_message = '';

// Eliminar Proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $codigo = $_POST['codigo'];
    $sql = "DELETE FROM proveedor WHERE codigo = '$codigo'";

    try {
        if (mysqli_query($conexion, $sql)) {
            // Redirigir después de la eliminación
            header("Location: registrarProveedor.php");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        $error_message = "No se puede eliminar este proveedor porque está asociado a productos existentes.";
    }
}

// Registrar Proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['eliminar'])) {
    $tipoPersona = $_POST['tipoPersona'];
    $tipoDoc = $_POST['tipoDoc'];
    $documento = $_POST['documento'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $nit = ($tipoPersona == 'Juridica') ? $_POST['nit'] : NULL;

    $sql = "INSERT INTO proveedor (tipoPersona, tipoDoc, documento, nombres, apellidos, direccion, correo, telefono, nit) 
            VALUES ('$tipoPersona', '$tipoDoc', '$documento', '$nombres', '$apellidos', '$direccion', '$correo', '$telefono', '$nit')";

    if (mysqli_query($conexion, $sql)) {
        header("Location: registrarProveedor.php");
        exit();
    } else {
        $error_message = "Error al registrar proveedor: " . mysqli_error($conexion);
    }
}

if (isset($_SESSION['documento'])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro de Proveedores</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
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
                            <h2>Registrar <b>Proveedores</b></h2>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="#addProveedorModal" class="btn btn-success" data-toggle="modal">
                                <i class="material-icons">&#xE147;</i> <span>Agregar Proveedor</span>
                            </a>
                        </div>
                    </div>
                </div>
                <table class=" table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Tipo Persona</th>
                            <th>Tipo Documento</th>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Dirección</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>NIT</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM proveedor";
                        $resultado = mysqli_query($conexion, $sql);
                        while($row = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>
                                    <td>{$row['codigo']}</td>
                                    <td>{$row['tipoPersona']}</td>
                                    <td>{$row['tipoDoc']}</td>
                                    <td>{$row['documento']}</td>
                                    <td>{$row['nombres']}</td>
                                    <td>{$row['apellidos']}</td>
                                    <td>{$row['direccion']}</td>
                                    <td>{$row['correo']}</td>
                                    <td>{$row['telefono']}</td>
                                    <td>{$row['nit']}</td>
                                    <td>
                                        <a href='actualizarProveedor.php'><i class='material-icons' style='color: black;' title='Editar '>&#xE254;</i></a>
                                        <form method='post' action='registrarProveedor.php' style='display:inline;'>
                                            <input type='hidden' name='codigo' value='{$row['codigo']}'>
                                            <button type='submit' name='eliminar' class='delete' style='border:none; background:none; cursor:pointer;'>
                                                <i class='material-icons' title='Eliminar'>&#xE872;</i>
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

        <!-- Ingresar Proveedor -->
        <div id="addProveedorModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="registrarProveedor.php">
                        <div class="modal-header">
                            <h4 class="modal-title">Agregar Proveedor</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tipoPersona">Tipo de Persona</label>
                                <select class="form-control" name="tipoPersona" required id="tipoPersona">
                                    <option value="Natural">Persona Natural</option>
                                    <option value="Juridica">Persona Jurídica</option>
                                </select>
                            </div>
                            <div class="form-group" id="nit-field" style="display: none;">
                                <label for="nit">NIT</label>
                                <input type="number" class="form-control" name="nit" required min="1">
                            </div>
                            <div class="form-group">
                                <label for="tipoDoc">Tipo de Documento</label>
                                <select class="form-control" name="tipoDoc" required>
                                    <option value="C.C">Cédula de Ciudadanía</option>
                                    <option value="C.E">Cédula de Extranjería</option>
                                    <option value="PA">Pasaporte</option>
                                    <option value="PPT">Permiso por Protección Temporal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="documento">Documento</label>
                                <input type="number" class="form-control" name="documento" required min="1">
                            </div>
                            <div class="form-group">
                                <label for="nombres">Nombre</label>
                                <input type="text" class="form-control" name="nombres" required pattern="[A-Za-záéíóúÁÉÍÓÚ\s\-.]+" title="Por favor, ingresa solo letras.">
                            </div>
                            <div class="form-group" id="apellidos-field">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" pattern="[A-Za-záéíóúÁÉÍÓÚ\s\-.]+" title="Por favor, ingresa solo letras.">
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" name="direccion" required>
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" class="form-control" name="correo" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" class="form-control" name="telefono" required>
                            </div>

                        </div>
                        <div class ="modal-footer">
                            <input type="submit" class="btn btn-success" value="Agregar">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Ocultar el campo de apellidos y NIT al cargar la página
                $('#nit-field').hide();

                $('#addProveedorModal select[name="tipoPersona"]').on('change', function() {
                    if ($(this).val() == 'Juridica') {
                        $('#nit-field').show();
                        $('#nit-field input').prop('required', true);
                    } else {
                        $('#nit-field').hide();
                        $('#nit-field input').prop('required', false);
                    }
                });
            });
        </script>
    </body>
</html>
<?php
} else {
  header("Location: inicioSesion.php");
}
?>