<?php
### CLASE: BancosModel ###
class BancoModel extends Mysql
{
    private $cod_bancos;
    private $nombre_banco;
    private $nota_banco;
    private $es_local;
    private $date_registro;
    private $activo;

    public function __construct()
    {
        parent::__construct();
    }

    ### COMBOX: MOSTRAR TODOS LOS BANCOS ###
    public function comboxBanco()
    {
        $sql = "SELECT cod_bancos, nombre_banco FROM cat_bancos";

        $request = $this->select_all($sql);
        return $request;
    }


    ### MODELO: MOSTRAR TODOS LOS BANCOS ###
    public function selectBancos()
    {
        #Sentencia
        $sql = "SELECT * FROM  cat_bancos WHERE activo != 0";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: GUARDAR UN NUEVO BANCO ###
    public function insertBanco(string $name, string $nota, int $listLocal, int $status)
    {
        $return = "";
        $this->nombre_banco = $name;
        $this->nota_banco   = $nota;
        $this->es_local     = $listLocal;
        $this->date_registro = date("yyyy-mm-dd");
        $this->activo       = $status;

        #Sentencia
        $sql = "SELECT * FROM cat_bancos WHERE nombre_banco = '{$this->nombre_banco}' ";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);

        /*var_dump($request);
          exit();*/

        if (empty($request)) {

            $sql = "INSERT INTO cat_bancos(nombre_banco, nota_banco, es_local, date_registro, activo) VALUE (?,?,?,?,?)";

            #arrData: array de información
            $arrData = array($this->nombre_banco, $this->nota_banco, $this->es_local, $this->date_registro, $this->activo);

            #Envio a la funcion insert(sentencia y data)
            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
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
