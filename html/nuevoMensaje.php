<?php
require_once 'conexion.php';
require_once 'bd.php';

session_start();

// 1. Protección de ruta para que no puedas acceder a esta página si no estás logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

$con = conectar();
if($con===null)die('Error de conexión');

$usuarios = findAllUsuarios($con);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $destinatario = $_POST['destinatario']; //Aqui habría que avlidar que hay un usuario al menos seleccionado
    $asunto = $_POST['asunto'];
    $texto = $_POST['texto'];

    if(insertMensaje($con, $destinatario, $_SESSION['usuario']['id'], $asunto, $texto) === false){
        $mensaje = "Error al enviar el mensaje";
    }else{
        $mensaje = "Mensaje enviado";
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
    <a href="mensajes.php">⬅ Volver a la bandeja</a>
    <br>
    <form action="" method="post">
        
        <select name="destinatario" id="destinatario">
            <option value="">Seleccione destinatario...</option>
            <?php foreach($usuarios as $u): ?>
                
                <option value="<?= htmlspecialchars($u['id'])?>"><?= htmlspecialchars($u['full_name'])?></option>
                
            <?php endforeach; ?>
        </select>
        <br>
        <input type="text" name="asunto" id="asunto" placeholder="Asunto">
        <br>
        <textarea name="texto" id="texto" placeholder="Escribe tu mensaje aquí..."></textarea>
        <br>
        <input type="submit" value="Enviar">
    </form>
    <?= $mensaje ?? '' ?>
    
</body>
</html>