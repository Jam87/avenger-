<?php
### CLASE MENU  ###

class Menu extends Controllers
{

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {

            session_start(); #Inicio sesion
        }
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        parent::__construct();
    }
}
