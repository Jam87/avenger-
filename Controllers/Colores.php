<?php
require_once 'Access.php';
class Colores extends Controllers
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
    public function Colores()
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

            $data['page_title'] = "Dashboard | Colores";
            $data['page_name'] = "Colores";
            $data['description'] = "";
            $data['breadcrumb-item'] = "Usuarios";
            $data['breadcrumb-activo'] = "Usuario";
            $data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];
            $data['page_functions_js'] = "functions_colores.js";

            #Data modal
            $data['page_title_modal'] = "Nuevo color";
            $data['page_title_bold'] = "Estimado usuario";
            $data['descrption_modal1'] = "Los campos remarcados con";
            $data['descrption_modal2'] = "son necesarios.";
            $data['data-sidebar-size'] = 'lg';

            #Cargo la vista(tipos). La vista esta en View - Tipos
            $this->views->getView($this, "colores", $data);
        } else {
            //echo "NO TIENES PERMISOS PARA ACCEDER A ESTA PAGINA";

            // El usuario no tiene permisos, redirige a su vista_inicio
            //$vistaInicio = Access::obtenerVistaInicio($userType);
            //dep($vistaInicio);

            header("Location:http://localhost/jip/app");
            exit();
        }
    }



    ### CONTROLADOR: MOSTRAR TODOS LOS COLORES ###
    function mostrarColor()
    {
        #Modelo comboxPais
        $arrData = $this->model->selectColores();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }


    ### CONTROLADOR: MOSTRAR TODOS LOS COLORES ###
    public function getColores()
    {
        #Cargo el modelo(selectBancos) 
        $arrData = $this->model->selectColores();

        for ($i = 0; $i < count($arrData); $i++) {

            #Estado
            if ($arrData[$i]['activo'] == 1) {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-success">Activo</span>';
            } else {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
            }

            #Botones de accion
            $arrData[$i]['options'] = '<div class="text-center">
				<button type="button" class="btn btn-warning btn-sm btnEditPres" onClick="fntEditColor(' . $arrData[$i]['cod_color'] . ')" title="Editar"><i class="ri-edit-2-line"></i></button>
				<button type="button" class="btn btn-danger btn-sm btnDelPres" onClick="fntDelColor(' . $arrData[$i]['cod_color'] . ')" title="Eliminar"><i class="ri-delete-bin-5-line"></i></button>
				</div>';
        }


        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ### CONTROLADOR: GUARDAR NUEVO COLOR ###
    public function setColores()
    {
        if ($_POST) {

            /*dep($_POST);
            exit();*/

            #Capturo los datos
            $intIdColor   = intval($_POST['idColor']);
            $descripcion  = strClean($_POST['txtName']);
            $txtColor     = strClean($_POST['txtColor']);
            $status       = intval($_POST['listStatus']);

            #Si no viene ningun ID - Estoy creando 1 nuevo
            if ($intIdColor == 0) {

                #Crear
                $request_Color = $this->model->insertColor($descripcion, $txtColor, $status);

                /* dep($request_Tipo);
                  exit();*/

                $option = 1;
            } else {
                #Actualizar              
                $request_Color = $this->model->updateColor($intIdColor, $descripcion, $txtColor, $status);
                $option = 2;
            }

            #Verificar
            if ($request_Color > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
            } else if ($request_Color === 'existe') {
                $arrResponse = array('status' => false, 'msg' => '¡Atención! La presentación ya existe.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'No es posible almacenar los datos');
            }

            #Convierto .json
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    ### CONTROLADOR: ELIMINAR Color###
    public function delColor()
    {
        if ($_POST) {

            $intIdColor = intval($_POST['cod_color']);

            $requestDelete = $this->model->deleteColor($intIdColor);

            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el registro');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el registro.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

            die();
        }
    }

    ### CONTROLADOR: EDITAR COLOR ###    
    public function EditColor(int $idColor)
    {
        #id
        $intIdColor = intval($idColor);

        if ($intIdColor  > 0) {
            $arrData = $this->model->editColor($intIdColor);

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
