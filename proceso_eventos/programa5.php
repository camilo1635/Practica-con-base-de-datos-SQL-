<?php
include "conexion.php";  // Conexi�n tiene la informaci�n sobre la conexi�n de la base de datos.

$mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.

// CONSULTA TEMPERATURA MAXIMA
$mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.
$sql1 = "SELECT * from datos_maximos where id=1"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result1 = $mysqli->query($sql1);
$row1 = $result1->fetch_array(MYSQLI_NUM);
$temp_max = $row1[3];  

$long_temp_max= strlen($temp_max);
for ($i=$long_temp_max;$i<2;$i++)
  {
    $temp_max = "0".$temp_max;
  }

// CONSULTA HUMEDAD MAXIMA
$sql2 = "SELECT * from datos_maximos where id=2"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result2 = $mysqli->query($sql2);
$row2 = $result2->fetch_array(MYSQLI_NUM);
$hum_max = $row2[3];  

$long_hum_max= strlen($hum_max);
for ($i=$long_hum_max;$i<2;$i++)
  {
    $hum_max = "0".$hum_max;
  }

echo $temp_max.$hum_max; // Si result es 1, quiere decir que el ingreso a la base de datos fue correcto.



?>
