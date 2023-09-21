<?php
### CLASE MODULOS  ###
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
        $data['page_title'] = "Dashboard | Modulos";
        $data['page_name'] = "Modulos";
        $data['description'] = "";
        $data['breadcrumb-item'] = "Usuarios";
        $data['breadcrumb-activo'] = "Usuario";
        $data['data-sidebar-size'] = "lg";
        $data['page_functions_js'] = "functions_modulos.js";

        #Data modal
        $data['page_title_modal'] = "Nuevo banco";
        $data['page_title_bold'] = "Estimado usuario";
        $data['descrption_modal1'] = "Los campos remarcados con";
        $data['descrption_modal2'] = "son necesarios.";


        #Cargo la vista(tipos). La vista esta en View - Tipos
        $this->views->getView($this, "modulos", $data);
    }

    ### CONTROLADOR: MOSTRAR TODOS LOS BANCOS ###
    function mostrarBanco()
    {
        #Modelo comboxBanco
        $arrData = $this->model->comboxBanco();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
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
				<button type="button" class="btn btn-warning btn-sm btnEditModulo" onClick="fntEditModulo(' . $arrData[$i]['cod_modulo'] . ')" title="Editar"><i class="ri-edit-2-line"></i></button>
				<button type="button" class="btn btn-danger btn-sm btnDelModulo" onClick="fntDelModulo(' . $arrData[$i]['cod_modulo'] . ')" title="Eliminar"><i class="ri-delete-bin-5-line"></i></button>
				</div>';
        }


        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ### CONTROLADOR: GUARDAR NUEVO MODULO###
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

                /* dep($request_Tipo);
                  exit();*/

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

    ### CONTROLADOR: MOSTRAR TODOS LOS MODULOS ###

    public function mostrarJstree()
    {
        $requestData = $this->model->mostrarJstree();


        if ($requestData) {
            $arrResponse = array('status' => true, 'msg' => 'exitoso');
        } else {
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el nombre del banco.');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
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
