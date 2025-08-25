<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>
    <div class="login-container">
        <h1>Registro de Usuario</h1>
        <form action="registrarUsuario.php" method="POST">
            <input type="number" name="documento" placeholder="Documento" required>
            <input type="text" name="nombres" placeholder="Nombres" pattern="[A-Za-záéíóúñÑ ]+" required title="Solo se permiten letras y espacios." required>
            <input type="text" name="apellidos" placeholder="Apellidos" pattern="[A-Za-záéíóúñÑ ]+" required title="Solo se permiten letras y espacios." required>
            <input type="password" name="clave" placeholder="Clave" required>
            <input type="submit" name="guardar" value="GUARDAR"><br>
        </form>
        <?php
            if(isset($_POST['guardar'])&&!empty($_POST['documento'])&&!empty($_POST['nombres'])&&!empty($_POST['apellidos'])&&!empty($_POST['clave'])){

                $documento = $_POST['documento'];
                $nombres = $_POST['nombres'];
                $apellidos = $_POST['apellidos'];
                $clave = $_POST['clave'];

                require("conexion.php");
                $sql="INSERT INTO usuario (documento, nombres, apellidos, clave) VALUES ('$documento', '$nombres', '$apellidos', '$clave')";

                try {
                    $consulta = mysqli_query($conexion, $sql);
                    echo "<br>Usuario registrado exitosamente.";
                } catch (mysqli_sql_exception $e) {
                    if ($e->getCode() === 1062) {
                        echo "<br>No se pudo registrar al usuario debido a que el documento ya está registrado, usa otro documento.";
                    } else {
                        echo "Ha ocurrido un error. Intenta nuevamente más tarde.";
                    }
                }

            }
        ?>
        <br>
        <a href="inicioSesion.php">Inicie Sesion</a>
    </div>
</body>
</html>