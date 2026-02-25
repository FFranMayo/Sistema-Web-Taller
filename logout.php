<?php

// Inicia o reanuda la sesión actual
session_start();

// Destruye la sesión activa, eliminando todas las variables de sesión
session_destroy();

// Redirige al usuario a la página principal
header("Location: main.html");

?>