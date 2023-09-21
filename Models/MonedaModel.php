<?php
### CLASE: MonedaModel ###
class MonedaModel extends Mysql
{
    private $cod_moneda;
    private $nombre_moneda;
    private $es_local;
    private $date_registro;
    private $activo;


    public function __construct()
    {
        parent::__construct();
    }

    ### COMBOX: MOSTRAR TODOS LAS LAS MONEDAS ###
    public function comboxMoneda()
    {
        $sql = "SELECT cod_moneda, nombre_moneda FROM cat_moneda";

        $request = $this->select_all($sql);
        return $request;
    }


    ### MODELO: MOSTRAR TODAS LAS MONEDAS ###
    public function selectMoneda()
    {
        #Sentencia
        $sql = "SELECT * FROM  cat_moneda WHERE activo != 0";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: GUARDAR UNA NUEVA MONEDA ###
    public function insertMoneda(string $nombre_moneda, int $listLocal, int $status)
    {
        $return = "";
        $this->nombre_moneda  = $nombre_moneda;
        $this->es_local       = $listLocal;
        $this->date_registro  = gmdate('Y-m-d H:i:s');
        $this->activo         = $status;

        #Sentencia
        $sql = "SELECT * FROM cat_moneda WHERE nombre_moneda = '{$this->nombre_moneda}' ";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);

        /*var_dump($request);
          exit();*/

        if (empty($request)) {

            $sql = "INSERT INTO cat_moneda(nombre_moneda, es_local, date_registro, activo) VALUE (?,?,?,?)";

            #arrData: array de información
            $arrData = array($this->nombre_moneda, $this->es_local, $this->date_registro, $this->activo);


            #Envio a la funcion insert(sentencia y data)
            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
        return $return;
    }


    ### MODELO: ELIMINAR MONEDA ###
    public function deleteMoneda(int $intIdMoneda)
    {

        #id
        $this->cod_moneda = $intIdMoneda;

        $sql = "UPDATE cat_moneda SET activo = ? WHERE cod_moneda =  $this->cod_moneda";

        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }


    ### MODELO: EDITAR MONEDA ###
    public function editMoneda(int $idMoneda)
    {

        //Buscar Moneda
        $this->cod_moneda = $idMoneda;
        $sql = "SELECT * FROM cat_moneda WHERE cod_moneda = {$this->cod_moneda}";
        $request = $this->select($sql);
        return $request;
    }


    ### MODELO: ACTUALIZAR MONEDA ###
    public function updateMoneda(int $intIdMoneda, string $nombre, $listLocal, int $status)
    {

        #Recojo Data
        $this->cod_moneda    = $intIdMoneda;
        $this->nombre_moneda = $nombre;
        $this->es_local      = $listLocal;
        $this->date_registro = gmdate('Y-m-d H:i:s');
        $this->activo        = $status;


        $sql = "SELECT * FROM cat_moneda WHERE nombre_moneda = '$this->nombre_moneda' AND cod_moneda != $this->cod_moneda";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE cat_moneda SET nombre_moneda = ?, es_local = ?, date_registro = ?, activo = ? WHERE cod_moneda = $this->cod_moneda";
            $arrData = array($this->nombre_moneda, $this->es_local, $this->date_registro, $this->activo);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }
}
