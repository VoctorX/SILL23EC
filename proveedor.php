<?php session_start();
if(isset($_SESSION['documento'])){

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
<title>Registrar</title>
</head>
<body>
<div class="navbar">
  <!-- Sección Gestionar proveedor -->
  <div class="dropdown">
    <button class="dropbtn">Gestionar proveedor 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="registrarProveedor.php">Registrar</a>
      <a href="actualizarProveedor.php">Actualizar</a>
      <a href="buscarProveedor.php">Buscar</a>
      <a href="eliminarProveedor.php">Eliminar</a>
    </div>
  </div> 
  
  <!-- Sección Gestionar ingresos -->
  <div class="dropdown">
    <button class="dropbtn">Gestionar ingresos 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="registrarIngreso.php">Registrar</a>
      <a href="actualizarIngreso.php">Actualizar</a>
      <a href="buscarIngreso.php">Buscar</a>
      <a href="eliminarIngreso.php">Eliminar</a>
    </div>
  </div>
  
  <!-- Sección Gestionar salidas -->
  <div class="dropdown">
    <button class="dropbtn">Gestionar salidas 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="registrarSalida.php">Registrar</a>
      <a href="actualizarSalida.php">Actualizar</a>
      <a href="buscarSalida.php">Buscar</a>
      <a href="eliminarSalida.php">Eliminar</a>
    </div>
  </div>
  
  <!-- Sección Gestionar categorías -->
  <div class="dropdown">
    <button class="dropbtn">Gestionar categorías 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="registrarCategoria.php">Registrar</a>
      <a href="actualizarCategoria.php">Actualizar</a>
      <a href="buscarCategoria.php">Buscar</a>
      <a href="eliminarCategoria.php">Eliminar</a>
    </div>
  </div>

  <!-- Sección Reportes -->
  <div class="dropdown">
  <button class="dropbtn">Reportes
    <i class="fa fa-caret-down"></i>
  </button>
    <div class="dropdown-content">
      <a href="productoReciente.php">Producto mas Nuevo</a>
      <a href="productoAntiguo.php">Producto mas Viejo</a>
      <a href="productoMayorCantidad.php">Producto con Mayores Ingresos</a>
      <a href="productoMenorCantidad.php">Producto con Menores Ingresos</a>
      <a href="productoMarca.php">Productos de una Marca</a>
      <a href="productoMasVendido.php">Producto Mas Vendido</a>
      <a href="productoMenosVendido.php">Producto Menos Vendido</a>
      <a href="productosFechas.php">Total de productos vendidos entre dos Fechas</a>
      <a href="gananciasTotales.php">Ganancias Totales</a>
      <a href="proveedorEspecifico.php">Productos de un Proveedor especifico</a>
    </div>
  </div>
  <a href="cerrarSesion.php">Cerrar Sesion</a>
</div>

<h2>Registrar proveedor</h2>
<form method="post" action="registrarProveedor.php">
    <label for="nit">NIT:</label><br>
    <input type="number" id="nit" name="nit" required><br>
    <label for="nombres">Nombres:</label><br>
    <input type="text" id="nombres" name="nombres" required><br>
    <label for="direccion">Dirección:</label><br>
    <input type="text" id="direccion" name="direccion" required><br>
    <label for="telefono">Teléfono:</label><br>
    <input type="tel" id="telefono" name="telefono" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required><br>
    <small>Formato: 123-456-7890</small><br>
    <input type="submit" name="guardar" value="Enviar">
</form>
<?php
  if(isset($_POST['guardar'])&&!empty($_POST['nit'])&&!empty($_POST['nombres'])&&!empty($_POST['direccion'])&&!empty($_POST['telefono'])){

      $nit = $_POST['nit'];
      $nombres = $_POST['nombres'];
      $direccion = $_POST['direccion'];
      $telefono = $_POST['telefono'];

      require("conexion.php");

      $sqlCheck = "SELECT * FROM proveedor WHERE nit = '$nit'";
      $result = mysqli_query($conexion, $sqlCheck);

      if (mysqli_num_rows($result) > 0) {
        echo "<br>Este nit ya está registrado, intenta con otro.";
      } else {
          $sql="INSERT INTO proveedor (nit, nombres, direccion, telefono) VALUES ('$nit', '$nombres', '$direccion', '$telefono')";

          if (mysqli_query($conexion, $sql)) {
            echo "<br>Proveedor registrado exitosamente.";
        } else {
            echo "<br>Error al registrar el proveedor: " . mysqli_error($conexion);
        }
    }
} else {
    echo "";
}
?>
<?php
} else {
    header("Location: inicioSesion.php");
}
?>
