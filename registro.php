<?php

require("libreria.php");

// Comprueba si el formulario fue enviado mediante método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $especialidad = htmlspecialchars(trim($_POST["especialidad"]));
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Encripta la contraseña antes de guardarla en la base de datos

    try {
        $conexion = conexion();

        $consulta = "INSERT INTO Empleados (nombre, especialidad, password) VALUES (?, ?, ?);";
        $prepara = mysqli_prepare($conexion, $consulta);
        mysqli_stmt_bind_param($prepara, "sss", $nombre, $especialidad, $password);
        mysqli_stmt_execute($prepara);

        header("Location: main.html");
        exit();

    } catch (mysqli_sql_exception $error) {
        // Si ocurre un error en la base de datos, lo muestra
        echo "Error: " . $error->getMessage();
    }
}

?>