<?php
### CLASE CONTACTO  ###
class Contacto extends Controllers
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
    public function Contacto()
    {
        $data['page_title'] = "Dashboard | Contacto";
        $data['page_name'] = "Contacto";
        $data['description'] = "";
        $data['breadcrumb-item'] = "Usuarios";
        $data['breadcrumb-activo'] = "Usuario";
        $data['page_functions_js'] = "functions_contacto.js";

        #Data modal
        $data['page_title_modal'] = "Nuevo contacto";
        $data['page_title_bold'] = "Estimado usuario";
        $data['descrption_modal1'] = "Los campos remarcados con";
        $data['descrption_modal2'] = "son necesarios.";
        $data['data-sidebar-size'] = 'sm';

        #Cargo la vista(tipos). La vista esta en View - Contacto
        $this->views->getView($this, "contacto", $data);
    }

    function mostrarContactos()
    {
        #Modelo comboxPais
        $arrData = $this->model->comboxContacto();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }


    ### CONTROLADOR: MOSTRAR TODOS CONTACTO ###
    public function getContacto()
    {
        #Cargo el modelo(selectContacto) 
        $arrData = $this->model->selectContacto();

        for ($i = 0; $i < count($arrData); $i++) {

            #Estado
            if ($arrData[$i]['activo'] == 1) {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-success">Activo</span>';
            } else {
                $arrData[$i]['activo'] = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
            }

            #Telefono
            if ($arrData[$i]['es_telefono'] == 1) {
                $arrData[$i]['es_telefono'] = 'Si';
            } else {
                $arrData[$i]['es_telefono'] = 'No';
            }

            #Correo
            if ($arrData[$i]['es_correo'] == 1) {
                $arrData[$i]['es_correo'] = 'Si';
            } else {
                $arrData[$i]['es_correo'] = 'No';
            }

            #Url
            if ($arrData[$i]['es_url'] == 1) {
                $arrData[$i]['es_url'] = 'Si';
            } else {
                $arrData[$i]['es_url'] = 'No';
            }

            #Botones de accion
            $arrData[$i]['options'] = '<div class="text-center">
				<button type="button" class="btn btn-warning btn-sm btnEditContacto" onClick="fntEditCont(' . $arrData[$i]['cod_contacto'] . ')" title="Editar"><i class="ri-edit-2-line"></i></button>
				<button type="button" class="btn btn-danger btn-sm btnDelContacto" onClick="fntDelCont(' . $arrData[$i]['cod_contacto'] . ')" title="Eliminar"><i class="ri-delete-bin-5-line"></i></button>
				</div>';
        }


        #JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        exit();
    }

    ### CONTROLADOR: GUARDAR NUEVO CONTACTO ###
    public function setContacto()
    {

        if ($_POST) {

            /*dep($_POST);
            exit();*/

            #Capturo los datos       
            $idContacto   = intval($_POST['idContacto']);
            $descripcion  = strClean($_POST['descripcion']);
            $telefono     = isset($_POST['cbxTel']) ? 1 : 0;
            $correo       = isset($_POST['cbxCorreo']) ? 1 : 0;
            $url          = isset($_POST['cbxUrl']) ? 1 : 0;
            $status       = intval($_POST['listStatus']);

            #Si no viene ningun ID - Estoy creando 1 nuevo
            if ($idContacto == 0) {

                #Crear
                $request_Contacto = $this->model->insertContacto($descripcion, $telefono, $correo, $url, $status);

                /*dep($request_Tipo);
                  exit();*/

                $option = 1;
            } /*else {
                #Actualizar
                $request_Banco = $this->model->updateBanco($intIdContacto, $name, $nota, $listLocal, $status);
                $option = 2;
            }*/

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
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    ### CONTROLADOR: ELIMINAR CONTACTO ###
    public function delContacto()
    {
        if ($_POST) {

            $intIdContacto = intval($_POST['cod_contacto']);

            $requestDelete = $this->model->deleteContacto($intIdContacto);

            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la forma de pago');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la forma de pago.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

            die();
        }
    }

    ### CONTROLADOR: EDITAR CONTACTO ###    
    public function EditContact(int $idContacto)
    {

        #id
        $intIdContacto = intval($idContacto);

        if ($intIdContacto  > 0) {
            $arrData = $this->model->editContacto($intIdContacto);
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
