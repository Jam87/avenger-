<?php
require_once 'Access.php';
class Bodegas extends Controllers
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
    public function Bodegas()
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

            $data['page_title'] = "Dashboard | Bodega";
            $data['page_name'] = "Bodega";
            $data['description'] = "";
            $data['breadcrumb-item'] = "Usuarios";
            $data['breadcrumb-activo'] = "Usuario";
            $data['page_functions_js'] = "functions_bodega.js";

            #Data modal
            $data['page_title_modal'] = "Nueva bodega";
            $data['page_title_bold'] = "Estimado usuario";
            $data['descrption_modal1'] = "Los campos remarcados con";
            $data['descrption_modal2'] = "son necesarios.";
            $data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];

            #Cargo la vista(tipos). La vista esta en View - Tipos
            $this->views->getView($this, "moneda", $data);
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

    ###########################
    ###### MOSTRAR USO ######
    ###########################

    function mostrarUso()
    {
        #Modelo comboxPais
        $arrData = $this->model->selectUso();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ### CONTROLADOR: MOSTRAR TODAS LAS BODEGAS ###
    public function getBodegas()
    {

        $arrData = $this->model->selectBodegas();

        for ($i = 0; $i < count($arrData); $i++) {


            #Estado
            if ($arrData[$i]['activo'] == 1) {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-success">Activo</span>';
            } else {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
            }

            #Botones de accion
            $arrData[$i]['options'] = '<div class="text-center">
				<button type="button" class="btn btn-warning btn-sm" onClick="fntEditBodega(' . $arrData[$i]['cod_bodega'] . ')" title="Editar"><i class="ri-edit-2-line"></i></button>
				<button type="button" class="btn btn-danger btn-sm" onClick="fntDelBodega(' . $arrData[$i]['cod_bodega'] . ')" title="Eliminar"><i class="ri-delete-bin-5-line"></i></button>
				</div>';
        }


        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    #########################################
    ### CONTROLADOR: GUARDAR NUEVA BODEGA ###
    #########################################

    public function setBodega()
    {

        if ($_POST) {

            /*dep($_POST);
            exit();*/

            #Capturo los datos
            $intIdBodega = intval($_POST['idBodega']);

            $bodega       = strClean($_POST['txtBodega']);
            $sigla        = strClean($_POST['txtSigla']);
            $descripcion  = strClean($_POST['txtDescription']);
            $status       = intval($_POST['listStatus']);

            #Si no viene ningun ID - Estoy creando 1 nuevo
            if ($intIdBodega == 0) {

                #Crear
                $request_Bodega = $this->model->insertBodega($bodega, $sigla, $descripcion, $status);

                /* dep($request_Tipo);
                  exit();*/

                $option = 1;
            } else {
                #Actualizar
                $request_Bodega = $this->model->updateBanco($intIdBanco, $name, $nota, $listLocal, $status);
                $option = 2;
            }

            #Verificar
            if ($request_Bodega > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
            } else if ($request_Bodega === 'existe') {
                $arrResponse = array('status' => false, 'msg' => '¡Atención! El tipo de usuario ya existe.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'No es posible almacenar los datos');
            }

            #Convierto .json
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    ####################################
    ### CONTROLADOR: ELIMINAR BODEGA ###
    ####################################
    public function delBodega()
    {

        if ($_POST) {

            $intIdBodega = intval($_POST['cod_bodega']);

            $requestDelete = $this->model->deleteBodega($intIdBodega);

            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el registro');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el registro.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

            die();
        }
    }

    ### CONTROLADOR: EDITAR BANCOS ###    
    public function getBanco(int $idBanco)
    {

        #id
        $intIdBanco = intval($idBanco);

        if ($intIdBanco  > 0) {
            $arrData = $this->model->editBanco($intIdBanco);
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
