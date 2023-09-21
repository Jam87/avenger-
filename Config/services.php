<?php 
include_once 'conn.php';
include_once 'funciones.php';

$mysqli = $mysqli;

$mysqli->set_charset("utf8");

/* ========================================================================================================== */
/* = CATALOGOS ============================================================================================== */
/* ========================================================================================================== */
function view_familia($mysqli)
{
	$sql = "SELECT sfp.cod_familia, UPPER(sfp.nombre) AS nombre FROM store_familia_producto sfp WHERE sfp.activo = 1 ORDER BY sfp.nombre;";
		
	if ($result = $mysqli->query($sql, MYSQLI_STORE_RESULT))
	{
		
		while ($fila = $result->fetch_assoc())
		{
            $html .= '<option value="' . $fila["cod_familia"] . '">' . $fila["nombre"] . '</option>';
		}
		
		// Liberar MySQL
		clearStoredResults($mysqli);

		$state = "success";
	}
	else
	{
		$state = "alert";
	}
	
	$retorna["state"] = $state;
	$retorna["estructura"] = $html;
	
	return $retorna;	
}

function view_unidad_medida($mysqli)
{
	$sql = "SELECT um.cod_um, UPPER(um.nombre_um) AS Unidad FROM store_unidad_medida um WHERE um.activo = 1 ORDER BY um.nombre_um";
		
	if ($result = $mysqli->query($sql, MYSQLI_STORE_RESULT))
	{
		
		while ($fila = $result->fetch_assoc())
		{
            $html .= '<option value="' . $fila["cod_um"] . '">' . $fila["Unidad"] . '</option>';
		}
		
		// Liberar MySQL
		clearStoredResults($mysqli);

		$state = "success";
	}
	else
	{
		$state = "alert";
	}
	
	$retorna["state"] = $state;
	$retorna["estructura"] = $html;
	
	return $retorna;	
}

function view_proveedores($mysqli)
{
	$sql = "CALL sp_purchase_proveedor()";
		
	$html = "";
	$cantidad = 0;
	
	if ($result = $mysqli->query($sql, MYSQLI_STORE_RESULT))
	{
		
		while ($fila = $result->fetch_assoc())
		{
            $html .= '<tr onClick="selectProveedor(this);">';
            $html .= '<td class="codigo">' . $fila["CODIGO"] . '</td>';
            $html .= '<td class="name">' . $fila["NOMBRE"] . '</td>';
            $html .= '<td class="contacto">' . $fila["CONTACTO"] . '</td>';
            $html .= '<td class="pais">' . $fila["PAIS"] . '</td>';
            $html .= '<td class="pago">' . $fila["FORMA_PAGO"] . '</td>';
            $html .= "</tr>";

            $cantidad += 1;

		}
		
		// Liberar MySQL
		clearStoredResults($mysqli);

		$state = "success";
	}
	else
	{
		$state = "alert";
	}
	
	$retorna["state"] = $state;
	$retorna["estructura"] = $html;
	//$retorna["mensaje"] = $query;
	
	return $retorna;	
}

function view_productos_compras($mysqli)
{
	$sql = "CALL sp_purchase_producto()";
		
	$html = "";
	$cantidad = 0;
	
	if ($result = $mysqli->query($sql, MYSQLI_STORE_RESULT))
	{
		
		while ($fila = $result->fetch_assoc())
		{
            $html .= '<tr onClick="selectProducto(this);">';
            $html .= '<td class="codigo">' . $fila["CODIGO"] . '</td>';
            $html .= '<td class="familia">' . $fila["FAMILIA"] . '</td>';
            $html .= '<td class="producto">' . $fila["PRODUCTO"] . '</td>';
            $html .= '<td class="um">' . $fila["UM"] . '</td>';
            $html .= '<td class="altura">' . $fila["ALTURA"] . '</td>';
			$html .= '<td class="largo">' . $fila["LARGO"] . '</td>';
			$html .= '<td class="grosor">' . $fila["GROSOR"] . '</td>';
            $html .= "</tr>";

            $cantidad += 1;

		}
		
		// Liberar MySQL
		clearStoredResults($mysqli);

		$state = "success";
	}
	else
	{
		$state = "alert";
	}
	
	$retorna["state"] = $state;
	$retorna["estructura"] = $html;
	//$retorna["mensaje"] = $query;
	
	return $retorna;	
}

