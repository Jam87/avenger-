<?php
### CLASE: ClientesModel ###
class ClienteModel extends Mysql
{
    private $cod_cliente;
    private $nombre_cliente;
    private $numero_ruc;
    private $statusImpuesto;
    private $cod_pais;
    private $persona_contacto;
    private $cod_forma_pago;
    private $movil;
    private $telefono;
    private $extension;
    private $correo;
    private $direccion;
    private $date_registro;
    private $activo;

    public function __construct()
    {
        parent::__construct();
    }

    ##########################################
    ### MODELO: MOSTRAR TODOS LOS CLIENTES ###
    ##########################################
    public function selectClientes()
    {
        #Sentencia
        $sql = "SELECT c.cod_cliente, c.nombre_cliente, c.persona_contacto, p.descripcion, c.exento_impuesto, c.movil, c.email, c.activo
                FROM bill_clientes c 
                INNER JOIN cat_forma_Pago p
                ON c.cod_forma_pago = p.cod_forma_pago
                WHERE c.activo != 0";



        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    ########################################
    ### MODELO: GUARDAR UN NUEVO CLIENTE ###
    ########################################
    public function insertCliente(
        string $nombre,
        string $ruc,
        int $pais,
        string $personaContacto,
        int $pago,
        $impuesto,
        int $estado,
        int $movil,
        int $telefono,
        int $extension,
        string $correo,
        string $direccion
    ) {
        //$return = "";


        $this->nombre_cliente = $nombre;
        $this->numero_ruc = $ruc;
        $this->statusImpuesto = $impuesto;
        $this->cod_pais = $pais;
        $this->persona_contacto = $personaContacto;
        $this->cod_forma_pago = $pago;
        $this->movil = $movil;
        $this->telefono = $telefono;
        $this->extension = $extension;
        $this->correo = $correo;
        $this->direccion = $direccion;
        $this->date_registro  = gmdate('Y-m-d H');
        $this->activo = $estado;

        #Sentencia
        $sql = "SELECT * FROM bill_clientes WHERE nombre_cliente = '{$this->nombre_cliente}' AND numero_ruc = '{$this->numero_ruc}'";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);

        /*dep($request);
        exit();*/

        if (empty($request)) {

            $sql = "INSERT INTO bill_clientes(nombre_cliente, numero_ruc, exento_impuesto, cod_pais, persona_contacto, cod_forma_pago, movil, telefono,
                                              extension, email, direccion, date_registro, activo) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?)";

            #arrData: array de información
            $arrData = array(
                $this->nombre_cliente, $this->numero_ruc, $this->statusImpuesto, $this->cod_pais, $this->persona_contacto, $this->cod_forma_pago,
                $this->movil, $this->telefono, $this->extension, $this->correo, $this->direccion, $this->date_registro, $this->activo
            );

            #Envio a la funcion insert(sentencia y data)
            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
        return $return;
    }

    ################################
    ### MODELO: ELIMINAR CLIENTE ###
    ################################

    public function deleteCliente(int $intIdCliente)
    {

        #id
        $this->cod_cliente = $intIdCliente;

        $sql = "UPDATE bill_clientes SET activo = ? WHERE cod_cliente =  $this->cod_cliente";

        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        if ($request) {
            $request = 'ok';
        } else {
            $request = 'error';
        }
        return $request;
    }
}
