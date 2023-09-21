<?php
require_once 'Access.php';
class Cliente extends Controllers
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
    public function Cliente()
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


            $data['page_title'] = "Dashboard | Clientes";
            $data['page_name'] = "Clientes";
            $data['description'] = "";
            $data['breadcrumb-item'] = "Usuarios";
            $data['breadcrumb-activo'] = "Usuario";
            $data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];
            $data['page_functions_js'] = "functions_clientes.js";

            #Data modal
            $data['page_title_modal'] = "Nuevo cliente";
            $data['page_title_bold'] = "Estimado usuario";
            $data['descrption_modal1'] = "Los campos remarcados con";
            $data['descrption_modal2'] = "son necesarios.";


            #Cargo la vista(tipos). La vista esta en View - Tipos
            $this->views->getView($this, "clientes", $data);
        } else {
            //echo "NO TIENES PERMISOS PARA ACCEDER A ESTA PAGINA";

            // El usuario no tiene permisos, redirige a su vista_inicio
            //$vistaInicio = Access::obtenerVistaInicio($userType);
            //dep($vistaInicio);

            header("Location:http://localhost/jip/app");
            exit();
        }
    }

    ### CONTROLADOR: MOSTRAR TODOS LOS CLIENTES ###
    public function getClientes()
    {

        $arrData = $this->model->selectClientes();

        for ($i = 0; $i < count($arrData); $i++) {

            #Localidad
            /* if ($arrData[$i]['es_local'] == 1) {
                $arrData[$i]['es_local'] = '<img id="header-lang-img" src="https://jip.grupopaniagua.com/assets/images/flags/nic.svg" alt="Header Language" height="20" class="rounded"><span> Nacional</span>';
            } else {
                $arrData[$i]['es_local'] = '<img id="header-lang-img" src="https://jip.grupopaniagua.com/assets/images/flags/int.svg" alt="Header Language" height="20" class="rounded"><span> Internacional</span>';
            }*/

            #Impuesto
            if ($arrData[$i]['exento_impuesto'] == 1) {
                $arrData[$i]['exento_impuesto'] = '<span class="badge rounded-pill bg-success">Si</span>';
            } else {
                $arrData[$i]['exento_impuesto'] = '<span class="badge rounded-pill bg-danger">No</span>';
            }

            if ($arrData[$i]['activo'] == 1) {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-success">Activo</span>';
            } else {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
            }

            #Botones de accion
            $arrData[$i]['options'] = '<div class="text-center">
                	<!--<button type="button" class="btn btn-warning btn-sm " onClick="fntEditCliente(' . $arrData[$i]['cod_cliente'] . ')" title="Mas información"><i class="ri-edit-2-line"></i></button>-->
				<button type="button" class="btn btn-warning btn-sm " onClick="fntEditCliente(' . $arrData[$i]['cod_cliente'] . ')" title="Editar"><i class="ri-edit-2-line"></i></button>
				<button type="button" class="btn btn-danger btn-sm" onClick="fntDelCliente(' . $arrData[$i]['cod_cliente'] . ')" title="Eliminar"><i class="ri-delete-bin-5-line"></i></button>
				</div>';
        }

        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ### CONTROLADOR: GUARDAR NUEVO CLIENTE### 
    public function setCliente()
    {

        /*var_dump($_POST);
        exit();*/

        if ($_POST) {

            $intidClientes    = intval($_POST['idClientes']);

            $nombre           = strClean($_POST['nombre']);
            $ruc              = strClean($_POST['ruc']);
            $pais             = $_POST['comboxPais'];
            $personaContacto  = strClean($_POST['personaContacto']);
            $pago             = strClean($_POST['comboxPago']);
            $impuesto         = strClean($_POST['statusImpuesto']);
            $estado           = strClean($_POST['lStatus']);
            $movil            = strClean($_POST['movil']);
            $telefono         = strClean($_POST['telefono']);
            $extension        = strClean($_POST['extension']);
            $correo           = strClean($_POST['correo']);
            $direccion        = strClean($_POST['direccion']);

            if ($intidClientes  == 0) {

                #Creo un nuevo cliente
                $request_Contacto = $this->model->insertCliente(
                    $nombre,
                    $ruc,
                    $pais,
                    $personaContacto,
                    $pago,
                    $impuesto,
                    $estado,
                    $movil,
                    $telefono,
                    $extension,
                    $correo,
                    $direccion
                );
            }
        }






        #Capturo los datos
        // $intIdContacto = intval($_POST['idContacto']);


        #Si no viene ningun ID - Estoy creando 1 nuevo
        //if ($intIdContacto == 0) {

        #Crear
        //$request_Contacto = $this->model->insertCliente($ComboxContact, $Descripcion, $Extension);


        /*var_dump($request_Contacto);
        exit();*/

        $option = 1;

        #Verificar
        if ($request_Contacto > 0) {
            if ($option == 1) {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
            }
        } else if ($request_Contacto === 'existe') {
            $arrResponse = array('status' => false, 'msg' => '¡Atención! El tipo de usuario ya existe.');
        } else {
            $arrResponse = array('status' => true, 'msg' => 'No es posible almacenar los datos');
        }

        #Convierto .json
        //echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

        $responseJSON = json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

        # Devuelvo la respuesta
        header('Content-Type: application/json');
        echo $responseJSON;
    }

    ###################################
    ### CONTROLADOR: ELIMINAR BANCO ###
    ###################################

    public function delCliente()
    {

        if ($_POST) {

            $intIdCliente = intval($_POST['cod_cliente']);

            $requestDelete = $this->model->deleteCliente($intIdCliente);

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

}
