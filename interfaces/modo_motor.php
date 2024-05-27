<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.
$mysqli = new mysqli($host, $user, $pw, $db);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Moto del Ventilador</title>
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
            <img src="https://img.freepik.com/foto-gratis/crecimiento-plantas-organicas-frescas-tecnologia-invernadero-moderna-generada-ia_188544-37874.jpg?w=996&t=st=1716761047~exp=1716761647~hmac=69e0099480e39719293812316176b9e787bcf668899c25d84c3d260afa0af38d">
        </div>
        <div class="content">
            <h1>Control del motor</h1>
            <form method="post" action="">
                <input type="submit" name="ventilador" value="Automático">
                <input type="submit" name="ventilador" value="Remoto">
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['ventilador'])) {
                    $accion = $_POST['ventilador'];
                    $query = "";
                    $message = "";

                    if ($accion == "Automático") {
                        $query = "UPDATE modo_motor SET Remoto = 0, Automatico = 1"; // Actualiza con tu tabla y condición
                        $message = "El ventilador está en modo Automático.";

                    } elseif ($accion == "Remoto") {
                        $query = "UPDATE modo_motor SET Automatico = 0, Remoto = 1"; // Actualiza con tu tabla y condición
                        $message = "El ventilador está en modo Remoto.";
                    }

                    if ($query !== "") {
                        $result = $mysqli->query($query);
                        if ($result) {
                            echo "<p class='message'>$message</p>";
                        } else {
                            echo "<p class='message'>Error al actualizar el modo del ventilador: " . $mysqli->error . "</p>";
                        }
                    }
                }
            }
            ?>
        </div>
        <div class="footer">
            &copy; Modo del Motor
        </div>
    </div>
</body>
</html>


