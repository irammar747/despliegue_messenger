<?php

function findUsuario(PDO $con, $user):array|false{
    try{
        $stm = $con->prepare("select * from usuario where username = :user");

        $stm->bindValue(':user', $user);

        //Ejecutamos
        $stm->execute();

        return $stm->fetch(); //Un array con el resultado si existe o false si no existe

    }catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}
function findAllUsuarios(PDO $con):array{
    try{
        $stm = $con->prepare("select id, username, full_name from usuario");

        //Ejecutamos
        $stm->execute();

        return $stm->fetchAll(); //Un array con el resultado si existe o vacio si no existe

    }catch(PDOException $e){
        echo $e->getMessage();
        return [];
    }
}

function insertUsuario(PDO $con, $user, $pass, $name):bool{
    try{
        $stm = $con->prepare("insert into usuario(username, password, full_name) values(:user, :pass, :name)");

        $pass_segura = password_hash($pass, PASSWORD_DEFAULT);

        $data = [
            ':user' => $user,
            ':pass' => $pass_segura,
            ':name' => $name
        ];

        //Ejecutamos
        $stm->execute($data);

        return $stm->rowCount() === 1;

    }catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}

function findAllMensajesUsuario($con, $id_user):array{
    try{
        $stm = $con->prepare("select m.id,
                                     m.asunto,
                                     u.full_name as remitente,
                                     m.fecha_hora as fecha
                              from usuario u join mensaje m on u.id=m.id_remitente
                              where m.id_destinatario = :id_user");

        $stm->bindValue(':id_user', $id_user);

        //Ejecutamos
        $stm->execute();

        return $stm->fetchAll(); //Un array con el resultado si existe o vacio si no existe

    }catch(PDOException $e){
        echo $e->getMessage();
        return [];
    }
}

function deleteMensaje($con, $id):bool{
    try{
        $stm = $con->prepare("delete from mensaje where id = :id_mensaje");

        $stm->bindValue('id_mensaje', $id);

        //Ejecutamos
        $stm->execute();

        return $stm->rowCount() === 1;

    }catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}

function insertMensaje($con, $destinatario, $remitente, $asunto, $texto){
    try {
        // Preparamos la consulta
        $stm = $con->prepare("insert into mensaje(id_destinatario, id_remitente, asunto, texto) values(:destinatario, :remitente, :asunto, :texto)");
        
        $data = [
            ':destinatario' => $destinatario,
            ':remitente' => $remitente,
            ':asunto' => $asunto,
            ':texto' => $texto,
        ];
        
        // Ejecutamos 
        $stm->execute($data);
        
        return $stm->rowCount() == 1;

    } catch (PDOException $e) {
        // En un entorno real, aquí registrarías el error en un log
        echo $e->getMessage();
        return false;
    }
}