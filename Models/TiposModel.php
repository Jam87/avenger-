<?php
 ### CLASE: TiposModel ###
class TiposModel extends Mysql
{
    private $cod_tipo_usuario;
    private $usertype;
    private $descriptiontype;
    private $activo;

    public function __construct()
    {
        parent::__construct();
    }

    ### MODELO: MOSTRAR TODOS LOS TIPOS DE USUARIOS ###
    public function selectTipo()
    {
        #Sentencia
        $sql = "SELECT * FROM secure_user_type WHERE activo != 0";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: GUARDAR UN NUEVO TIPO DE USUARIO ###
    public function insertTipo(string $name, string $description, int $status)
    {
        $return = "";
        $this->usertype = $name;
        $this->descriptiontype = $description;
        $this->activo = $status;

        #Sentencia
        $sql = "SELECT * FROM secure_user_type WHERE usertype = '{$this->usertype}' ";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);

        /*var_dump($request);
          exit();*/

        if (empty($request)) {

            $sql = "INSERT INTO secure_user_type(usertype, descriptiontype, activo) VALUE (?,?,?)";

            #arrData: array de información
            $arrData = array($this->usertype, $this->descriptiontype, $this->activo);

            #Envio a la funcion insert(sentencia y data)
            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
        return $return;
    }

    ### MODELO: ELIMINAR TIPO DE USUARIO ###
    public function deleteTipo(int $intIdTipo)
    {

        #id
        $this->cod_tipo_usuario = $intIdTipo;

        $sql = "UPDATE secure_user_type SET activo = ? WHERE cod_tipo_usuario =  '{$this->cod_tipo_usuario}'";

        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }

    ### MODELO: EDITAR TIPO DE USUARIO ###
    public function editTipo(int $idUsuario){
        
        //Buscar Tipo de Usuario
        $this->cod_tipo_usuario = $idUsuario;
        $sql = "SELECT * FROM secure_user_type WHERE cod_tipo_usuario = '{$this->cod_tipo_usuario}'";
        $request = $this->select($sql);
        return $request;
    }

    
    ### MODELO: ACTUALIZAR TIPO DE USUARIO ###
    public function updateTipo(int $intIdTipo, string $name, string $description, int $status){

        $this->cod_tipo_usuario = $intIdTipo;
        $this->usertype = $name;
        $this->descriptiontype = $description;
        $this->activo = $status;


        $sql = "SELECT * FROM secure_user_type WHERE usertype = '$this->usertype' AND cod_tipo_usuario != $this->cod_tipo_usuario";
        $request = $this->select_all($sql);

        if(empty($request))
        {
            $sql = "UPDATE secure_user_type SET usertype = ?, descriptiontype = ?, activo = ? WHERE cod_tipo_usuario = $this->cod_tipo_usuario";
            $arrData = array($this->usertype, $this->descriptiontype, $this->activo);
            $request = $this->update($sql,$arrData);
        }else{
            $request = "exist";
        }
        return $request;			
    }

}
