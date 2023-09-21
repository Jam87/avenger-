<?php 
### CIERRA SESION ###
	class Logout{

		public function __construct()
		{
			session_start();
            session_unset();
            session_destroy();
            header('location: '.base_url()); #Reedirijo a ruta raiz
            exit();
			
		}
	}
 ?>