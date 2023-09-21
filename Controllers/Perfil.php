<?php
class Perfil extends Controllers
{

    public function __construct()
    {
        session_start();

        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        parent::__construct();
    }

    public function RegistrarPerfilModulo()
    {


        if ($_POST) {

            $idModuloSeleccionado = $_POST['idModuloSeleccionado'];
            $idPerfil = $_POST['idPerfil'];
            $modulo_inicio = $_POST['modulo_inicio'];

            $requestModuloPerfil = $this->model->ObtenerModuloPorPerfil($idModuloSeleccionado, $idPerfil, $modulo_inicio);
            echo json_encode($requestModuloPerfil, JSON_UNESCAPED_UNICODE);
        }
    }
}
