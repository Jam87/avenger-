<?php
require_once 'Access.php';
class Proveedores extends Controllers
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
    public function Proveedores()
    {

        $data['page_title'] = "Dashboard | Proveedores";
        $data['page_name'] = "Proveedores";
        $data['description'] = "";
        $data['breadcrumb-item'] = "Usuarios";
        $data['breadcrumb-activo'] = "Usuario";
        $data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];
        $data['page_functions_js'] = "functions_proveedores.js";

        #Data modal
        $data['page_title_modal'] = "Nuevo banco";
        $data['page_title_bold'] = "Estimado usuario";
        $data['descrption_modal1'] = "Los campos remarcados con";
        $data['descrption_modal2'] = "son necesarios.";

        #Cargo la vista(tipos). La vista esta en View - Tipos
        $this->views->getView($this, "proveedores", $data);
    }


    #############################################
    ### CONTROLADOR: MOSTRAR TODOS LOS BANCOS ###
    #############################################
    public function getProveedores()
    {
        #Cargo el modelo(selectBancos) 
        $arrData = $this->model->selectProveedores();

        for ($i = 0; $i < count($arrData); $i++) {

            #Estado
            /* if ($arrData[$i]['activo'] == 1) {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-success">Activo</span>';
            } else {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
            }*/

            #Botones de accion
            $arrData[$i]['options'] = '<div class="text-center">		
				<button type="button" class="btn btn-danger btn-sm btnDelBanco" onClick="fntDelBancoProv(' . $arrData[$i]['cod_proveedor'] . ')" title="Eliminar"><i class="ri-delete-bin-5-line"></i></button>
				</div>';
        }


        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
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

    ### CONTROLADOR: GUARDAR NUEVO PROVEEDOR ###
    public function setProveedor()
    {

        if ($_POST) {

            #Capturo los datos
            $intIdProveedor = intval($_POST['idProveedor']);

            $nombre_proveedor  = strClean($_POST['nombre']);
            $nombre_impreso    = strClean($_POST['nprint']);
            $numero_ruc        = strClean($_POST['ruc']);
            $cod_pais          = intval($_POST['comboxpais']);
            $persona_contacto  = strClean($_POST['ncontacto']);
            $cod_forma_pago    = intval($_POST['comboxpago']);
            $activo            = intval($_POST['lStatus']);

            //DATA BANCO 
            /*$consecut          = strClean($_POST['consecutivo']);
            $ncuenta           = strClean($_POST['ncuenta']);
            $swift             = strClean($_POST['swift']);*/



            #Si no viene ningun ID - Estoy creando 1 nuevo
            if ($intIdProveedor == 0) {

                #Crear
                $request_Proveedor = $this->model->insertProveedor(
                    $nombre_proveedor,
                    $nombre_impreso,
                    $numero_ruc,
                    $cod_pais,
                    $persona_contacto,
                    $cod_forma_pago,
                    $activo
                );

                /*$request_Banco = $this->model->insertBanco(
                    $consecut,
                    $ncuenta,
                    $swift
                );*/


                /*dep($request_Proveedor);
                exit();*/


                $option = 1;
            } else {
                #Actualizar
                //$request_Proveedor = $this->model->updateBanco($intIdBanco, $name, $nota, $listLocal, $status);
                $option = 2;
            }

            #Verificar
            if ($request_Proveedor > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
            } else if ($request_Proveedor  === 'existe') {
                $arrResponse = array('status' => false, 'msg' => '¡Atención! El proveedor ya existe.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'No es posible almacenar los datos');
            }

            #Convierto .json
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    ############################################
    ### CONTROLADOR: GUARDAR NUEVO PROVEEDOR ###
    ############################################

    public function setBanco()
    {

        /*dep($_POST);
        exit();*/

        if ($_POST) {
            $idBanco     = intval($_POST['idBanco']);
            $consecutivo = intval($_POST['consecutivo']);
            $Banco       = intval($_POST['banco']);
            $moneda      = intval($_POST['moneda']);
            $nCuenta     = strClean($_POST['nCuenta']);
            $swift       = strClean($_POST['swift']);

            if ($idBanco == 0) {

                #Crear
                $request_Banco = $this->model->insertBancoProveedor($Banco, $consecutivo, $moneda, $nCuenta, $swift);

                /*dep($request_Banco);
                exit();*/

                $option = 1;
            } else {
                #Actualizar
                /*$request_Banco = $this->model->updateBanco($intIdBanco, $name, $nota, $listLocal, $status);
                $option = 2;*/
            }

            #Verificar
            if ($request_Banco > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
            } else if ($request_Banco === 'existe') {
                $arrResponse = array('status' => false, 'msg' => '¡Atención! El banco ya existe.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'No es posible almacenar los datos');
            }

            #Convierto .json
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }


    ############################################
    ### CONTROLADOR: GUARDAR NUEVO CONTACTO ###
    ############################################

    public function setContacto()
    {

        /*dep($_POST);
        exit();*/

        if ($_POST) {
            $idContactoProv  = intval($_POST['idContacto']);

            $movil           = intval($_POST['movil']);
            $telefono        = intval($_POST['telefono']);
            $extension       = intval($_POST['extension']);
            $correo          = intval($_POST['correo']);
            $direccion       = strClean($_POST['direccion']);


            if ($idContactoProv == 0) {

                #Crear
                $request_BancoProv = $this->model->insertContactoProveedor($movil, $telefono, $extension, $correo, $direccion);

                /*dep($request_BancoProv);
                exit();*/

                $option = 1;
            } else {
                #Actualizar
                $request_BancoProv = $this->model->updateBanco($intIdBanco, $name, $nota, $listLocal, $status);
                $option = 2;
            }

            #Verificar
            if ($request_BancoProv > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
            } else if ($request_BancoProv === 'existe') {
                $arrResponse = array('status' => false, 'msg' => '¡Atención! El tipo de usuario ya existe.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'No es posible almacenar los datos');
            }

            #Convierto .json
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }




    ### CONTROLADOR: ELIMINAR BANCO DEL PROVEEDOR###
    public function delBancoProv()
    {
        /*dep($intIdproveedor);
        exit();*/

        if ($_POST) {

            $intIdproveedor = intval($_POST['cod_proveedor']);

            $requestDelete = $this->model->deleteBancoProv($intIdproveedor);

            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el registro');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el registro.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

            die();
        }
    }
}
