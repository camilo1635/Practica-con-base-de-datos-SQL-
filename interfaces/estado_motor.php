<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.
$mysqli = new mysqli($host, $user, $pw, $db);

if ($mysqli->connect_error) {
    die("Error en la conexión: " . $mysqli->connect_error);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Activación del Motor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            padding: 20px;
        }
        .header img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .header, .footer {
            background-color: green;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }
        .footer {
            border-radius: 0 0 10px 10px;
        }
        .content {
            text-align: center;
            padding: 20px;
        }
        .content img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .content form {
            margin-top: 20px;
        }
        .content form input[type="submit"] {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
        }
        .content form input[type="submit"]:hover {
            background-color: darkgreen;
        }
        .message {
            margin-top: 20px;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://img.freepik.com/foto-gratis/crecimiento-plantas-organicas-frescas-tecnologia-invernadero-moderna-generada-ia_188544-37874.jpg?w=996&t=st=1716761047~exp=1716761647~hmac=69e0099480e39719293812316176b9e787bcf668899c25d84c3d260afa0af38d" alt="Invernadero">
        </div>
        <div class="content">
            <h1>Activación del Motor Remoto</h1>
            <form method="post" action="">
                <input type="submit" name="ventilador" value="ON">
                <input type="submit" name="ventilador" value="OFF">
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['ventilador'])) {
                    $accion = $_POST['ventilador'];
                    $query = "";
                    $message = "";
                    $id_limite4 = 4; 
                    $id_evento4 = "Motor se activó en modo manual"; 
                    $id_limite5 = 5; 
                    $id_evento5 = "Motor se desactivó en modo manual"; 
                    
                    if ($accion == "ON") {
                        $query = "UPDATE estado_motor SET Activo = 1, Inactivo = 0";
                        $message = "El motor está encendido.";

                        $sql2 = "INSERT into registro_eventos (fecha, hora, id_limite, nombre_evento) VALUES (CURDATE(), CURTIME(), '$id_limite4', '$id_evento4')";
                        $result2 = $mysqli->query($sql2);
                        

                    } elseif ($accion == "OFF") {
                        $query = "UPDATE estado_motor SET Inactivo = 1, Activo = 0";
                        $message = "El motor está apagado.";

                        $sql2 = "INSERT into registro_eventos (fecha, hora, id_limite, nombre_evento) VALUES (CURDATE(), CURTIME(), '$id_limite5', '$id_evento5')";
                        $result2 = $mysqli->query($sql2);
                        
                    }

                    if ($query !== "") {
                        $result = $mysqli->query($query);
                        if ($result) {
                            echo "<p class='message'>$message</p>";
                        } else {
                            echo "<p class='message'>Error al actualizar el estado del motor: " . $mysqli->error . "</p>";
                        }
                    }
                }
            }
            ?>
        </div>
        <div class="footer">
            &copy;  Activación del Motor
        </div>
    </div>
</body>
</html>

