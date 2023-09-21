<?php

class AuditoriaModel extends Mysql
{
    private $cod_sesion;
    private $cod_usuario;
    private $Fecha_Inicio_Sesion;
    private $Fecha_Fin_Sesion;
    private $IPConexion;
    private $Navegador;
    private $cod_bodega;


    public function __construct()
    {
        parent::__construct();
    }

    #########################################
    ### MODELO: MOSTRAR TODOS LAS BODEGAS ###
    #########################################

    public function selectAuditoria()
    {
        #Sentencia
        $sql = "SELECT * FROM  secure_control_sesion";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }
}
