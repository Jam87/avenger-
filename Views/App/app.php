<?php


/*echo "<b>Usuario:</b>" . $_SESSION['idUser'] . "<br>";
echo "<b>ID sesion actual:</b>" . $_SESSION['Inicio_sesion'] . "<br>";
echo "<b>Fecha de inicio:</b>" . $_SESSION['Fecha_inicio'] . "<br>";
echo "<b>IP de conexion:</b>" . $_SESSION['Ip_conexion'] . "<br>";*/

echo "<b>DATA USER:</b>";

$UserObj = json_decode(json_encode($_SESSION['usuario'][0]), false);
$menuUser = json_decode(json_encode($_SESSION['menu'][0]), false);
dep($_SESSION['menu_actual']);

dep($_SESSION['submenu_actual']);

/*dep($UserObj);
dep($UserObj->cod_usuario);

echo "<b>USER MENU:</b><br>";
//$_SESSION['menu'] = Me muestra todo el array(menu que tiene permiso)
//$_SESSION['menu'][0] = Me muestra el 1 registro (Tengo que recorrerlo, para que me traiga los demas)
//$_SESSION['menu'][0]['id'] = Me muestra el ID del primero registro

/*$UserObj = json_decode(json_encode($_SESSION['menu']), false);
dep($UserObj);

echo "<b>SUB MENU:</b>";
dep($_SESSION['submenu']);*/

exit();


$usuarioObj = json_decode(json_encode($_SESSION['usuario'][0]), false);

$controler = ucfirst($usuarioObj->vista);


if (isset($usuarioObj->vista) && !empty($usuarioObj->vista)) {
    include  "Views/" . ucfirst($usuarioObj->vista) . "/" . $usuarioObj->vista . ".php";
} else {
    include  "Views/" . "Errors/" . "error" . ".php";
}


//dep($_SESSION['usuario']);

/* $usuarioObj = json_decode(json_encode($_SESSION['usuario'][0]), false);

$controler = ucfirst($usuarioObj->vista);


if (isset($usuarioObj->vista) && !empty($usuarioObj->vista)) {
    include  "Views/" . ucfirst($usuarioObj->vista) . "/" . $usuarioObj->vista . ".php";
} else {
    include  "Views/" . "Errors/" . "error" . ".php";
}
*/