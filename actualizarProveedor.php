<?php 
session_start();
require("conexion.php");

$error_message = '';

if (isset($_SESSION['documento'])) {
    if (isset($_POST['actualizar'])) {
        var_dump($_POST); // Para verificar si los datos se están recibiendo
        $codigo = $_POST['codigo'];
        $tipoPersona = $_POST['tipoPersona'];
        $tipoDoc = $_POST['tipoDoc'];
        $documento = $_POST['documento'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $direccion = $_POST['direccion'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $nit = ($tipoPersona == 'Juridica') ? $_POST['nit'] : NULL;

        $sql = "UPDATE proveedor SET tipoPersona = '$tipoPersona', tipoDoc = '$tipoDoc', documento = '$documento', nombres = '$nombres', apellidos = '$apellidos', direccion = '$direccion', correo = '$correo', telefono = '$telefono', nit = '$nit' WHERE codigo = '$codigo'";
        
        $resultado = mysqli_query($conexion, $sql);
        
        if ($resultado === false) {
            $error_message = "Error en la actualización: " . mysqli_error($conexion);
        } else {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Actualizar Proveedor</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
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
                        <h2>Actualizar <b>Proveedor</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Tipo Persona</th>
                        <th>Tipo Documento</ th>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Direccion</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Nit</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                     $sql = "SELECT * FROM proveedor"; // Cambiado para obtener todos los proveedores
                     $resultado = mysqli_query($conexion, $sql);
                     while ($fila = mysqli_fetch_assoc($resultado)): ?>
                         <tr>
                             <td><?php echo $fila['codigo']; ?></td>
                             <td><?php echo $fila['tipoPersona']; ?></td>
                             <td><?php echo $fila['tipoDoc']; ?></td>
                             <td><?php echo $fila['documento']; ?></td>
                             <td><?php echo $fila['nombres']; ?></td>
                             <td><?php echo $fila['apellidos']; ?></td>
                             <td><?php echo $fila['direccion']; ?></td>
                             <td><?php echo $fila['correo']; ?></td>
                             <td><?php echo $fila['telefono']; ?></td>
                             <td><?php echo $fila['nit']; ?></td>
                             <td style='display: flex; align-items: center; text-align: center;'>
                                 <button class='btn btn-warning' data-toggle="modal" data-target="#editar<?php echo $fila['codigo']; ?>" style='border: none; background: none; padding: 0; cursor: pointer;'>
                                     <i class='material-icons' style='color: black; font-size: 24px;' title='Editar'>edit</i>
                                 </button>
                                 <a href='registrarProveedor.php' style='margin-left: 10px;'>
                                     <i class='material-icons' style='color: black;' title='Agregar'>add_circle</i>
                                 </a>
                             </td>
                         </tr>
                         <div id="editar<?php echo $fila['codigo']; ?>" class="modal fade">
    <!-- Editar-->
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="actualizarProveedor.php">
                <input type="hidden" name="codigo" value="<?php echo $fila['codigo']; ?>">
                    <div class="modal-header">
                        <h4 class="modal-title">Actualizar Proveedor</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div class="form-group">
                        <label for="tipoPersona">Tipo de Persona</label>
                        <select class="form-control" name="tipoPersona" id="tipoPersona<?php echo $fila['codigo']; ?>" required>
                            <option value="Natural" <?php echo ($fila['tipoPersona'] == 'Natural') ? 'selected' : ''; ?>>Persona Natural</option>
                            <option value="Juridica" <?php echo ($fila['tipoPersona'] == 'Juridica') ? 'selected' : ''; ?>>Persona Jurídica</option>
                        </select>
                    </div>
                    <div class="form-group" id="nit-field<?php echo $fila['codigo']; ?>" style="display: <?php echo ($fila['tipoPersona'] == 'Juridica') ? 'block' : 'none'; ?>;">
                        <label for="nit">NIT</label>
                        <input type="number" class="form-control" min="1" name="nit" value="<?php echo $fila['nit']; ?>" <?php echo ($fila['tipoPersona'] == 'Juridica') ? 'required' : ''; ?>>
                    </div>
                    <div class="form-group">
                        <label for="tipoDoc">Tipo de Documento</label>
                        <select class="form-control" name="tipoDoc" required>
                            <option value="C.C" <?php echo ($fila['tipoDoc'] == 'C.C') ? 'selected' : ''; ?>>Cédula de Ciudadanía</option>
                            <option value="C.E" <?php echo ($fila['tipoDoc'] == 'C.E') ? 'selected' : ''; ?>>Cédula de Extranjería</option>
                            <option value="PA" <?php echo ($fila['tipoDoc'] == 'PA') ? 'selected' : ''; ?>>Pasaporte</option>
                            <option value="PPT" <?php echo ($fila['tipoDoc'] == 'PPT') ? 'selected' : ''; ?>>Permiso por Protección Temporal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="documento">Documento</label>
                        <input type="number" class="form-control" name="documento" value="<?php echo $fila['documento']; ?>" required min="1">
                    </div>
                    <div class="form-group">
                        <label for="nombres"> Nombres</label>
                        <input type="text" class="form-control" name="nombres" value="<?php echo $fila['nombres']; ?>" required pattern="[A-Za-záéíóúÁÉÍÓÚ\s\-.]+">
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" value="<?php echo $fila['apellidos']; ?> " pattern="[A-Za-záéíóúÁÉÍÓÚ\s\-.]+">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" name="direccion" value="<?php echo $fila['direccion']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" name="correo" value="<?php echo $fila['correo']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" class="form-control" name="telefono" value="<?php echo $fila['telefono']; ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="actualizar" class="btn btn-success" value="Actualizar">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Función para mostrar/ocultar el campo NIT
        function toggleNitField(codigo) {
            var nitField = $('#nit-field' + codigo);
            var tipoPersona = $('#tipoPersona' + codigo).val();

            if (tipoPersona === 'Juridica') {
                nitField.show();
                nitField.find('input').prop('required', true);
            } else {
                nitField.hide();
                nitField.find('input').prop('required', false).val(''); // Limpiar el campo de NIT
            }
        }

        // Escuchar el cambio en el tipo de persona para cada modal
        $('[id^=tipoPersona]').on('change', function() {
            var codigo = $(this).attr('id').replace('tipoPersona', '');
            toggleNitField(codigo);
        });

        // Llamar a la función al abrir el modal para establecer el estado inicial
        $('[id^=editar]').on('show.bs.modal', function() {
            var codigo = $(this).attr('id').replace('editar', '');
            toggleNitField(codigo);
        });
    });
</script>
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