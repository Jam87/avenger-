<?php
require_once 'Access.php';
class Auditoria extends Controllers
{

    public function __construct()
    {
        session_start(); #Inicio sesion
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        parent::__construct();
    }

    ### CONTROLADOR ###
    public function Auditoria()
    {




        // Obtén la parte de la URL después del dominio
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Analiza la URL para extraer el valor de $module
        $parts = explode('/', $url);
        $moduleName = end($parts); // El último segmento de la URL

        $moduleId = Access::moduleId($moduleName);

        $userType = $_SESSION['usuario'][0]['cod_tipo_usuario'];

        if (Access::checkPermission($userType, $moduleId) == true) {
            //echo "TIENES PERMISOS";


            $data['page_title'] = "Dashboard | Auditoria";
            $data['page_name'] = "Auditoria";
            $data['description'] = "";
            $data['breadcrumb-item'] = "Usuarios";
            $data['breadcrumb-activo'] = "Usuario";
            $data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];
            $data['page_functions_js'] = "functions_auditoria.js";



            #Cargo la vista(tipos). La vista esta en View - Tipos
            $this->views->getView($this, "auditoria", $data);
        } else {
            //echo "NO TIENES PERMISOS PARA ACCEDER A ESTA PAGINA";

            // El usuario no tiene permisos, redirige a su vista_inicio
            $vistaInicio = Access::obtenerVistaInicio($userType);
            //dep($vistaInicio);

            header("Location:http://localhost/jip/app");
            exit();
        }
    }


    ### CONTROLADOR: MOSTRAR TODAS LAS AUDITORIA###
    public function getAuditoria()
    {

        $arrData = $this->model->selectAuditoria();

        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }
}
