<?php
include "conexion.php";  // Conexi�n tiene la informaci�n sobre la conexi�n de la base de datos.

// LAs siguientes son l�neas de c�digo HTML simple, para crear una p�gina web
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 	Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html>
    <head>
      <title> Consulta registro eventos INVERNADERO AUTOMATIZDO V1, por rango de fechas
		  </title>
    </head>
    <body>
      <table width="80%" align=center cellpadding=5 border=1 bgcolor="#FFFFFF">
    	 <tr>
         <td valign="top" align=center width=80& colspan=6 bgcolor="green"">
         
           <img src="img/inverna.jpg" width=800 height=250>
         </td>
 	     </tr>
 	     <tr>
         <td valign="top" align=center width=80& colspan=6 bgcolor="green"">
           <h1> <font color=white>INVERNADERO AUTOMATIZADO V1</font></h1>
           <h2> <font color=white>Consulta de registro eventos por rango de fechas</font></h2>
         </td>
 	     </tr>
<?php

 if ((isset($_POST["enviado"])))
   {
   $enviado = $_POST["enviado"];
   if ($enviado == "S1")
    {
       $fecha_ini = $_POST["fecha_ini"];  // en estas variables se almacenan los datos de fechas recibidos del formulario HTML inicial
       $fecha_fin = $_POST["fecha_fin"];
       $mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.
?>
    	 <tr>
         <td valign="top" align=center bgcolor="#E1E1E1" colspan=6>
            <b>Rango de fechas consultado: desde <?php echo $fecha_ini; ?> hasta <?php echo $fecha_fin; ?></b>
         </td>
    	 </tr>
    	 <tr>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>#</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Fecha</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Hora</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>id_limite</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>nombre_evento</b>
         </td>
 	     </tr>
<?php
// la siguiente linea almacena en una variable denominada sql1, la consulta en lenguaje SQL que quiero realizar a la base de datos. Se consultan los datos de la tarjeta 1, porque en la tabla puede haber datos de diferentes tarjetas.
$sql1 = "SELECT * from registro_eventos where fecha >= '$fecha_ini' and fecha <= '$fecha_fin' order by hora desc"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result1 = $mysqli->query($sql1);
// la siguiente linea es el inicio de un ciclo while, que se ejecuta siempre que la respuesta a la consulta de la base de datos
// tenga alg�n registro resultante. Como la consulta arroja X resultados, se ejecutar� X veces el siguiente ciclo while.
// el resultado de cada registro de la tabla, se almacena en el arreglo row, row[0] tiene el dato del 1er campo de la tabla, row[1] tiene el dato del 2o campo de la tabla, as� sucesivamente
$contador = 0;
while($row1 = $result1->fetch_array(MYSQLI_NUM))
{
 $fecha = $row1[1];
 $hora = $row1[2];
 $id_limite = $row1[3];
 $nombre_evento = $row1[4];

 $contador++;
?>
    	 <tr>
         <td valign="top" align=center>
           <?php echo $contador; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $fecha; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $hora; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $id_limite; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $nombre_evento; ?> 
         </td>
 	     </tr>
<?php
}  // FIN DEL WHILE
 echo '
      <tr>	
        <form method=POST action="programa3.php">
				  <td bgcolor="#EEEEEE" align=center colspan=6> 
				    <input type="submit" value="Volver" name="Volver">  
          </td>	
        </form>	
       </tr>';
 

    } // FIN DEL IF, si ya se han recibido las fechas del formulario
   }  // FIN DEL IF, si la variable enviado existe, que es cuando ya se env�o el formulario
  else
    {
?>    
     <form method=POST action="programa3.php">
 	     <tr>	
      		<td bgcolor="#CCEECC" align=center> 
			   	  <font FACE="arial" SIZE=2 color="#000044"> <b>Fecha Inicial:</b></font>  
				  </td>	
				  <td bgcolor="#EEEEEE" align=center> 
				    <input type="date" name="fecha_ini" value="" required>  
          </td>	
	     </tr>
 	     <tr>	
      		<td bgcolor="#CCEECC" align=center> 
			   	  <font FACE="arial" SIZE=2 color="#000044"> <b>Fecha Final:</b></font>  
				  </td>	
				  <td bgcolor="#EEEEEE" align=center> 
				    <input type="date" name="fecha_fin" value="" required>  
          </td>	
	     </tr>
       <tr>	
				  <td bgcolor="#EEEEEE" align=center colspan=2> 
				    <input type="hidden" name="enviado" value="S1">  
				    <input type="submit" value="Consultar" name="Consultar">  
          </td>	
	     </tr>
      </form>	  

<?php
    } 
?>    

       </table>
     </body>
   </html>