<?php
 ### CLASE: COLORES MODEL ###
class ColoresModel extends Mysql
{
    private $cod_color;
    private $descripcion;
    private $codigo_html;
    private $date_registro;
    private $activo;


    public function __construct()
    {
        parent::__construct();
    }

    ### MODELO: MOSTRAR COLORES ###
    public function selectColores()
    {
        #Sentencia
        $sql = "SELECT * FROM  cat_colores WHERE activo != 0";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: GUARDAR NUEVO COLOR ###
    public function insertColor(string $descripcion, string $txtColor, int $status)
    {
        $return = "";
        $this->descripcion  = $descripcion;
        $this->codigo_html  = $txtColor;
        $this->date_registro = gmdate('Y-m-d H');
        $this->activo       = $status;

        #Sentencia
        $sql = "SELECT * FROM cat_colores WHERE descripcion = '{$this->descripcion}' ";
        
        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);        

        /*var_dump($request);
          exit();*/

        if (empty($request)) {

            $sql = "INSERT INTO cat_colores(descripcion, codigo_html, date_registro, activo) VALUE (?,?,?,?)";
        
            #arrData: array de información
            $arrData = array($this->descripcion, $this->codigo_html, $this->date_registro, $this->activo);

            #Envio a la funcion insert(sentencia y data)
            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
        return $return;
    }


    ### MODELO: ELIMINAR COLOR ###
    public function deleteColor(int $intIdColor)
    {

        #id
        $this->cod_color  = $intIdColor;

        $sql = "UPDATE cat_colores SET activo = ? WHERE cod_color =  '{$this->cod_color}'";

        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }
 

    ### MODELO: EDITAR COLOR ###
    public function editColor(int $idColor){
        
        //Buscar Color
        $this->cod_color = $idColor;
        $sql = "SELECT * FROM cat_colores WHERE cod_color = {$this->cod_color}";
        $request = $this->select($sql);
        return $request;
    }

   
    ### MODELO: ACTUALIZAR COLOR ###
    public function updateColor(int $intIdColor, string $descripcion, string $txtColor, int $status){

        #Recojo Data
        $this->cod_color         = $intIdColor;
        $this->descripcion       = $descripcion;
        $this->codigo_html       = $txtColor;
        $this->date_registro     = gmdate('Y-m-d H');
        $this->activo            = $status;


        $sql = "SELECT * FROM cat_colores WHERE descripcion = '{$this->descripcion}' AND cod_color != $this->cod_color";
        $request = $this->select_all($sql);

        if(empty($request))
        {
            $sql = "UPDATE cat_colores SET descripcion = ?, codigo_html = ?, date_registro = ?, activo = ? WHERE cod_color = $this->cod_color";

            $arrData = array($this->descripcion, $this->codigo_html, $this->date_registro, $this->activo);

            $request = $this->update($sql,$arrData);
        }else{
            $request = "exist";
        }
        return $request;			
    }
   
}
