<?php
### CLASE: BancosModel ###
class ProveedoresModel extends Mysql
{
    private $cod_proveedor;
    private $nombre_proveedor;
    private $nombre_impreso;
    private $numero_ruc;
    private $cod_pais;
    private $persona_contacto;
    private $cod_forma_pago;
    private $date_registro;
    private $activo;

    //////
    private $consecutivo;
    private $numero_cuenta;
    private $codigo_swift;


    public function __construct()
    {
        parent::__construct();
    }

    ### MODELO: MOSTRAR TODOS LOS COLORES ###
    public function selectColor()
    {
        #Sentencia
        $sql = "SELECT * FROM  pruchase_proveedor WHERE activo != 0";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: GUARDAR UN NUEVO PROVEEDOR ###
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

            //$sql = "SELECT IFNULL(MAX(tabla), 0) + 1 INTO tabla FROM tabla";

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

    ////////
    ### MODELO: GUARDAR UN BANCO PROVEEDOR ###
    public function insertBanco(string $consecut, string $ncuenta, string $swift)
    {
        $return = "";
        $this->consecutivo = $consecut;
        $this->numero_cuenta = $ncuenta;
        $this->codigo_swift = $swift;
        #Sentencia
        //$sql = "SELECT * FROM pruchase_proveedor_bancos WHERE nombre_proveedor = '{$this->nombre_proveedor}' ";

        #Mando a llamar la función(select_all)
        // $request = $this->select_all($sql);

        /*var_dump($request);
           exit();*/

        //if (empty($request)) {

        $sql = "INSERT INTO pruchase_proveedor_bancos (consecutivo, numero_cuenta, codigo_swift) VALUE (?,?,?)";

        #arrData: array de información
        $arrData = array($this->consecutivo, $this->numero_cuenta, $this->codigo_swift);
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


    ### MODELO: ELIMINAR BANCO ###
    public function deleteBanco(int $intIdBanco)
    {

        #id
        $this->cod_bancos = $intIdBanco;

        $sql = "UPDATE cat_bancos SET activo = ? WHERE cod_bancos =  '{$this->cod_bancos}'";

        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }


    ### MODELO: EDITAR BANCO ###
    public function editBanco(int $idBanco)
    {

        //Buscar Tipo de Usuario
        $this->cod_bancos = $idBanco;
        $sql = "SELECT * FROM cat_bancos WHERE cod_bancos = '{$this->cod_bancos}'";
        $request = $this->select($sql);
        return $request;
    }


    ### MODELO: ACTUALIZAR BANCO ###
    public function updateBanco(int $intIdBanco, string $name, string $nota, $listLocal, int $status)
    {

        $this->cod_bancos   = $intIdBanco;
        $this->nombre_banco = $name;
        $this->nota_banco   = $nota;
        $this->es_local     = $listLocal;
        $this->date_registro = date("F j, Y, g:i a");
        $this->activo       = $status;


        $sql = "SELECT * FROM cat_bancos WHERE nombre_banco = '$this->nombre_banco' AND cod_bancos != $this->cod_bancos";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE cat_bancos SET nombre_banco = ?, nota_banco = ?, es_local = ?, date_registro = ?, activo = ? WHERE cod_bancos  = $this->cod_bancos";
            $arrData = array($this->nombre_banco, $this->nota_banco, $this->es_local, $this->date_registro, $this->activo);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }
}
