<?php
require_once 'Access.php';
class Moneda extends Controllers
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
    public function Moneda()
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

            $data['page_title'] = "Dashboard | Moneda";
            $data['page_name'] = "Moneda";
            $data['description'] = "";
            $data['breadcrumb-item'] = "Usuarios";
            $data['breadcrumb-activo'] = "Usuario";
            $data['page_functions_js'] = "functions_moneda.js";

            #Data modal
            $data['page_title_modal'] = "Nueva moneda";
            $data['page_title_bold'] = "Estimado usuario";
            $data['descrption_modal1'] = "Los campos remarcados con";
            $data['descrption_modal2'] = "son necesarios.";
            $data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];

            #Cargo la vista(tipos). La vista esta en View - Tipos
            $this->views->getView($this, "moneda", $data);
        } else {
            echo "NO TIENES PERMISOS PARA ACCEDER A ESTA PAGINA";
            exit();
        }
    }

    ### CONTROLADOR: MOSTRAR TODAS LAS MONEDAS ###
    function mostrarMoneda()
    {
        #Modelo comboxBanco
        $arrData = $this->model->comboxMoneda();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ### CONTROLADOR: MOSTRAR TODAS LAS MONEDAS ###
    public function getMoneda()
    {
        #Cargo el modelo(selectBancos) 
        $arrData = $this->model->selectMoneda();

        for ($i = 0; $i < count($arrData); $i++) {

            #Localidad
            if ($arrData[$i]['es_local'] == 1) {
                $arrData[$i]['es_local'] = '<span class="">Nacional</span>';
            } else {
                $arrData[$i]['es_local'] = '<span class="">Internacional</span>';
            }

            #Estado
            if ($arrData[$i]['activo'] == 1) {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-success">Activo</span>';
            } else {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
            }

            #Botones de accion
            $arrData[$i]['options'] = '<div class="text-center">
				<button type="button" class="btn btn-warning btn-sm btnEditBanco" onClick="fntEditMoneda(' . $arrData[$i]['cod_moneda'] . ')" title="Editar"><i class="ri-edit-2-line"></i></button>
				<button type="button" class="btn btn-danger btn-sm btnDelBanco" onClick="fntDelMoneda(' . $arrData[$i]['cod_moneda'] . ')" title="Eliminar"><i class="ri-delete-bin-5-line"></i></button>
				</div>';
        }


        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ### CONTROLADOR: GUARDAR NUEVA MONEDA ###
    public function setMoneda()
    {

        /*dep($_POST);
        exit();*/
        if ($_POST) {

            #Capturo los datos
            $intIdMoneda = intval($_POST['idMoneda']);
            $nombre      = strClean($_POST['txtName']);
            $listLocal   = intval($_POST['listLocal']);
            $status      = intval($_POST['listStatus']);


            #Si no viene ningun ID - Estoy creando 1 nuevo
            if ($intIdMoneda == 0) {

                #Crear
                $request_Moneda = $this->model->insertMoneda($nombre, $listLocal, $status);

                dep($request_Tipo);
                exit();

                $option = 1;
            } else {
                #Actualizar
                $request_Moneda = $this->model->updateMoneda($intIdMoneda, $nombre, $listLocal, $status);
                $option = 2;
            }

            #Verificar
            if ($request_Moneda > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
            } else if ($request_Moneda === 'existe') {
                $arrResponse = array('status' => false, 'msg' => '¡Atención! El tipo de usuario ya existe.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'No es posible almacenar los datos');
            }

            #Convierto .json
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    ### CONTROLADOR: ELIMINAR MONEDA ###
    public function delMoneda()
    {
        if ($_POST) {

            $intIdMoneda = intval($_POST['cod_moneda']);

            $requestDelete = $this->model->deleteMoneda($intIdMoneda);

            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la moneda');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la moneda.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

            die();
        }
    }

    ### CONTROLADOR: EDITAR MONEDA ###    
    public function EditMoneda(int $idMoneda)
    {
        #id
        $intIdMoneda = intval($idMoneda);

        if ($intIdMoneda > 0) {
            $arrData = $this->model->editMoneda($intIdMoneda);

            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
