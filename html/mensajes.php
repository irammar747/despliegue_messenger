<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location:index.php');
        exit;
    }

    var_dump($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OretaMessenger</title>
</head>
<body>
    <h1>Bienvenido <?= $_SESSION['usuario']['full_name'] ?></h1>
    <h2>Bandeja de Entrada</h2>
    <a href="cerrarSesion.php">Cerrar Sesión</a>
</body>
</html>