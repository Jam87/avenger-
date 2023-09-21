<?php
 ### CLASE: PRESENTACION MODEL ###
class PresentacionModel extends Mysql
{
    private $cod_presentacion ;
    private $descripcion;
    private $date_registro;
    private $activo;


    public function __construct()
    {
        parent::__construct();
    }

    ### MODELO: MOSTRAR PRESENTACIONES ###
    public function selectPresentacion()
    {
        #Sentencia
        $sql = "SELECT * FROM  cat_presentacion WHERE activo != 0";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: GUARDAR NUEVA PRESENTACION ###
    public function insertPres(string $descripcion, int $status)
    {
        $return = "";
        $this->descripcion  = $descripcion;
        $this->date_registro = date("YYYY-MM-DD HH:MI:SS");
        $this->activo       = $status;

        #Sentencia
        $sql = "SELECT * FROM cat_presentacion WHERE descripcion = '{$this->descripcion}' ";
        
        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);        

        /*var_dump($request);
          exit();*/

        if (empty($request)) {

            $sql = "INSERT INTO cat_presentacion(descripcion, date_registro, activo) VALUE (?,?,?)";

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


    ### MODELO: ELIMINAR PAIS ###
    public function deletePres(int $intIdPres)
    {

        #id
        $this->cod_presentacion  = $intIdPres;

        $sql = "UPDATE cat_presentacion SET activo = ? WHERE cod_presentacion =  '{$this->cod_presentacion}'";

        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }
 

    ### MODELO: EDITAR PRESENTACION ###
    public function editPress(int $idPres){
        
        //Buscar Pais
        $this->cod_presentacion = $idPres;
        $sql = "SELECT * FROM cat_presentacion WHERE cod_presentacion = '{$this->cod_presentacion}'";
        $request = $this->select($sql);
        return $request;
    }

   
    ### MODELO: ACTUALIZAR PRESENTACION ###
    public function updatePres(int $intIdPres, string $descripcion, int $status){

        #Recojo Data
        $this->cod_presentacion  = $intIdPres;
        $this->descripcion       = $descripcion;
        $this->date_registro     = date("F j, Y, g:i a");
        $this->activo            = $status;


        $sql = "SELECT * FROM cat_presentacion WHERE descripcion = '$this->descripcion' AND cod_presentacion != $this->cod_presentacion";
        $request = $this->select_all($sql);

        if(empty($request))
        {
            $sql = "UPDATE cat_presentacion SET descripcion = ?, date_registro = ?, activo = ? WHERE cod_presentacion = $this->cod_presentacion";
            $arrData = array($this->descripcion, $this->date_registro, $this->activo);
            $request = $this->update($sql,$arrData);
        }else{
            $request = "exist";
        }
        return $request;			
    }
   
}
