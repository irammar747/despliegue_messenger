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