/* ========================================================================================================== */
/* = GESTIÓN DE COMPRAS ===================================================================================== */
/* ========================================================================================================== */
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
				1 /*var_cod_sesion*/,
				'INSERTAR' /*var_tipo*/
			); ";
	
	$array  = json_decode($_POST['detalle'], true);
    foreach($array as $value)
    {
		//$mensaje .= $value["precio"];
        $sql .= "CALL sp_purchase_compras_productos
                (
                    " . $codigo . ",
                    '" . $value["codigo"] . "',
                    " . $value["cantidad"] . ",
                    NULL /*var_cod_color_dn*/,
                    NULL /*var_descripcion_dn*/,
                    NULL /*var_arancel_dn*/,
					NULL /*var_peso_neto_dn*/,
                    " . $value["precio"] . ",
					NULL /*var_impuesto_dn*/,
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

/* REPORTES */
function view_compras($mysqli)
{		
	/* INGRESAR DATOS EN LA BASE DE DATOS */		
	$sql = " SELECT 
			pc.cod_compra AS CODIGO
			, pc.documento_numero AS DOCUMENTO
			, pp.nombre_proveedor AS PROVEEDOR
			, DATE_FORMAT(pc.documento_fecha,'%d/%m/%Y') AS FECHA
			, (SELECT SUM(pcd.total) FROM purchase_compras_detalle pcd WHERE pcd.cod_compra = pc.cod_compra) AS VALOR
			, cm.nombre_moneda AS MONEDA
			, IF(pc.compra_local = 1, 'Si', 'No') AS LOCAL
		FROM purchase_compras pc
		INNER JOIN pruchase_proveedor pp ON pp.cod_proveedor = pc.cod_proveedor
		INNER JOIN cat_moneda cm ON cm.cod_moneda = pc.cod_moneda
		WHERE
			pc.anulada = 0 ";
	
	$Filtro = true;
	
	if (isset($_POST["documento"]) && $_POST["documento"] !== "")
	{
		if ($Filtro == false){$sql .= " WHERE ";}else{$sql .= " AND ";}
		
		$sql .= "pc.documento_numero = " . $_POST["documento"];
		
		$Filtro = true;
	}
	
	if (isset($_POST["proveedor"]) && $_POST["proveedor"] !== "")
	{
		if ($Filtro == false){$sql .= " WHERE ";}else{$sql .= " AND ";}
		
		$sql .= "pp.nombre_proveedor = " . $_POST["proveedor"];
		
		$Filtro = true;
	}
	
	if (isset($_POST["FechaInicial"]) && $_POST["FechaInicial"] !== "")
	{
		if ($Filtro == false){$sql .= " WHERE ";}else{$sql .= " AND ";}
		
		$sql .= "pc.documento_fecha >= " . dateFormat($_POST["FechaInicial"]) . " ";
		
		$Filtro = true;
	}
	
	if (isset($_POST["FechaFinal"]) && $_POST["FechaFinal"] !== "")
	{
		if ($Filtro == false){$sql .= " WHERE ";}else{$sql .= " AND ";}
		
		$sql .= "pc.documento_fecha <= " . dateFormat($_POST["FechaFinal"]) . " ";
		
		$Filtro = true;
	}
	
	$sql .= " ORDER BY pc.documento_fecha";
	
	$html = "";
	$cantidad = 0;
	
	if ($result = $mysqli->query($sql, MYSQLI_STORE_RESULT))
	{
		
		while ($fila = $result->fetch_assoc())
		{
			$cantidad += 1;
			
			$html .= '<tr>';
			$html .= '<td>' . $fila["CODIGO"] . '</td>';
			$html .= '<td>' . $fila["DOCUMENTO"] . '</td>';
			$html .= '<td>' . $fila["PROVEEDOR"] . '</td>';
			$html .= '<td>' . $fila["FECHA"] . '</td>';
			$html .= '<td>' . $fila["MONEDA"] . " " . $fila["VALOR"] . '</td>';
			$html .= '<td>' . $fila["LOCAL"] . '</td>';
			$html .= '</tr>';
		}
		
		// Liberar MySQL
		clearStoredResults($mysqli);

		$state = "success";
		//$state = "alert";
	}
	else
	{
		$state = "alert";
	}
	
	$retorna["state"] = $state;
	$retorna["estructura"] = $html;
	$retorna["mensaje"] = $sql;
	
	return $retorna;	
}


/* ========================================================================================================== */
/* = VALIDACIONES DE CAMPOS ================================================================================= */
/* ========================================================================================================== */
function MyIsNull($value)
{
	if($value !== '')
	{
		return "'$value'";
	} 
	else
	{
		return "NULL";
	}
}

function MyBolean($value)
{
	if($value == 'on')
	{
		return 1;
	} 
	else
	{
		return 0;
	}
}

function generar_codigo($mysqli, $sql)
{	
	
	if ($result = $mysqli->query($sql, MYSQLI_STORE_RESULT))
	{
		$fila = $result->fetch_assoc();
			
		$retorna = $fila["CODIGO"];
			
		// Liberar MySQL
		clearStoredResults($mysqli);
	}
	else
	{
		$retorna = "";
	}
	
	
	return $retorna;	
}


if ( isset($_POST["type"]) )
{
	
	/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
	switch ($_POST["type"])
	{
		case "view_familia":
			$datos = view_familia($mysqli);
			
			break;
			
		case "view_unidad_medida":
			$datos = view_unidad_medida($mysqli);
			
			break;
			
		case "view_proveedores":
			$datos = view_proveedores($mysqli);
			
			break;
			
		case "view_productos_compras":
			$datos = view_productos_compras($mysqli);
			
			break;
			
		case "compra_new":
			$datos = compra_new($mysqli);
			
			break;
			
		case "view_compras":
			$datos = view_compras($mysqli);
			
			break;
			
		default:
			$datos = null;
			
	}
	/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
		
}
else
{
	$datos = null;
}

echo json_encode($datos);

?>