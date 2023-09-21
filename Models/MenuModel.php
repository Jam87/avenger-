<?php

require_once "conexion.php";
class MenuModel
{

    ### SON LAS OPCIONES A QUE TENGO ACCESO EL USUARIO DE ACUERDO AL PERFIL ###
    static public function obtenerMenuUsuario($idUsuario)
    {

        $stmt = Acceso::conectar()->prepare("SELECT m.id,m.modulo,m.icon_menu,m.vista,m.identifier,pm.vista_inicio 
        FROM secure_user u 
        INNER JOIN secure_user_type p 
        ON u.cod_tipo_usuario = P.cod_tipo_usuario
        INNER JOIN perfil_modulo pm 
        ON pm.id_perfil = p.cod_tipo_usuario
        INNER JOIN modulos m 
        ON m.id = pm.id_modulo
        WHERE u.cod_usuario = :id_usuario
        AND (m.padre_id is null OR m.padre_id = 0)
        ORDER BY m.orden");

        $stmt->bindParam(":id_usuario", $idUsuario, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    ### OBTENGO EL SUB MENU DE ACUERDO AL PADRE ###
    static public function obtenerSubMenuUsuario($idMenu, $id_usuario)
    {

        echo $idMenu . "<br>";
        echo $id_usuario;


        $stmt = Acceso::conectar()->prepare("SELECT m.id,m.modulo,m.icon_menu,m.vista,pm.vista_inicio
        FROM secure_user  u
        INNER JOIN secure_user_type p 
        ON u.cod_tipo_usuario = p.cod_tipo_usuario 
        INNER JOIN perfil_modulo pm 
        ON pm.id_perfil = p.cod_tipo_usuario 
        INNER JOIN modulos m 
        ON m.id = pm.id_modulo
        WHERE u.cod_usuario = :id_usuario
        AND m.padre_id = :idMenu
        ORDER BY m.orden");

        $stmt->bindParam(":idMenu", $idMenu, PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
}
