<?php
include "conexion.php";  // Conexi�n tiene la informaci�n sobre la conexi�n de la base de datos.

$mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.

// CONSULTA TEMPERATURA MAXIMA
$mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.
$sql1 = "SELECT * from datos_limite where id=1"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result1 = $mysqli->query($sql1);
$row1 = $result1->fetch_array(MYSQLI_NUM);
$temp_max = $row1[2];  

$long_temp_max= strlen($temp_max);
for ($i=$long_temp_max;$i<2;$i++)
  {
    $temp_max = "0".$temp_max;
  }

// CONSULTA HUMEDAD DE LA TIERRA MINIMA
$sql2 = "SELECT * from datos_limite where id=3"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result2 = $mysqli->query($sql2);
$row2 = $result2->fetch_array(MYSQLI_NUM);
$humT_min = $row2[2];  

$long_humT_min= strlen($humT_min);
for ($i=$long_humT_min;$i<2;$i++)
  {
    $humT_min = "0".$humT_min;
  }

//CONSULTA MINIMO DE TEMPERATURA
$sql3 = "SELECT * from datos_limite where id=2"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result3 = $mysqli->query($sql3);
$row3 = $result3->fetch_array(MYSQLI_NUM);
$temp_min = $row3[2];  

$long_temp_min= strlen($temp_min);
for ($i=$long_temp_min;$i<2;$i++)
  {
    $temp_min = "0".$temp_min;
  }

//consulta estado motor  
$sql4 = "SELECT * from estado_motor" ; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result4 = $mysqli->query($sql4);
$row4 = $result4->fetch_array(MYSQLI_NUM);
$estado = $row4[1];  

  
//consulta modo motor
$sql5 = "SELECT * from modo_motor" ; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result5 = $mysqli->query($sql5);
$row5 = $result5->fetch_array(MYSQLI_NUM);
$modo = $row5[1];


  echo $temp_max.$humT_min.$temp_min.$estado.$modo; // Si result es 1, quiere decir que el ingreso a la base de datos fue correcto.
?>
