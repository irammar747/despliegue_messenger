<?php
    require_once 'conexion.php';
    require_once 'bd.php';

    session_start();

    //echo password_hash('oretania', PASSWORD_DEFAULT);
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user = $_POST['username'];
        $pass = $_POST['pass'];

        //Aquí iría la validación

        $con = conectar();

        if($con === null)die('Error de conexión');

        $usuario = findUsuario($con, $user);

        if($usuario && password_verify($pass, $usuario['password'])){
            $_SESSION['usuario'] = $usuario;
            unset($_SESSION['usuario']['password']);

            header('Location:mensajes.php');
            exit;
        }else{
            $mensaje = "Usuario y/o contraseña incorrecta";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OretaMessenger</title>
</head>
<body>
    <h1>OretaMessenger</h1>
    <form action="" method="post">
        <input type="text" name="username" id="username" placeholder="Nombre de Usuario">
        <br>
        <input type="text" name="pass" id="pass" placeholder="Contraseña">
        <br>
        <input type="submit" value="Entrar">
        <a href="nuevoUsuario.php">Registrar</a>
    </form>
    <?= $mensaje ?? '' ?>
</body>
</html>