<?php
### CLASE: UsuariosModel ###
class UsuariosModel extends Mysql
{
    private $cod_usuario;
    //private $cod_tipo_usuario;
    private $id_perfil_usuario;
    private $username;
    private $contrasenia;
    private $nombre;
    private $apellido;
    private $telefono;
    private $correo;
    private $direccion;
    private $date_registro;
    private $activo;


    public function __construct()
    {
        parent::__construct();
    }

    /***** COMBOX:TIPO DE USUARIO *****/
    #Mostrar info en el Combox
    public function comboxTipoUsuario()
    {
        $sql = "SELECT * FROM secure_user_type";

        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: MOSTRAR TODOS LOS TIPOS DE USUARIOS ###
    public function selectUsuario()
    {
        $sql = "SELECT 
                  u.cod_usuario,
                  CONCAT(u.nombre, ' ', u.apellido) nombre,
                  u.telefono,
                  u.correo,
                  s.usertype,
                  u.activo
                
                 FROM secure_user u 
                 INNER JOIN secure_user_type s
                 ON u.cod_tipo_usuario = s.cod_tipo_usuario
                 WHERE u.activo != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    ### MODELO: GUARDAR UN NUEVO TIPO DE USUARIO ###
    public function insertUsuario(
        string $nombre,
        string $apellido,
        string $correo,
        string $username,
        string $telefono,
        string $strPassword,
        string $txtDescription,
        int $lStatus,
        int $Tusuario
    ) {

        //$this->cod_tipo_usuario = $Tusuario;
        $this->id_perfil_usuario = $Tusuario;
        $this->username = $username;
        $this->contrasenia = $strPassword;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->direccion = $txtDescription;
        $this->date_registro = date('Y-m-d');
        $this->activo = $lStatus;

        $sql = "INSERT INTO secure_user(cod_tipo_usuario, username, contrasenia, nombre, apellido, telefono,
                                             correo, direccion, date_registro, activo)
                    VALUE (?,?,?,?,?,?,?,?,?,?)";

        $arrData = array(
            $this->id_perfil_usuario, $this->username, $this->contrasenia, $this->nombre, $this->apellido,
            $this->telefono, $this->correo, $this->direccion, $this->date_registro, $this->activo
        );

        $requestInsert = $this->insert($sql, $arrData);

        if (empty($requestInsert)) {
            $requestInsert = 'ok';
        }

        return $requestInsert;
    }

    ### MODELO: ELIMINAR EL USUARIO ###
    public function delUsuario(int $intIdUsuario)
    {
        $this->cod_usuario = $intIdUsuario;

        $sql = "UPDATE secure_user SET activo = ? WHERE cod_usuario =  '{$this->cod_usuario}'";

        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }

    ### MODELO: EDITAR USUARIO ###
    public function editUsuario(int $idUsuario)
    {
        //Buscar Usuario
        $this->cod_usuario = $idUsuario;
        $sql = "SELECT * FROM secure_user WHERE cod_usuario = '{$this->cod_usuario}'";
        $request = $this->select($sql);
        return $request;
    }

    ### MODELO: ACTUALIZAR TIPO DE USUARIO ###
    public function updateUsuario(
        int $intIdUsuario,
        string $nombre,
        string $apellido,
        string $correo,
        string $username,
        string $telefono,
        string $strPassword,
        string $txtDescription,
        int $lStatus,
        int $Tusuario
    ) {

        $this->cod_usuario = $intIdUsuario;
        $this->id_perfil_usuario = $Tusuario;
        $this->username = $username;
        $this->contrasenia = $strPassword;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->direccion = $txtDescription;
        $this->date_registro = date('Y-m-d');
        $this->activo = $lStatus;

        $sql = "UPDATE secure_user 
        SET id_perfil_usuario = ?, username = ?, contrasenia = ?, nombre = ?, apellido = ?, telefono = ?, correo = ?, direccion = ?, 
            date_registro = ?, activo = ?  

        WHERE cod_usuario = $this->cod_usuario";

        $arrData = array(
            $this->id_perfil_usuario, $this->username, $this->contrasenia, $this->nombre, $this->apellido, $this->telefono, $this->correo,
            $this->direccion, $this->date_registro, $this->activo
        );

        $request = $this->update($sql, $arrData);

        return $request;
    }
}
