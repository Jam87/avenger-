<?php
### CLASE: CONTACTO MODEL ###
class ContactoModel extends Mysql
{
    private $cod_contacto;
    private $descripcion;
    private $es_telefono;
    private $es_correo;
    private $es_url;
    private $date_registro;
    private $activo;

    public function __construct()
    {
        parent::__construct();
    }

    public function comboxContacto()
    {
        $sql = "SELECT cod_contacto,descripcion FROM cat_contacto";

        $request = $this->select_all($sql);
        return $request;
    }


    ### MODELO: MOSTRAR TODOS LOS CONTACTO ###
    public function selectContacto()
    {
        #Sentencia
        $sql = "SELECT * FROM  cat_contacto WHERE activo != 0";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: GUARDAR UN NUEVO CONTACTO###
    public function insertContacto(string $descripcion, int $telefono, int $correo, int $url, int $status)
    {
        $return = "";
        $this->descripcion    = $descripcion;
        $this->es_telefono    = $telefono;
        $this->es_correo      = $correo;
        $this->es_url         = $url;
        $this->date_registro  = gmdate('Y-m-d H');
        $this->activo         = $status;


        $sql = "INSERT INTO cat_contacto(descripcion, es_telefono, es_correo, es_url, date_registro, activo) 
                VALUE (?,?,?,?,?,?)";

        #arrData: array de información
        $arrData = array($this->descripcion, $this->es_telefono, $this->es_correo, $this->es_url, $this->date_registro, $this->activo);

        /*var_dump($arrData);
        exit();*/

        #Envio a la funcion insert(sentencia y data)
        $return = $this->insert($sql, $arrData);

        return $return;
    }


    ### MODELO: ELIMINAR FORMA DE CONTACTO ###
    public function deleteContacto(int $intIdContacto)
    {

        #id
        $this->cod_contacto = $intIdContacto;

        $sql = "UPDATE cat_contacto SET activo = ? WHERE cod_contacto =  {$this->cod_contacto}";

        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }


    ### MODELO: EDITAR FORMA DE CONTACTO ###
    public function editContacto(int $intIdContacto)
    {

        //Buscar forma de pago
        $this->cod_contacto = $intIdContacto;
        $sql = "SELECT * FROM cat_contacto WHERE cod_contacto  = {$this->cod_contacto}";
        $request = $this->select($sql);
        return $request;
    }


    ### MODELO: ACTUALIZAR CONTACTO ###
    public function updateContacto($intIdContacto, $descripcion, $telefono, $correo, $web, $status)
    {

        $this->cod_contacto       = $intIdContacto;
        $this->descripcion        = $descripcion;
        $this->es_telefono        = $telefono;
        $this->es_correo          = $correo;
        $this->es_url             = $web;
        $this->date_registro      = gmdate('Y-m-d H');;
        $this->activo             = $status;


        $sql = "SELECT * FROM cat_contacto WHERE descripcion = '$this->descripcion' AND cod_contacto != $this->cod_contacto";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE cat_contacto SET descripcion = ?, es_telefono = ?, es_correo = ?, es_url = ?, date_registro = ?, activo = ? WHERE cod_contacto   = {$this->cod_contacto}";
            $arrData = array($this->descripcion, $this->es_telefono, $this->es_correo, $this->es_url, $this->date_registro, $this->activo);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }
}
