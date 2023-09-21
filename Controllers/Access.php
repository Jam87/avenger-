<?php
require_once 'Models/AccessModel.php';
class Access
{

    static public function moduleId($moduleName)
    {
        $id = AccessModel::getModuleId($moduleName);
        return $id;
    }

    static public function checkPermission($userType, $module)
    {

        /*echo "El tipo de usuario es: " . $userType . "<br>";
        echo "El modulo es: " . $module;*/


        //$me =  MenuModel::obtenerMenuUsuario($idUsuario);
        $permissions = AccessModel::obtenerPermiso($userType, $module);

        return $permissions;




        // Realiza la lógica para verificar si $userType tiene permisos para $module.
        // Puedes consultar tu base de datos para verificar si existe un registro en PERFIL_MODULO que coincida con el usuario y el módulo.
        // Si el usuario no tiene permisos, puedes redirigirlo a una página de error o página de inicio.
        /*if (!$userHasPermission) {
            header("Location: /error.php");
            exit();
        }*/
    }

    static public function obtenerVistaInicio($userType)
    {
        $view = AccessModel::vista($userType);
        return $view;
    }
}
