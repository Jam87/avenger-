<?php

class BodegasModel extends Mysql
{
    private $cod_bodega;
    private $nombre_bodega;
    private $sigla;
    private $descripcion;
    private $date_registro;
    private $activo;

    public function __construct()
    {
        parent::__construct();
    }

    #########################################
    ### MODELO: MOSTRAR TODOS LAS BODEGAS ###
    #########################################

    public function selectBodegas()
    {
        #Sentencia
        $sql = "SELECT * FROM  stock_bodega WHERE activo != 0";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    #######################################
    ### MODELO: GUARDAR UN NUEVA BODEGA ###
    #######################################

    public function insertBodega(string $bodega, string $sigla, string $descripcion, int $status)
    {
        $return = "";

        $this->nombre_bodega = $bodega;
        $this->sigla = $sigla;
        $this->descripcion = $descripcion;
        $this->date_registro = gmdate('Y-m-d H');
        $this->activo       = $status;

        #Sentencia

        $sql = "SELECT * FROM stock_bodega WHERE nombre_bodega = '{$this->nombre_bodega}' OR sigla = '{$this->sigla}'";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);


        if (empty($request)) {

            $sql = "INSERT INTO stock_bodega(nombre_bodega, sigla, descripcion, date_registro, activo) VALUE (?,?,?,?,?)";

            #arrData: array de información
            $arrData = array($this->nombre_bodega, $this->sigla, $this->descripcion, $this->date_registro, $this->activo);

            #Envio a la funcion insert(sentencia y data)
            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
        return $return;
    }


    ### MODELO: ELIMINAR BODEGA ###
    public function deleteBodega(int $intIdBodega)
    {

        #id
        $this->cod_bodega = $intIdBodega;

        $sql = "UPDATE stock_bodega SET activo = ? WHERE cod_bodega =  $this->cod_bodega";

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
