<?php

// CONEXIÓN
function conexion(){
    // Ruta del archivo.env
    $ficheroEnv = __DIR__ . "/.env";

    // Si el archivo existe, se cargan las variables
    if (file_exists($ficheroEnv)) {
        $vars = parse_ini_file($ficheroEnv);

        foreach ($vars as $clave => $valor) {
            $_ENV[$clave] = $valor;
        }
    }

    // Obtener valores desde variables de entorno
    $servidor = $_ENV["DB_HOST"];
    $usuario = $_ENV["DB_USER"];
    $clave = $_ENV["DB_PASS"];
    $bd = $_ENV["DB_NAME"];

    // Conexión a MySQL
    $conexion = mysqli_connect($servidor, $usuario, $clave, $bd);

    // Si falla la conexión, lanza una excepción
    if(!$conexion){
        throw new Exception("Error de conexión: ".mysqli_connect_error());
    }

    return $conexion;
}


// PINTAR TABLAS
function pintar_tabla($array){
    if (empty($array)) echo "<p>La tabla está vacía</p>";
    else {
        $encabezados = array_keys($array[0]);
        echo "<table>";
        echo "<tr>";
        foreach ($encabezados as $titulo){
            echo "<th>$titulo</th>";
        }
        echo "</tr>";
        foreach($array as $registro){
            echo "<tr>";
            foreach ($registro as $campo){
                echo "<td>$campo</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
}


// SELECT para cada tabla
function mostrar_clientes() {

    try {
        $conexion = conexion();

        $consulta = "SELECT * FROM clientes ORDER BY id_cliente;";
        $resultado = mysqli_query($conexion, $consulta);
        $filas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        pintar_tabla($filas);

    } catch (mysqli_sql_exception $error) {
        echo "Error: " . $error->getMessage();
    }
}

function mostrar_relojes() {

    try {
        $conexion = conexion();

        $consulta = "SELECT * FROM relojes ORDER BY id_reloj;";
        $resultado = mysqli_query($conexion, $consulta);
        $filas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        pintar_tabla($filas);

    } catch (mysqli_sql_exception $error) {
        echo "Error: " . $error->getMessage();
    }
}

function mostrar_reparaciones() {

    try {
        $conexion = conexion();

        $consulta = "SELECT * FROM reparaciones ORDER BY id_reparacion;";
        $resultado = mysqli_query($conexion, $consulta);
        $filas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        pintar_tabla($filas);

    } catch (mysqli_sql_exception $error) {
        echo "Error: " . $error->getMessage();
    }
}

function mostrar_empleados() {

    try {
        $conexion = conexion();

        $consulta = "SELECT * FROM empleados ORDER BY id_empleado;";
        $resultado = mysqli_query($conexion, $consulta);
        $filas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        pintar_tabla($filas);

    } catch (mysqli_sql_exception $error) {
        echo "Error: " . $error->getMessage();
    }
}

// UPDATE
function actualizar_cliente() {
    try {
        $conexion = conexion();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar_cliente"])) {

            $id = intval($_POST["id"]);

            // Obtener los valores actuales de la base de datos
            $consulta = "SELECT * FROM clientes WHERE id_cliente = ?";
            $stmt = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($fila = mysqli_fetch_assoc($resultado)) {
                // Mantener los valores actuales si los inputs están vacíos
                $nombre = empty($_POST["nombre_cliente_act"]) ? $fila["nombre"] : htmlspecialchars(trim($_POST["nombre_cliente_act"]));
                $telefono = empty($_POST["telefono_act"]) ? $fila["telefono"] : htmlspecialchars(trim($_POST["telefono_act"]));
                $correo = empty($_POST["correo_act"]) ? $fila["correo_electronico"] : htmlspecialchars(trim($_POST["correo_act"]));
            }

            // Actualizar los valores en la base de datos
            $consulta = "UPDATE clientes SET nombre = ?, telefono = ?, correo_electronico = ? WHERE id_cliente = ?";

            $stmt = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($stmt, "sssi", $nombre, $telefono, $correo, $id);
            mysqli_stmt_execute($stmt);

            // Redirigir de nuevo al menú mostrando la tabla de clientes
            header("Location: menu.php?tabla=clientes");
            exit();
        }

    } catch (mysqli_sql_exception $error) {
        echo "Error: " . $error->getMessage();
    }
}


// INSERT
function insertar_cliente() {

    try {
        $conexion = conexion();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nombre = htmlspecialchars(trim($_POST["nombre"]));
            $telefono = htmlspecialchars(trim($_POST["telefono"]));
            $correo = htmlspecialchars(trim($_POST["correo"]));

            $consulta = "INSERT INTO clientes (nombre, telefono, correo_electronico) VALUES (?, ?, ?)";

            $stmt = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($stmt, "sss", $nombre, $telefono, $correo);
            mysqli_stmt_execute($stmt);

            header("Location: menu.php");
            exit();
        }

    } catch (mysqli_sql_exception $error) {
        echo "Error: " . $error->getMessage();
    }
}


// DELETE
function eliminar_cliente() {

    try {
        $conexion = conexion();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id = intval($_POST["id"]);

            $consulta = "DELETE FROM clientes WHERE id_cliente=?";

            $stmt = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            header("Location: menu.php");
            exit();
        }

    } catch (mysqli_sql_exception $error) {
        echo "Error: " . $error->getMessage();
    }
}


// DELETE con checkbox
function mostrar_clientes_check() {
    try {
        $conexion = conexion();

        // Procesar eliminación si se envió el formulario
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["seleccionados"])) {
            $ids = $_POST["seleccionados"];
            if (!empty($ids)) {
                $estructura = implode(',', array_fill(0, count($ids), '?'));
                $consulta = "DELETE FROM clientes WHERE id_cliente IN ($estructura)";
                $stmt = mysqli_prepare($conexion, $consulta);
                $tiposi = str_repeat('i', count($ids));
                mysqli_stmt_bind_param($stmt, $tiposi, ...$ids);
                mysqli_stmt_execute($stmt);
            }
        }

        // Mostrar tabla de clientes con checkbox
        $consulta = "SELECT * FROM clientes ORDER BY id_cliente";
        $resultados = mysqli_query($conexion, $consulta);
        $filas = mysqli_fetch_all($resultados, MYSQLI_ASSOC);

        if (!empty($filas)) {
            echo "<form method='post'>";
            echo "<table>";
            echo "<tr>";
            foreach (array_keys($filas[0]) as $titulo) {
                echo "<th>$titulo</th>";
            }
            echo "<th>Selecciona</th>";
            echo "</tr>";

            foreach ($filas as $registro) {
                echo "<tr>";
                foreach ($registro as $campo) {
                    echo "<td>$campo</td>";
                }
                // Checkbox por fila
                echo "<td><input type='checkbox' name='seleccionados[]' value='" . $registro["id_cliente"] . "'></td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<input type='submit' value='Eliminar seleccionados' name='eliminar_seleccionados'>";
            echo "</form>";
        } else {
            echo "<p>No hay clientes registrados.</p>";
        }

    } catch (mysqli_sql_exception $error) {
        echo "Error: " . $error->getMessage();
    }
}

?>