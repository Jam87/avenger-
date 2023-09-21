<?php

require_once "conexion.php";
class AccessModel
{


    //Me da el ID de la vista
    static public function getModuleId($moduleName)
    {

        $sql = "SELECT id FROM modulos WHERE modulo = :moduleName";

        $stmt = Acceso::conectar()->prepare("$sql");
        $stmt->bindParam(':moduleName', $moduleName);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id'];
        }
    }


    //Verificar si tiene permiso
    static public function obtenerPermiso($userType, $moduleId)
    {

        // Consulta SQL para verificar los permisos del usuario
        $sql = "SELECT COUNT(*) AS count FROM perfil_modulo 
                WHERE id_perfil = :userType AND id_modulo = :moduleId AND estado = 1";

        $stmt = Acceso::conectar()->prepare("$sql");

        $stmt->bindParam(":userType", $userType, PDO::PARAM_STR);
        $stmt->bindParam(":moduleId", $moduleId, PDO::PARAM_STR);

        $stmt->execute();

        $count = $stmt->fetchColumn();

        // Si el usuario tiene permisos, permite el acceso
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    static public function vista($userType)
    {

        $sql = "SELECT vista_inicio FROM perfil_modulo WHERE id_perfil = :userType";

        $stmt = Acceso::conectar()->prepare("$sql");

        $stmt->bindParam(':userType', $userType);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $vistaInicio = $row['vista_inicio'];
            return $vistaInicio;
        }
    }
}
