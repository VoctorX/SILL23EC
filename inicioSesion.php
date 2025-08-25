<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/loginstyle.css">
    <script src='https://www.google.com/recaptcha/api.js' async defer ></script>
</head>
<body>
<div class="login-container">
    <img src="images/logo.png" alt="Logo" class="logo-image">
    <h2>INICIO DE SESIÓN</h2>
    <form action="inicioSesion.php" method="POST">
        <input type="number" name="documento" placeholder="Documento" required>
        <input type="password" name="clave" placeholder="Clave" required>
        <div class="recaptcha">
            <div class="g-recaptcha" data-sitekey="6LdVQTkqAAAAAHuj_3NNxdYoB5AMx6K78CKKqVyx"></div>
        </div>
        <input type="submit" name="enviar" value="INICIAR SESIÓN">
    </form>
    <?php
        $secret = '6LdVQTkqAAAAAIC1-IEXD3fPKYZpQlSfd8Da6Rrl';

        if (isset($_POST['enviar']) && !empty($_POST['documento']) && !empty($_POST['clave'])) {
            $documento = $_POST['documento'];
            $clave = $_POST['clave'];
            $recaptcha_response = $_POST['g-recaptcha-response'];

            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$recaptcha_response");
            $response_keys = json_decode($response, true);

            if (intval($response_keys["success"]) !== 1) {
                echo "<br>Por favor, completa el reCAPTCHA.";
            } else {
                require("conexion.php");
                $sql = "SELECT documento, nombres FROM usuario WHERE documento='$documento' AND clave = '$clave'";
                $consulta = mysqli_query($conexion, $sql);

                if ($consulta) {
                    if (mysqli_num_rows($consulta) > 0) {
                        $registro = mysqli_fetch_array($consulta);
                        $_SESSION['documento'] = $registro[0];
                        $_SESSION['nombres'] = $registro[1];
                        header("Location: home.php");
                        exit(); 
                    } else {
                        echo "<br>Documento o Clave erronea";
                    }
                } else {
                    echo "<br>No se consultó correctamente";
                }
            }
        } 
    ?>
    <div class="additional-links">
        <a href="registrarUsuario.php">Registrarse</a>
        <a href="actualizarUsuario.php">Olvide mi clave</a><br>
    </div>
</div>    
</body>
</html>