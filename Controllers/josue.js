/* GUARDAR REGISTROS */
function Guardar()
{
if ($("#txtDocumento").val() == "")
{
alert("<p>El proceso no puede continuar. <br /> El numero de documento es requerido. <br /><br /></p>");
return false;
}

if ($("#date-field").val() == "")
{
alert("<p>El proceso no puede continuar. <br /> La fecha es requerida. <br /><br /></p>");
return false;
}

if ($("#hdProveedor").val() == "")
{
alert("<p>El proceso no puede continuar. <br /> El proveedor es requerido. <br /><br /></p>");
return false;
}

if ( !parseFloat($("#cart-total").val()) > 0)
{
alert("<p>El proceso no puede continuar. <br /> El monto de la compa debe ser mayor a cero. <br /><br /></p>");
return false;
}

// GENERAR DETALLE…
function compra_new($mysqli)
{
$codigo = generar_codigo($mysqli, "SELECT IFNULL(MAX(pc.cod_compra),0) + 1 AS CODIGO FROM purchase_compras pc;");
$var_proveedor = $_POST["proveedor"];
$var_documento = $_POST["documento"];
$Fecha = $_POST["Fecha"];
$Moneda = $_POST["Moneda"];
$var_total = str_replace(",", "", $_POST["total"]);
$state = "";
$mensaje = "";

/* INGRESAR DATOS EN LA BASE DE DATOS */
$sql = " CALL sp_purchase_compras
(
" . $codigo . ",
" . $var_proveedor . ",
'" . $var_documento . "',
'" . $Fecha . "',
" . $Moneda . ",
1 /var_cod_sesion/,
'INSERTAR' /var_tipo/
); ";

$array = json_decode($_POST['detalle'], true);
foreach($array as $value)
{
//$mensaje .= $value["precio"];
$sql .= "CALL sp_purchase_compras_productos
(
" . $codigo . ",
'" . $value["codigo"] . "',
" . $value["cantidad"] . ",
NULL /var_cod_color_dn/,
NULL /var_descripcion_dn/,
NULL /var_arancel_dn/,
NULL /var_peso_neto_dn/,
" . $value["precio"] . ",
NULL /var_impuesto_dn/,
" . ($value["cantidad"] * $value["precio"]) . "
);";
}

if ($mysqli->multi_query($sql))
{
clearStoredResults($mysqli);

$state = "success";
$msg = "La transacción finalizo correctamente.";
}
else
{
$state = "alert";
$msg = "Falló la multiconsulta: (" . $mysqli->errno . ") " . $mysqli->error;
}

$retorna["state"] = $state;
$retorna["mensaje"] = $mensaje;
//$retorna["mensaje"] = $sql;

return $retorna;
}