<?php
 ### CLASE: ComprasModel ###
class ComprasModel extends Mysql
{
    #private $cod_forma_pago;
    #private $descripcion;
    #private $nota_forma_pago;
    #private $es_aplicado_ventas;
    #private $date_registro;
    #private $activo;

    public function __construct()
    {
        parent::__construct();
    }

    ### MODELO: MOSTRAR LA COMPRA SELECCIONADA ###
    public function getCompra()
    {
        #Sentencia
        $sql = "CALL sp_purchase_compras ( NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CONSULTA' );";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }
	
    ### MODELO: MOSTRAR EL DETALLE DE LA COMPRA SELECCIONADA ###
    public function getCompraDetalle()
    {
        #Sentencia
        $sql = "CALL sp_purchase_compras ( NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CONSULTA' );";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }
	
    public function lostProveedores()
    {
        $sql = "CALL sp_purchase_proveedor()";

        $request = $this->select_all($sql);
        return $request;
    }
}
