<?php
require_once 'Access.php';
class Tallas extends Controllers
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
    public function Tallas()
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

            $data['page_title'] = "Dashboard | Tallas";
            $data['page_name'] = "Tallas";
            $data['description'] = "";
            $data['breadcrumb-item'] = "Usuarios";
            $data['breadcrumb-activo'] = "Usuario";
            $data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];
            $data['page_functions_js'] = "functions_tallas.js";

            #Data modal
            $data['page_title_modal'] = "Nuevo tallas";
            $data['page_title_bold'] = "Estimado usuario";
            $data['descrption_modal1'] = "Los campos remarcados con";
            $data['descrption_modal2'] = "son necesarios.";


            #Cargo la vista(tipos). La vista esta en View - Tipos
            $this->views->getView($this, "tallas", $data);
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

    ### CONTROLADOR: MOSTRAR TODAS LAS TALLAS ###
    public function getTallas()
    {

        $arrData = $this->model->selectTallas();

        for ($i = 0; $i < count($arrData); $i++) {


            #Estado
            if ($arrData[$i]['activo'] == 1) {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-success">Activo</span>';
            } else {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
            }

            #Botones de accion
            $arrData[$i]['options'] = '<div class="text-center">
				<button type="button" class="btn btn-warning btn-sm" onClick="fntEditTallas(' . $arrData[$i]['cod_talla'] . ')" title="Editar"><i class="ri-edit-2-line"></i></button>
				<button type="button" class="btn btn-danger btn-sm" onClick="fntDelTallas(' . $arrData[$i]['cod_talla'] . ')" title="Eliminar"><i class="ri-delete-bin-5-line"></i></button>
				</div>';
        }


        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ### CONTROLADOR: GUARDAR NUEVA TALLA ###
    public function setTallas()
    {

        if ($_POST) {

            /*dep($_POST);
            exit();*/

            #Capturo los datos
            $intIdTallas = intval($_POST['idTallas']);

            $uso          = intval($_POST['comboxUso']);
            $descripcion  = strClean($_POST['txtDescripcion']);
            $status       = intval($_POST['listStatus']);

            #Si no viene ningun ID - Estoy creando 1 nuevo
            if ($intIdTallas == 0) {

                #Crear
                $request_Talla = $this->model->insertBanco($uso, $descripcion, $status);

                /* dep($request_Tipo);
                  exit();*/

                $option = 1;
            } else {
                #Actualizar
                $request_Talla = $this->model->updateBanco($intIdBanco, $name, $nota, $listLocal, $status);
                $option = 2;
            }

            #Verificar
            if ($request_Talla > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
            } else if ($request_Talla === 'existe') {
                $arrResponse = array('status' => false, 'msg' => '¡Atención! El tipo de usuario ya existe.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'No es posible almacenar los datos');
            }

            #Convierto .json
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    ###################################
    ### CONTROLADOR: ELIMINAR TALLA ###
    ###################################
    public function delTallas()
    {

        if ($_POST) {

            $intIdTalla = intval($_POST['cod_talla']);

            $requestDelete = $this->model->deleteTalla($intIdTalla);

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
