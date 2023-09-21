<?php
require_once 'Access.php';
class Modulos extends Controllers
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
    public function Modulos()
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

            $data['page_title'] = "Dashboard | Modulos";
            $data['page_name'] = "Modulos";
            $data['description'] = "";
            $data['breadcrumb-item'] = "Usuarios";
            $data['breadcrumb-activo'] = "Usuario";
            $data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];
            $data['page_functions_js'] = "functions_modulos.js";

            #Data modal
            $data['page_title_modal'] = "Nuevo banco";
            $data['page_title_bold'] = "Estimado usuario";
            $data['descrption_modal1'] = "Los campos remarcados con";
            $data['descrption_modal2'] = "son necesarios.";


            #Cargo la vista(tipos). La vista esta en View - Tipos
            $this->views->getView($this, "modulos", $data);
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


    ### CONTROLADOR: MOSTRAR TODOS LOS MODULOS ###
    public function getModulos()
    {
        #Cargo el modelo(selectBancos) 
        $arrData = $this->model->selectModulos();

        for ($i = 0; $i < count($arrData); $i++) {


            #Estado
            /* if ($arrData[$i]['activo'] == 1) {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-success">Activo</span>';
            } else {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
            }*/

            #Botones de accion
            $arrData[$i]['options'] = '<div class="text-center">
				<button type="button" class="btn btn-warning btn-sm btnEditModulo" onClick="fntEditModulo(' . $arrData[$i]['id'] . ')" title="Editar"><i class="ri-edit-2-line"></i></button>
				<button type="button" class="btn btn-danger btn-sm btnDelModulo" onClick="fntDelModulo(' . $arrData[$i]['id'] . ')" title="Eliminar"><i class="ri-delete-bin-5-line"></i></button>
				</div>';
        }


        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ########################################
    ### CONTROLADOR: GUARDAR NUEVO MODULO###
    ########################################

    public function setModulo()
    {

        /*dep($_POST);
        exit();*/

        if ($_POST) {

            #Capturo los datos
            $intIdModulo = intval($_POST['idModulo']);

            $module     = strClean($_POST['iptModulo']);
            $view       = strClean($_POST['iptVistaModulo']);
            $icon       = strClean($_POST['iptIconoModulo']);
            //$status     = intval($_POST['listStatus']);

            #Si no viene ningun ID - Estoy creando 1 nuevo
            if ($intIdModulo == 0) {

                #Crear
                $request_Modulo = $this->model->insertModulo($module, $view, $icon);

                $option = 1;
            } else {
                #Actualizar
                $request_Modulo = $this->model->updateBanco($intIdBanco, $name, $nota, $listLocal, $status);
                $option = 2;
            }

            #Verificar
            if ($request_Modulo > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
            } else if ($request_Modulo === 'existe') {
                $arrResponse = array('status' => false, 'msg' => '¡Atención! El tipo de usuario ya existe.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'No es posible almacenar los datos');
            }

            #Convierto .json
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    ##############################################
    ### CONTROLADOR: MOSTRAR TODOS LOS MODULOS ###
    ##############################################

    public function mostrarJstree()
    {
        $requestData = $this->model->mostrarJstree();

        echo json_encode($requestData, JSON_UNESCAPED_UNICODE);
    }


    ########################################
    ### CONTROLADOR: REORGANIZAR MODULOS ###
    ########################################

    public function ReorganizarModulos()
    {

        if ($_POST) {

            $modulos = $_POST['modulos'];

            $requestData = $this->model->ReorganizarJstree($modulos);

            echo json_encode($requestData, JSON_UNESCAPED_UNICODE);
        }
    }


    ##########################################
    ### CONTROLADOR: MOSTRAR PERFIL POR ID ###
    ##########################################

    public function obtenerModuloPerfil()
    {

        if ($_POST) {

            $intIdPerfil = $_POST['id_perfil'];

            $requestModuloPerfil = $this->model->ObtenerModuloPorPerfil($intIdPerfil);
            echo json_encode($requestModuloPerfil, JSON_UNESCAPED_UNICODE);
        }
    }


    ###############################
    ### REGISTRAR PERFIL MODULO ###
    ###############################
    /*public function RegistrarPerfilModulo()
    {
        require_once 'Models/PerfilModel.php';

        $idModuloSeleccionado = $_POST['idModuloSeleccionado'];
        $idPerfil = $_POST['idPerfil'];
        $modulo_inicio = $_POST['modulo_inicio'];

        $requestModuloPerfil =  PerfilModel::ObtenerModuloPorPerfil($idModuloSeleccionado, $idPerfil, $modulo_inicio);

        var_dump($requestModuloPerfil);
        exit();
        return $requestModuloPerfil;
    }*/
}
