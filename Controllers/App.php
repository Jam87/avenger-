<?php
#Inicio sesion
class App extends Controllers
{
	public function __construct()
	{
		session_start(); #Crear sesión
		#Verificar si existe sesión
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
		}
		parent::__construct();
	}

	### CONTROLADOR ###
	public function app()
	{
		$data['page_id'] = 2;
		$data['page_tag'] = "";
		//$data['page_title'] = "Prueba";
		//$data['page_name'] = "Dashboard";
		$data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];
		#lg

		$usuarioObj = json_decode(json_encode($_SESSION['usuario'][0]), false);
		if ($usuarioObj->nombre_modulo && $usuarioObj->vista) {
			$data['page_title'] = $usuarioObj->nombre_modulo;
			$data['page_name'] = $usuarioObj->nombre_modulo;
			$data['page_functions_js'] = "functions_$usuarioObj->vista.js";
		}

		#Cargo la vista(dashboard). A traves del metodo(getView)
		$this->views->getView($this, "app", $data);
	}
}
