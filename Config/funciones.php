<?php 
/* ============================================================== */
/* CONEXIONES =================================================== */
function clearStoredResults($mysqli_link)
{
    //while($mysqli_link->next_result())

	while($mysqli_link->more_results() && $mysqli_link->next_result())
	{
	  if($l_result = $mysqli_link->store_result())
	  {
			  $l_result->free();
	  }
	}
	
}

function dateFormat($fecha)
{
	return "STR_TO_DATE(REPLACE('" . $fecha . "','/','.') ,GET_FORMAT(date,'EUR'))";
}