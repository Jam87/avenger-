<?php

class TallasModel extends Mysql
{
    private $cod_talla;
    private $cod_usos;
    private $descripcion;
    private $date_registro;
    private $activo;

    public function __construct()
    {
        parent::__construct();
    }

    ###########################
    ### COMBOX: MOSTRAR USO ###
    ###########################
    public function selectUso()
    {
        $sql = "SELECT * FROM store_usos";

        $request = $this->select_all($sql);
        return $request;
    }


    ### MODELO: MOSTRAR TODOS LAS TALLAS ###
    public function selectTallas()
    {
        #Sentencia
        $sql = "SELECT t.cod_talla, u.description, t.descripcion, t.activo
                FROM  store_tallas t
                INNER JOIN store_usos u
                ON t.cod_usos = u.cod_usos
                WHERE t.activo != 0";

        /*$sql = "SELECT *
                FROM  store_tallas 
                WHERE activo != 0";*/


        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: GUARDAR UN NUEVA TALLA ###
    public function insertBanco(int $uso, string $descripcion, int $status)
    {
        $return = "";
        $this->cod_usos = $uso;
        $this->descripcion = $descripcion;
        $this->date_registro = gmdate('Y-m-d H');
        $this->activo       = $status;

        #Sentencia
        $sql = "SELECT * FROM store_tallas WHERE descripcion = '{$this->descripcion}' ";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);

        /*var_dump($request);
          exit();*/

        if (empty($request)) {

            $sql = "INSERT INTO store_tallas(cod_usos, descripcion, date_registro, activo) VALUE (?,?,?,?)";

            #arrData: array de información
            $arrData = array($this->cod_usos, $this->descripcion, $this->date_registro, $this->activo);

            #Envio a la funcion insert(sentencia y data)
            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
        return $return;
    }


    ### MODELO: ELIMINAR TALLA ###
    public function deleteTalla(int $intIdTalla)
    {

        #id
        $this->cod_talla = $intIdTalla;

        $sql = "UPDATE store_tallas SET activo = ? WHERE cod_talla =  $this->cod_talla";

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
