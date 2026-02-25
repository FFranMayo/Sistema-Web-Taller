<?php

session_start();
require("libreria.php");

// Captura JSON del fetch
// php://input obtiene el cuerpo de la petición
// json_decode lo convierte en array asociativo
$input = json_decode(file_get_contents('php://input'), true);

// Verifica que existan los datos necesarios y si no hay datos o faltan, devuelve false
if (!$input || !isset($input['nombre']) || !isset($input['password'])) {
    echo json_encode(["success" => false]);
    exit();
}

$nombre = htmlspecialchars(trim($input['nombre']));
$password = $input['password'];

try {
    $conexion = conexion();

    $consulta = "SELECT * FROM Empleados WHERE nombre=?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $nombre);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        if (password_verify($password, $fila["password"])) {
            $_SESSION["empleado"] = $fila["nombre"];
            $_SESSION["id_empleado"] = $fila["id_empleado"];
            // Devuelve éxito en formato JSON
            echo json_encode(["success" => true]);
            exit(); // Finaliza correctamente
        }
    }

    // Si no coincide usuario o contraseña
    echo json_encode(["success" => false]);

} catch (mysqli_sql_exception $error) {
    // Si ocurre error en base de datos, devuelve false
    echo json_encode(["success" => false]);
}

?>
