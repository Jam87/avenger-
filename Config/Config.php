<?php

/**
 * 
 * Poner URL por default
 * Poner constantes de conexion
 * Zona horaria
 * Simbolo de moneda
 * Datos variantes sistema
 * 
 */

/*----------  https://jip.grupopaniagua.com/
	Ruta o dominio del servidor  - Server path or domain
----------*/

#URL development
const BASE_URL = "http://localhost/avenger/";
//const BASE_URL_Usuario = "http://localhost/jip/Controllers/Usuarios";

#URL production
//const BASE_URL = "http://app.grupopaniagua.com/";


/*----------  
	Nombre de la empresa o compañia -  Company or company name
----------*/

const COMPANY = "ma-sistema";

/*----------  
	Idioma - Language
    Español -> es 
----------*/

const LANG = "es";

/*----------  
		Palabra clave dashboard - Dashboard keyword
		No usar los siguientes valores - Do not use the following values

		index | product | bag | registration | details | signin
----------*/

const DASHBOARD = "admin";

/*----------  
	Nombre de la sesion -  Session name
----------*/

const SESSION_NAME = "STO";


/*----------  Redes sociales - Social networks  ----------*/
const FACEBOOK = "https://www.facebook.com/CarlosAlfaroES/";
const INSTAGRAM = "";
const YOUTUBE = "https://www.youtube.com/c/CarlosAlfaro007";
const TWITTER = "";


/*----------  Configuración de moneda - Currency Settings  ----------*/
const COIN_SYMBOL = "$";
const COIN_NAME = "USD";
const COIN_DECIMALS = "2";
const COIN_SEPARATOR_THOUSAND = ",";
const COIN_SEPARATOR_DECIMAL = ".";


#CONEXION


#Development
const DB_HOST = "localhost";
const DB_NAME = "jipsafety";
const DB_USER = "root";
const DB_PASSWORD = "";
const DB_CHARSET = "charset=utf8";


//Base jipsafety
/*const DB_HOST = "82.180.174.103";
const DB_NAME = "u558030020_jipsafety";
const DB_USER = "u558030020_jipsafety";
const DB_PASSWORD = "1@XPv5P+";
const DB_CHARSET = "charset=utf8";*/

 #Zona horaria
 #date_default_timezone_set('America/Nicaragua');

 #Simbolo de moneda

 #Datos variantes del sistema
