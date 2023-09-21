<?php

class UsosModel extends Mysql
{
    private $cod_usos;
    private $description;
    private $descripcion;
    private $date_registro;
    private $activo;

    public function __construct()
    {
        parent::__construct();
    }

    ### MODELO: MOSTRAR TODOS LOS USOS ###
    public function selectUsos()
    {
        $sql = "SELECT * FROM store_usos";

        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: GUARDAR UN NUEVO USO ###
    public function insertUso(string $descripcion, int $status)
    {
        $return = "";

        $this->descripcion = $descripcion;
        $this->date_registro = gmdate('Y-m-d H');
        $this->activo       = $status;

        #Sentencia
        $sql = "SELECT * FROM store_usos WHERE descripcion = '{$this->descripcion}' ";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);

        /*var_dump($request);
          exit();*/

        if (empty($request)) {

            $sql = "INSERT INTO store_usos(descripcion, date_registro, activo) VALUE (?,?,?)";

            #arrData: array de información
            $arrData = array($this->descripcion, $this->date_registro, $this->activo);

            #Envio a la funcion insert(sentencia y data)
            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
        return $return;
    }


    ### MODELO: ELIMINAR USO ###
    public function deleteUso(int $intIdUso)
    {

        #id
        $this->cod_usos = $intIdUso;

        $sql = "UPDATE store_usos SET activo = ? WHERE cod_usos =  $this->cod_usos";

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
