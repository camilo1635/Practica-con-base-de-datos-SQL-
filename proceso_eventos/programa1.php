<?php
include "conexion.php";  // Conexi�n tiene la informaci�n sobre la conexi�n de la base de datos.

$humedad_aire = $_GET["humedad_aire"]; // el dato de humedad que se recibe aqu� con GET denominado humedad, es enviado como parametro en la solicitud que realiza la tarjeta microcontrolada
$temperatura = $_GET["temperatura"]; // el dato de temperatura que se recibe aqu� con GET denominado temperatura, es enviado como parametro en la solicitud que realiza la tarjeta microcontrolada
$humedad_tierra = $_GET["humedad_tierra"];
$luz = $_GET["luz"];
//$modo_motor = $_GET["modo_motor"];


$mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.

//date_default_timezone_set('America/Bogota'); // esta l�nea es importante cuando el servidor es REMOTO y est� ubicado en otros pa�ses como USA o Europa. Fija la hora de Colombia para que grabe correctamente el dato de fecha y hora con CURDATE y CURTIME, en la base de datos.

//$fecha = date("Y-m-d");
//$hora = date("h:i:s");

$sql1 = "INSERT into datos_medidos (fecha, hora,temperatura, humedad_aire, humedad_tierra,luz) VALUES (CURDATE(), CURTIME(),'$temperatura', '$humedad_aire', '$humedad_tierra','$luz' )"; // Aqu� se ingresa el valor recibido a la base de datos.
echo "sql1...".$sql1; // Se imprime la cadena sql enviada a la base de datos, se utiliza para depurar el programa php, en caso de alg�n error.
$result1 = $mysqli->query($sql1);
echo "result es...".$result1; // Si result es 1, quiere decir que el ingreso a la base de datos fue correcto.

//condicionales
$sql2 = "SELECT * from datos_limite where id=1"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result2 = $mysqli->query($sql2);
$row1 = $result2->fetch_array(MYSQLI_NUM);
$temp_max = $row1[2];  

$sql3 = "SELECT * from datos_limite where id=2"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result3 = $mysqli->query($sql3);
$row1 = $result3->fetch_array(MYSQLI_NUM);
$temp_min = $row1[2];  

$sql4 = "SELECT * from datos_limite where id=3"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result4 = $mysqli->query($sql2);
$row1 = $result4->fetch_array(MYSQLI_NUM);
$humT_min = $row1[2];  

if ($temperatura > $temp_max) { 
    $id_limite = 1; 
    $id_evento = "Se supero la temperatura maxima"; 

    $sql2 = "INSERT into registro_eventos (fecha, hora, id_limite, nombre_evento) VALUES (CURDATE(), CURTIME(), '$id_limite', '$id_evento')";
    echo "sql2: " . $sql2;
    $result2 = $mysqli->query($sql2);
    echo "result2: " . $result2;
}

if ($temperatura < $temp_min) { 
    $id_limite = 2; 
    $id_evento = "Esta por debajo de la temperatura minima"; 

    $sql3 = "INSERT into registro_eventos (fecha, hora, id_limite, nombre_evento) VALUES (CURDATE(), CURTIME(), '$id_limite', '$id_evento')";
    echo "sql3: " . $sql3;
    $result3 = $mysqli->query($sql3);
    echo "result3: " . $result3;
}

if ($humedad_tierra < $humT_min) { 
    $id_limite = 3; 
    $id_evento = "Humedad esta por debajo del limite"; 
    $id_limite6 = 6; 
    $id_evento6 = "Motor se activó en modo automatico"; 
    

    $sql4 = "INSERT into registro_eventos (fecha, hora, id_limite, nombre_evento) VALUES (CURDATE(), CURTIME(), '$id_limite', '$id_evento')";
    echo "sql4: " . $sql4;
    $result4 = $mysqli->query($sql4);
    echo "result4: " . $result4;

    
    $sql5 = "INSERT into estado_motor (valor) VALUES (1)";
    echo "sql5: " . $sql5;
    $result5 = $mysqli->query($sql5);
    echo "result5: " . $result5;
    
    $sql6 = "INSERT into registro_eventos (fecha, hora, id_limite, nombre_evento) VALUES (CURDATE(), CURTIME(), '$id_limite6', '$id_evento6')";
    $result6 = $mysqli->query($sql6);
}else{
    $id_limite7 = 7; 
    $id_evento7 = "Motor se desactivó en modo automatico"; 
    
    $sql7 = "INSERT into registro_eventos (fecha, hora, id_limite, nombre_evento) VALUES (CURDATE(), CURTIME(), '$id_limite7', '$id_evento7')";
    $result7 = $mysqli->query($sql7);
}

//Realizar condicion de actuador

?>
