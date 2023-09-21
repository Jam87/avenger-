<?php
### CLASE: TallasModel ###
class KardexModel extends Mysql
{
    private $codigo_producto;
    private $cod_color;
    private $cod_presentacion;
    private $cod_talla;
    private $cod_bodega;
    private $consecutivo;
    private $cod_movimiento;
    private $existencia_anterior;
    private $movimiento;
    private $existencia_nuevas;
    private $fecha_documento;
    private $ultimo_movimiento;
    private $registra_fecha;
    private $anula_fecha;
    private $activa;




    public function __construct()
    {
        parent::__construct();
    }



    ########################################
    ### COMBOX: MOSTRAR TODAS LAS TALLAS ###
    ########################################

    public function selectTallas()
    {
        $sql = "SELECT * FROM store_tallas";

        $request = $this->select_all($sql);
        return $request;
    }

    ##############################
    ### COMBOX: MOSTRAR BODEGA ###
    ##############################

    public function selectBodegas()
    {
        $sql = "SELECT * FROM stock_bodega";

        $request = $this->select_all($sql);
        return $request;
    }


    ###########################
    ### OBTENER CONSECUTIVO ###
    ###########################

    public function obtenerConsecutivo()
    {
        $sql = "SELECT MAX(consecutivo) as ultimo_consecutivo FROM store_kardex_productos";
        $request = $this->select($sql);
        //var_dump($request);
        return $request;
    }

    ########################################
    ### MODELO: MOSTRAR TODOS LOS BAN ###
    #########################################

    public function selectProveedores()
    {
        #Sentencia
        /* $sql = "SELECT p.cod_proveedor, p.nombre_proveedor, p.nombre_impreso, p.numero_ruc, p.persona_contacto, p.activo, f.descripcion
                FROM  pruchase_proveedor p
                INNER JOIN cat_forma_pago f
                ON  p.cod_forma_pago = f.cod_forma_pago 
                WHERE p.activo != 0";*/

        $sql = "SELECT b.cod_proveedor, c.nombre_banco, b.consecutivo, m.nombre_moneda, b.numero_cuenta, b.codigo_swift
                FROM  pruchase_proveedor_bancos b
                INNER JOIN cat_bancos c
                ON  b.cod_bancos  = c.cod_bancos
                INNER JOIN cat_moneda m
                ON  b.cod_moneda  = m.cod_moneda
             
              ";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }


    ##########################################
    ### MODELO: GUARDAR UN NUEVO PROVEEDOR ###
    ##########################################

    public function insertProveedor(
        string $nombre_proveedor,
        string $nombre_impreso,
        string $numero_ruc,
        int $cod_pais,
        string $persona_contacto,
        int $cod_forma_pago,
        int $activo
    ) {
        $return = "";
        $this->nombre_proveedor = $nombre_proveedor;
        $this->nombre_impreso   = $nombre_impreso;
        $this->numero_ruc       = $numero_ruc;
        $this->cod_pais         = $cod_pais;
        $this->persona_contacto = $persona_contacto;
        $this->cod_forma_pago   = $cod_forma_pago;
        $this->activo           = $activo;

        #Sentencia
        $sql = "SELECT * FROM pruchase_proveedor WHERE nombre_proveedor = '{$this->nombre_proveedor}' ";

        /*echo $sql;
        exit();*/

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);

        /*var_dump($request);
          exit();*/

        if (empty($request)) {

            $sql = "INSERT INTO pruchase_proveedor (nombre_proveedor, nombre_impreso, numero_ruc, cod_pais,
            persona_contacto, cod_forma_pago, activo) VALUE (?,?,?,?,?,?,?)";

            #arrData: array de información
            $arrData = array(
                $this->nombre_proveedor, $this->nombre_impreso,  $this->numero_ruc, $this->cod_pais,
                $this->persona_contacto, $this->cod_forma_pago,  $this->activo
            );


            #Envio a la funcion insert(sentencia y data)
            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
        return $return;
    }


    ##########################################
    ### MODELO: GUARDAR UN BANCO PROVEEDOR ###
    ##########################################

    public function insertBancoProveedor(int $Banco, int $consecutivo, int $moneda, string $nCuenta, string $swift)
    {
        $return = "";
        $this->cod_bancos    = $Banco;
        $this->consecutivo   = $consecutivo;
        $this->cod_moneda    = $moneda;
        $this->numero_cuenta = $nCuenta;
        $this->codigo_swift  = $swift;

        #Sentencia
        //$sql = "SELECT * FROM pruchase_proveedor_bancos WHERE numero_cuenta = '{$this->numero_cuenta}";

        #Mando a llamar la función(select_all)
        //$request = $this->select_all($sql);

        /*var_dump($request);
        exit();*/

        // if (empty($request)) {

        $sql = "INSERT INTO pruchase_proveedor_bancos (cod_bancos, consecutivo, cod_moneda, numero_cuenta, codigo_swift) VALUE (?,?,?,?,?)";

        #arrData: array de información
        $arrData = array($this->cod_bancos, $this->consecutivo, $this->cod_moneda, $this->numero_cuenta, $this->codigo_swift);
        /*var_dump($arrData);
        exit();*/

        #Envio a la funcion insert(sentencia y data)
        $requestInsert = $this->insert($sql, $arrData);

        return $requestInsert;
        /*} else {
            $return = "existe";
        }*/
        return $return;
    }

    #############################################
    ### MODELO: GUARDAR UN CONTACTO PROVEEDOR ###
    #############################################

    public function insertContactoProveedor(int $movil, int $telefono, string $correo, int $extension, string $direccion)
    {
        $return = "";
        $this->movil     = $movil;
        $this->$telefono = $telefono;
        $this->correo    = $correo;
        $this->extension = $extension;
        $this->direccion = $direccion;

        #Sentencia
        //$sql = "SELECT * FROM pruchase_proveedor_bancos WHERE numero_cuenta = '{$this->numero_cuenta}";

        #Mando a llamar la función(select_all)
        //$request = $this->select_all($sql);

        /*var_dump($request);
        exit();*/

        if (empty($request)) {

            $sql = "INSERT INTO pruchase_proveedor_contacto (movil, telefono, extension, correo, direccion) VALUE (?,?,?,?,?)";

            #arrData: array de información
            $arrData = array($this->movil, $this->$telefono, $this->correo, $this->extension, $this->direccion);
            /*var_dump($arrData);
            exit();*/

            #Envio a la funcion insert(sentencia y data)
            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
        return $return;
    }



    ### MODELO: ELIMINAR BANCO PROVEEDOR ###
    /*public function deleteBancoProv(int $intIdBanco)
    {

        #id
        $this->cod_proveedor = $intIdBanco;

        $sql = "UPDATE pruchase_proveedor_bancos SET activo = ? WHERE cod_bancos =  '{$this->cod_bancos}'";

        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }*/
}
