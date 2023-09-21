<?php
require_once 'Access.php';
class Pais extends Controllers
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
    public function Pais()
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


            $data['page_title'] = "Dashboard | Pais";
            $data['page_name'] = "Pais";
            $data['description'] = "";
            $data['breadcrumb-item'] = "Usuarios";
            $data['breadcrumb-activo'] = "Usuario";
            $data['page_functions_js'] = "functions_pais.js";

            #Data modal
            $data['page_title_modal'] = "Nuevo pais";
            $data['page_title_bold'] = "Estimado usuario";
            $data['descrption_modal1'] = "Los campos remarcados con";
            $data['descrption_modal2'] = "son necesarios.";
            $data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];

            #Cargo la vista(tipos). La vista esta en View - Tipos
            $this->views->getView($this, "pais", $data);
        } else {
            //echo "NO TIENES PERMISOS PARA ACCEDER A ESTA PAGINA";

            // El usuario no tiene permisos, redirige a su vista_inicio
            //$vistaInicio = Access::obtenerVistaInicio($userType);
            //dep($vistaInicio);

            header("Location:http://localhost/jip/app");
            exit();

            /*include  "Views/" . ucfirst($usuarioObj->vista) . "/" . $usuarioObj->vista . ".php";
                 header("Location: Views/" . ucfirst($vistaInicio) . "/" . $vistaInicio . ".php");*/
        }
    }

    ### CONTROLADOR: MOSTRAR TODOS LOS PAISES ###
    function mostrarPais()
    {
        #Modelo comboxPais
        $arrData = $this->model->comboxPais();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }


    public function getPais()
    {
        #Cargo el modelo(selectBancos) 
        $arrData = $this->model->selectPais();

        for ($i = 0; $i < count($arrData); $i++) {

            #Localidad
            if ($arrData[$i]['es_local'] == 1) {
                $arrData[$i]['es_local'] = '<span> Nacional</span>';
            } else {
                $arrData[$i]['es_local'] = '<span> Internacional</span>';
            }

            #Estado
            if ($arrData[$i]['activo'] == 1) {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-success">Activo</span>';
            } else {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
            }

            #Botones de accion
            $arrData[$i]['options'] = '<div class="text-center">
				<button type="button" class="btn btn-warning btn-sm btnEditBanco" onClick="fntEditPais(' . $arrData[$i]['cod_pais'] . ')" title="Editar"><i class="ri-edit-2-line"></i></button>
				<button type="button" class="btn btn-danger btn-sm btnDelBanco" onClick="fntDelPais(' . $arrData[$i]['cod_pais'] . ')" title="Eliminar"><i class="ri-delete-bin-5-line"></i></button>
				</div>';
        }


        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ### CONTROLADOR: GUARDAR NUEVO BANCO ###
    public function setPais()
    {

        if ($_POST) {

            /*dep($_POST);
            exit();*/

            #Capturo los datos
            $intIdPais = intval($_POST['idPais']);
            $descripcion = strClean($_POST['txtName']);
            $listLocal   = intval($_POST['listLocal']);
            $status      = intval($_POST['listStatus']);

            #Si no viene ningun ID - Estoy creando 1 nuevo
            if ($intIdPais == 0) {

                #Crear
                $request_Pais = $this->model->insertPais($descripcion, $listLocal, $status);

                /* dep($request_Tipo);
                  exit();*/

                $option = 1;
            } else {
                #Actualizar
                $request_Pais = $this->model->updatePais($intIdPais, $descripcion, $listLocal, $status);
                $option = 2;
            }

            #Verificar
            if ($request_Pais > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
            } else if ($request_Pais === 'existe') {
                $arrResponse = array('status' => false, 'msg' => '¡Atención! El banco ya existe.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'No es posible almacenar los datos');
            }

            #Convierto .json
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    ### CONTROLADOR: ELIMINAR PAIS ###
    public function delPais()
    {
        if ($_POST) {

            $intIdPais = intval($_POST['cod_pais']);

            $requestDelete = $this->model->deletePais($intIdPais);

            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el nombre del banco');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el nombre del banco.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

            die();
        }
    }

    ### CONTROLADOR: EDITAR PAIS ###    
    public function getPai(int $idPais)
    {
        #id
        $intIdPais = intval($idPais);

        if ($intIdPais  > 0) {
            $arrData = $this->model->editPais($intIdPais);

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
