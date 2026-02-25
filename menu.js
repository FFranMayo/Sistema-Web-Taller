const g = x => document.getElementById(x);

g("formRegistro").addEventListener("submit", function(evento){

    // Comprueba si el formulario cumple las validaciones HTML5
    if(!this.checkValidity()){
        evento.preventDefault();
        this.reportValidity();
        return;
    }
    
    // Obtiene los valores de las contraseñas
    let clave1 = g("password_reg").value;
    let clave2 = g("clave_reg2").value;
    
    // Si las contraseñas no coinciden
    if (clave1 !== clave2){
        evento.preventDefault();
        g("clave_reg2").value = "";
        g("clave_reg2").focus();
        g("clave_reg2").classList.add("error");
        alert("Las contraseñas no coinciden.");
    }

});


g("formLogin").addEventListener("submit", async function(evento) {
    evento.preventDefault(); // Evita envío del formulario

    // Obtiene los valores del formulario
    const usuario = g("nombre_log").value.trim();
    const password = g("password_log").value;

    try {
        // Envía petición POST a login.php en formato JSON
        const res = await fetch("login.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ nombre: usuario, password })
        });

        // Convierte la respuesta a JSON
        const data = await res.json();

        if (data.success) {
            // Usuario correcto pues redirige
            window.location.href = "menu.php";
        } else {
            // Si login incorrecto
            alert("Usuario o contraseña incorrectos");
            g("password_log").value = ""; // Limpia contraseña
        }

    } catch (error) {
        // Si ocurre error de red o servidor
        console.error("Error en login:", error);
        alert("Ocurrió un error al intentar iniciar sesión");
    }
});
