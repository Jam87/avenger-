<?php
require_once 'Access.php';
class Dashboard extends Controllers
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
	public function dashboard()
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

			$data['page_id'] = 2;
			$data['page_tag'] = "";
			$data['page_title'] = "Dashboard - jipsafety";
			$data['page_name'] = "Dashboard";
			$data['data-sidebar-size'] = $_SESSION['usuario'][0]['colapsar'];
			#lg

			#Cargo la vista(dashboard). A traves del metodo(getView)
			$this->views->getView($this, "dashboard", $data);
		} else {
			//echo "NO TIENES PERMISOS PARA ACCEDER A ESTA PAGINA";

			// El usuario no tiene permisos, redirige a su vista_inicio
			//$vistaInicio = Access::obtenerVistaInicio($userType);
			//dep($vistaInicio);

			header("Location:http://localhost/jip/app");
			exit();
		}
	}
}
