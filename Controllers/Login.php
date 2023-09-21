<?php
### CLASE LOGIN ###
class Login extends Controllers
{
	public function __construct()
	{
		session_start(); #Inicio sesion
		if (isset($_SESSION['login'])) {
			header('Location: ' . base_url() . 'dashboard');
		}
		parent::__construct();
	}

	### CONTROLADOR:LOGIN ###
	public function Login()
	{
		#Data extra 
		$data['page_id'] = 1;
		$data['page_tag'] = "Login";
		$data['page_title'] = "Productos de seguridad";
		$data['page_empresa'] = "JIPSAFETY";
		$data['page_name'] = "login";
		$data['page_functions_js'] = "functions_login.js"; #Carga en MainJs functions_login 
		$data['page_content'] = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, quis.";
		#Cargo la vista(login). A traves del metodo(getView)
		$this->views->getView($this, "login", $data);
	}

	### CONTROLADOR: loginUser Y SESIONES ###
	public function loginUser()
	{
		/*dep($_POST);
		die();*/

		if ($_POST) {
			if (empty($_POST['useremail']) || empty($_POST['userpassword'])) {
				$arrResponse = array('status' => false, 'msg' => 'Error de datos');
			} else {
				$correo = strtolower(strClean($_POST['useremail']));
				$password = hash("SHA256", $_POST['userpassword']);


				#Mando a llamar al modelo(loginUser)
				$requestUser = $this->model->loginUser($correo, $password);

				if (empty($requestUser)) {
					$arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.');
				} else {
					$arrData = $requestUser; #arrData: Guarda los datos del usuario


					if ($arrData['activo'] == 1) {
						#Variables sesion
						$_SESSION['idUser'] = $arrData['cod_usuario'];
						$_SESSION['login'] = true;

						//Registro de auditoria de inicio de sesion
						//$_cod_sesion = session_id(); //Obtener el ID de sesion actual

						/*$cod_usuario = $arrData['cod_usuario'];
						$Fecha_inicio = date('Y-m-d H:i:s');
						$Ip_conexion = $_SERVER['REMOTE_ADD'];
						$Navegador = $_SERVER['HTTP_USER_AGENT'];*/

						//$cod_sesion = $this->model->insertSesion($cod_usuario, $Fecha_inicio, $Ip_conexion, $Navegador);


						## GET USER DATA ##
						/*
						  Al hacer (object) antes de $this->model->dataUser($_SESSION['idUser']), estarás forzando la conversión de los datos a un objeto
						*/
						$arrData = $this->model->dataUser($_SESSION['idUser']);

						$_SESSION['usuario'] = $arrData;


						### USER MENU ###
						# Son los modulos que tiene acceso el usuario de acuerdo al perfil
						$arrData = $this->model->menuUser($_SESSION['idUser']);

						$_SESSION['menu'] = $arrData;

						$menuUser = json_decode(json_encode($_SESSION['menu'][0]), false);

						$_SESSION['menu_actual'] = $menuUser;
						/*dep($menuUser);
						exit();*/

						## SUB MENU USER ##
						$arrData = $this->model->subMenu($_SESSION['menu_actual']->id, $_SESSION['idUser']);

						$_SESSION['submenu'] = $arrData;

						$submenuUser = json_decode(json_encode($_SESSION['submenu']), false);

						$_SESSION['submenu_actual'] = $submenuUser;

						$arrResponse = array('status' => true, 'msg' => 'ok');
					} else {
						$arrResponse = array('status' => 'Usuario inactivo');
					}
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
}
