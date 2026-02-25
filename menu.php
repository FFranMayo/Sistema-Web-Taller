<?php

// Incluye la librería donde están las funciones de conexión y CRUD
require("libreria.php");

// Inicia o reanuda la sesión
session_start();

// Si no existe la variable de sesión "empleado", significa que no ha iniciado sesión y entonces redirige al login
if (!isset($_SESSION["empleado"])) {
    header("Location: login.php");
    exit();
}

// Añadir cliente

// Verifica que el formulario se envió mediante POST
// Comprueba que el botón "Registrar" del formulario fue pulsado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["añadir_cliente"])) {
    // Llamamos a la función de la librería
    insertar_cliente();
    // Redirigir a la misma página para mostrar la tabla actualizada
    header("Location: menu.php?tabla=clientes");
    exit();
}

// Actualizar cliente

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar_cliente"])) {
    actualizar_cliente();
    header("Location: menu.php?tabla=clientes");
    exit();
}

// Eliminar cliente

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_cliente"])) {
    eliminar_cliente();
    header("Location: menu.php?tabla=clientes");
    exit();
}

// Eliminar con Checkbox

if (isset($_POST["eliminar_seleccionados"])) {
    // Solo elimina registros, la tabla se renderiza automáticamente
    mostrar_clientes_check();
    header("Location: menu.php?tabla=clientes");
    exit();
    }

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="recursos/icon.ico" type="image/x-icon">
    <title>Taller Relojería</title>
</head>

<body id="menu">

    <header>
        <img src="recursos/reloj.jpg" alt="Taller de Relojería" title="Taller de Relojería">
        <h1>MENÚ - Taller Relojería</h1>
    </header>

    <main class="menu">

        <h2>¡Bienvenido, <?= $_SESSION["empleado"];?>!</h2>

        <div class="contenedor">

            <div class="formularios">

                <section id="añadir">
                    <form action="" method="post" id="form_añadir">
                        <h3>Añadir Clientes</h3>
                
                        <div class="campo">
                            <label for="nombre_cliente">Cliente:</label>
                            <input type="text" name="nombre" id="nombre_cliente" maxlength="100" title="Escribe NOMBRE y APELLIDOS del cliente" required>
                        </div>
                
                        <div class="campo">
                            <label for="telefono">Telefono:</label>
                            <input type="text" name="telefono" id="telefono" maxlength="50" title="Escribe el Nº de TELÉFONO del cliente" required>
                        </div>
                
                        <div class="campo">
                            <label for="correo">Correo Electrónico:</label>
                            <input type="email" name="correo" id="correo" title="Escribe el EMAIL del cliente" required>
                        </div>
                
                        <div class="acciones">
                            <input type="submit" value="Registrar" name="añadir_cliente">
                            <input type="reset" value="Vaciar">
                        </div>
                    </form>
                </section>
                
                <section id="actualizar">
                    <form action="" method="post" id="form_actualizar">
                        <h3>Actualizar Clientes</h3>

                        <div class="campo">
                            <label for="id">ID cliente:</label>
                            <input type="number" id="id" name="id" min="1" required>
                        </div>
                
                        <div class="campo">
                            <label for="nombre_cliente_act">Cliente:</label>
                            <input type="text" name="nombre_cliente_act" id="nombre_cliente_act" maxlength="100" title="Modifica NOMBRE y APELLIDOS del cliente">
                        </div>
                
                        <div class="campo">
                            <label for="telefono_act">Telefono:</label>
                            <input type="text" name="telefono_act" id="telefono_act" maxlength="50" title="Modifica el Nº de TELÉFONO del cliente">
                        </div>
                
                        <div class="campo">
                            <label for="correo_act">Correo Electrónico:</label>
                            <input type="email" name="correo_act" id="correo_act" title="Modifica el EMAIL del cliente">
                        </div>
                
                        <div class="acciones">
                            <input type="submit" value="Actualizar" name="actualizar_cliente">
                            <input type="reset" value="Vaciar">
                        </div>
                    </form>
                </section>

                <section id="eliminar">
                    <form action="" method="post" id="form_eliminar">
                        <h3>Eliminar Clientes</h3>
                
                        <label for="id">ID Borrar:</label>
                        <input type="number" id="id" name="id" min="1" title="Introduce la ID" required>
                
                        <div class="acciones">
                            <input type="submit" value="Borrar" name="eliminar_cliente">
                        </div>
                    </form>
                </section>

            </div>

            <div class="tablas">

                <section id="lista">
                    <h3>Base de Datos - Taller</h3>

                    <div class="botones_tablas">
                        <!-- Botones para seleccionar qué tabla mostrar -->
                        <a href="?tabla=clientes">Clientes</a>
                        <a href="?tabla=empleados">Empleados</a>
                        <a href="?tabla=relojes">Relojes</a>
                        <a href="?tabla=reparaciones">Reparaciones</a>
                    </div>

                    <hr>

                    <?php
                        // Mostrar la tabla clientes por defecto
                        $tabla = $_GET["tabla"] ?? "clientes";

                        // Mostrar la tabla correspondiente según la opción seleccionada
                        switch ($tabla) {
                            case "clientes":
                                mostrar_clientes_check();
                                break;

                            case "empleados":
                                mostrar_empleados();
                                break;
                            
                            case "relojes":
                                mostrar_relojes();
                                break;
                            
                            case "reparaciones":
                                mostrar_reparaciones();
                                break;
                            
                            default:
                                echo "<p>Seleccione una tabla.</p>";
                        }
                    ?>
                </section>

            </div>

        </div>

        <section id="logout">
            <div>
                <a href="logout.php">Cerrar sesión</a>
            </div>
        </section>

    </main>

    <footer>
        <address>Francisco José Mayo Gutiérrez</address>
    </footer>

</body>

</html>
