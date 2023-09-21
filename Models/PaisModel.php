<?php
### CLASE: PaisModel ###
class PaisModel extends Mysql
{
    private $cod_pais;
    private $descripcion;
    private $es_local;
    private $date_registro;
    private $activo;


    public function __construct()
    {
        parent::__construct();
    }

    ### COMBOX: MOSTRAR TODOS LOS PAISES ###
    public function comboxPais()
    {
        $sql = "SELECT cod_pais,descripcion FROM cat_pais";

        $request = $this->select_all($sql);
        return $request;
    }


    ### MODELO: MOSTRAR TODOS LOS PAISES ###
    public function selectPais()
    {
        #Sentencia
        $sql = "SELECT * FROM  cat_pais WHERE activo != 0";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: GUARDAR UN NUEVO PAIS ###
    public function insertPais(string $descripcion, int $listLocal, int $status)
    {
        $return = "";
        $this->descripcion  = $descripcion;
        $this->es_local     = $listLocal;
        $this->date_registro = date("YYYY-MM-DD HH:MI:SS");
        $this->activo       = $status;

        #Sentencia
        $sql = "SELECT * FROM cat_pais WHERE descripcion = '{$this->descripcion}' ";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);

        /*var_dump($request);
          exit();*/

        if (empty($request)) {

            $sql = "INSERT INTO cat_pais(descripcion, es_local, date_registro, activo) VALUE (?,?,?,?)";

            #arrData: array de información
            $arrData = array($this->descripcion, $this->es_local, $this->date_registro, $this->activo);

            #Envio a la funcion insert(sentencia y data)
            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
        return $return;
    }


    ### MODELO: ELIMINAR PAIS ###
    public function deletePais(int $intIdPais)
    {

        #id
        $this->cod_pais = $intIdPais;

        $sql = "UPDATE cat_pais SET activo = ? WHERE cod_pais =  '{$this->cod_pais}'";

        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }


    ### MODELO: EDITAR PAIS ###
    public function editPais(int $idPais)
    {

        //Buscar Pais
        $this->cod_pais = $idPais;
        $sql = "SELECT * FROM cat_pais WHERE cod_pais = '{$this->cod_pais}'";
        $request = $this->select($sql);
        return $request;
    }


    ### MODELO: ACTUALIZAR PAIS ###
    public function updatePais(int $intIdPais, string $descripcion, $listLocal, int $status)
    {

        #Recojo Data
        $this->cod_pais   = $intIdPais;
        $this->descripcion = $descripcion;
        $this->es_local     = $listLocal;
        $this->date_registro = date("F j, Y, g:i a");
        $this->activo       = $status;


        $sql = "SELECT * FROM cat_pais WHERE descripcion = '$this->descripcion' AND cod_pais != $this->cod_pais";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE cat_pais SET descripcion = ?, es_local = ?, date_registro = ?, activo = ? WHERE cod_pais = $this->cod_pais";
            $arrData = array($this->descripcion, $this->es_local, $this->date_registro, $this->activo);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }
}
