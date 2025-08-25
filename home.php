<?php session_start();
if(isset($_SESSION['documento'])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Bienvenido</title>
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

    <div class="content center">
        <p class="welcome-message">¡Bienvenido <b><?php echo $_SESSION['nombres']; ?></b>!</p>
    </div>
</div>
</body>
</html>
<?php
} else {
    header("Location:inicioSesion.php");
}
?>