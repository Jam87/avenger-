<?php
require_once 'Access.php';
class Kardex extends Controllers
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
    public function Kardex()
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

            $data['page_title'] = "Dashboard | Movimiento inventario";
            $data['page_name'] = "Moviento de inventario";
            $data['description'] = "";
            $data['breadcrumb-item'] = "Usuarios";
            $data['breadcrumb-activo'] = "Usuario";
            $data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];
            $data['page_functions_js'] = "functions_kardex.js";

            #Data modal
            $data['page_title_modal'] = "";
            $data['page_title_bold'] = "Estimado usuario";
            $data['descrption_modal1'] = "Los campos remarcados con";
            $data['descrption_modal2'] = "son necesarios.";


            #Cargo la vista(tipos). La vista esta en View - Tipos
            $this->views->getView($this, "kardex", $data);
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
    ###### MOSTRAR COLOR ######
    ###########################

    function mostrarColor()
    {
        #Modelo comboxPais
        $arrData = $this->model->selectColor();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ###########################
    ###### MOSTRAR TALLA ######
    ###########################

    function mostrarTalla()
    {
        #Modelo comboxPais
        $arrData = $this->model->selectTallas();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ###########################
    ###### MOSTRAR BODEGA #####
    ###########################

    function mostrarBodega()
    {
        #Modelo comboxPais
        $arrData = $this->model->selectBodegas();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }


    ##############################################
    ### CONTROLADOR: OBTENER CONSECUTIVO ###
    #############################################

    public function setConsecutivo()
    {

        #Modelo comboxBanco
        $arrData = $this->model->obtenerConsecutivo();

        // Obtener el último consecutivo
        $ultimoConsecutivo = $arrData['ultimo_consecutivo'];

        // Incrementar el último consecutivo en 1 para el nuevo registro
        $nuevoConsecutivo = $ultimoConsecutivo + 1;

        echo $nuevoConsecutivo;



        /* echo json_encode($nuevoConsecutivo, JSON_UNESCAPED_UNICODE);
        exit();*/
    }


    ### CONTROLADOR: MOSTRAR TODOS LOS BANCOS ###
    public function getBancos()
    {
        #Cargo el modelo(selectBancos) 
        $arrData = $this->model->selectBancos();

        for ($i = 0; $i < count($arrData); $i++) {

            #Localidad
            if ($arrData[$i]['es_local'] == 1) {
                $arrData[$i]['es_local'] = '<img id="header-lang-img" src="https://jip.grupopaniagua.com/assets/images/flags/nic.svg" alt="Header Language" height="20" class="rounded"><span> Nacional</span>';
            } else {
                $arrData[$i]['es_local'] = '<img id="header-lang-img" src="https://jip.grupopaniagua.com/assets/images/flags/int.svg" alt="Header Language" height="20" class="rounded"><span> Internacional</span>';
            }

            #Estado
            if ($arrData[$i]['activo'] == 1) {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-success">Activo</span>';
            } else {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
            }

            #Botones de accion
            $arrData[$i]['options'] = '<div class="text-center">
				<button type="button" class="btn btn-warning btn-sm btnEditBanco" onClick="fntEditBanco(' . $arrData[$i]['cod_bancos'] . ')" title="Editar"><i class="ri-edit-2-line"></i></button>
				<button type="button" class="btn btn-danger btn-sm btnDelBanco" onClick="fntDelBanco(' . $arrData[$i]['cod_bancos'] . ')" title="Eliminar"><i class="ri-delete-bin-5-line"></i></button>
				</div>';
        }


        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ### CONTROLADOR: GUARDAR NUEVO BANCO ###
    public function setBanco()
    {

        if ($_POST) {

            /*dep($_POST);
            exit();*/

            #Capturo los datos
            $intIdBanco = intval($_POST['idBanco']);

            $name       = strClean($_POST['txtName']);
            $nota       = strClean($_POST['txtDescription']);
            $listLocal  = intval($_POST['listLocal']);
            $status     = intval($_POST['listStatus']);

            #Si no viene ningun ID - Estoy creando 1 nuevo
            if ($intIdBanco == 0) {

                #Crear
                $request_Banco = $this->model->insertBanco($name, $nota, $listLocal, $status);

                /* dep($request_Tipo);
                  exit();*/

                $option = 1;
            } else {
                #Actualizar
                $request_Banco = $this->model->updateBanco($intIdBanco, $name, $nota, $listLocal, $status);
                $option = 2;
            }

            #Verificar
            if ($request_Banco > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
            } else if ($request_Banco === 'existe') {
                $arrResponse = array('status' => false, 'msg' => '¡Atención! El tipo de usuario ya existe.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'No es posible almacenar los datos');
            }

            #Convierto .json
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    ### CONTROLADOR: ELIMINAR BANCO ###
    public function delBanco()
    {

        if ($_POST) {

            $intIdBanco = intval($_POST['cod_bancos']);

            $requestDelete = $this->model->deleteBanco($intIdBanco);

            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el nombre del banco');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el nombre del banco.');
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
