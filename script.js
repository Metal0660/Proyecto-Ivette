//Sesion
document.addEventListener("DOMContentLoaded", function() {
    // Variables para controlar si se han mostrado los mensajes de error
    var usuarioIncorrectoMostrado = false;
    var contraseñaIncorrectaMostrada = false;

    // Evento click para el botón de inicio de sesión
    document.getElementById("loginButton").addEventListener("click", function() {
        // Obtener referencias a los campos de usuario y contraseña
        var usuarioInput = document.getElementById("usuario");
        var contraseñaInput = document.getElementById("contraseña");
        var usuario = usuarioInput.value;
        var contraseña = contraseñaInput.value;

        // Verificar si ya se mostró el mensaje de usuario incorrecto
        if (usuario !== "admin" && !usuarioIncorrectoMostrado) {
            // Mostrar mensaje de error para el usuario
            mostrarError(usuarioInput, "Usuario incorrecto");
            usuarioIncorrectoMostrado = true; // Establecer la bandera a true
        } else if (usuario === "admin") {
            // Limpiar mensaje de error para el usuario si está presente
            limpiarError(usuarioInput);
            usuarioIncorrectoMostrado = false; // Restablecer la bandera a false
        }

        // Verificar si ya se mostró el mensaje de contraseña incorrecta
        if (contraseña !== "1234" && !contraseñaIncorrectaMostrada) {
            // Mostrar mensaje de error para la contraseña
            mostrarError(contraseñaInput, "Contraseña incorrecta");
            contraseñaIncorrectaMostrada = true; // Establecer la bandera a true
        } else if (contraseña === "1234") {
            // Limpiar mensaje de error para la contraseña si está presente
            limpiarError(contraseñaInput);
            contraseñaIncorrectaMostrada = false; // Restablecer la bandera a false
        }

        // Si tanto el usuario como la contraseña son correctos, redirigir a admin.html
        if (usuario === "admin" && contraseña === "1234") {
            window.location.href = "admin.html";
        }
    });

    // Función para mostrar mensaje de error debajo de un elemento
    function mostrarError(elemento, mensaje) {
        var errorSpan = document.createElement("span");
        errorSpan.textContent = mensaje;
        errorSpan.classList.add("error-message");
        errorSpan.style.color = "red"; // Establecer color rojo
        var contenedor = elemento.parentElement;
        contenedor.appendChild(errorSpan);
        contenedor.appendChild(document.createElement("br")); // Agregar un salto de línea
        elemento.style.border = "1px solid red"; // Establecer borde rojo
    }

    // Función para limpiar mensaje de error debajo de un elemento, si está presente
    function limpiarError(elemento) {
        var contenedor = elemento.parentElement;
        var errorSpan = contenedor.querySelector(".error-message");
        if (errorSpan) {
            contenedor.removeChild(errorSpan);
        }
        elemento.style.border = ""; // Eliminar borde rojo
    }

    // Eliminar mensajes de error al cambiar el contenido de las casillas
    document.getElementById("usuario").addEventListener("input", function() {
        limpiarError(this);
    });

    document.getElementById("contraseña").addEventListener("input", function() {
        limpiarError(this);
    });
});

//Galeria
// Función para enviar el formulario
function enviarPaquete(event) {
    event.preventDefault(); // Prevenir el comportamiento por defecto del formulario
    
    var url = 'http://localhost/pepe/agregar_paquetes.php'; // URL del script PHP para agregar paquetes
    var formulario = document.getElementById("formulario-paquetes");
    var datosFormulario = new FormData(formulario);

    // Validar longitud del nombre del paquete
    var nombrePaquete = datosFormulario.get("nombre_paquete");
    if (nombrePaquete.length <= 8) {
        alert("El nombre del paquete debe ser mayor a 8 caracteres.");
        return false; // Detener el envío del formulario
    }

    // Validar longitud de la descripción
    var descripcion = datosFormulario.get("descripcion");
    if (descripcion.length < 20) {
        alert("La descripción debe tener al menos 20 caracteres.");
        return false; // Detener el envío del formulario
    }

    // Realizar la llamada a la API
    fetch(url, {
        method: 'POST',
        body: datosFormulario
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta de la API. Código: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta de la API:', data);

        if (data) {
            if (data.exito) {
                var mensajeFinal = "Información enviada correctamente"; // Mensaje a mostrar
                alert(mensajeFinal);
                limpiarFormulario();
            } else {
                console.error('Error en la respuesta de la API:', data.mensaje || 'Mensaje no definido');
            }
        } else {
            console.error('Error en la respuesta de la API: Respuesta vacía');
        }
    })
    .catch(error => {
        console.error('Error en la llamada a la API:', error);
    });

    // Retornar false para cancelar el evento de envío del formulario
    return false;
}

// Función para limpiar el formulario después de enviar los datos
function limpiarFormulario() {
    document.getElementById("formulario-paquetes").reset();
}

// Capturar el evento de envío del formulario y llamar a la función enviarPaquete
document.getElementById("formulario-paquetes").addEventListener("submit", enviarPaquete);


//Eliminar Paquetes

/*function eliminarPaquete() {
    var url = 'http://192.168.1.101/pepe/eliminar_paquete.php'; // URL del script PHP para eliminar el paquete
    var nombrePaquete = document.getElementById("nombre").value;

    // Validar que se haya ingresado un nombre de paquete
    if (nombrePaquete.trim() === '') {
        alert("Por favor, ingresa un nombre de paquete.");
        return false; // Detener el envío del formulario
    }

    // Crear un objeto FormData y agregar el nombre del paquete
    var datosFormulario = new FormData();
    datosFormulario.append("nombre", nombrePaquete);

    // Configurar las opciones para la solicitud fetch
    var opciones = {
        method: 'POST',
        body: datosFormulario,
    };

    // Realizar la llamada al script PHP para eliminar el paquete
    fetch(url, opciones)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor. Código: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Respuesta del servidor:', data);

            if (data) {
                if (data.exito) {
                    var mensajeFinal = "El paquete '" + nombrePaquete + "' se eliminó correctamente"; // Mensaje a mostrar
                    alert(mensajeFinal);
                    limpiarFormulario(); // Opcional: limpiar el formulario después de eliminar
                } else {
                    console.error('Error en la respuesta del servidor:', data.mensaje || 'Mensaje no definido');
                }
            } else {
                console.error('Error en la respuesta del servidor: Respuesta vacía');
            }
        })
        .catch(error => {
            console.error('Error en la llamada al servidor:', error);
        });

    // Mostrar el campo "Es necesario" al presionar el botón
    mostrarEsNecesario();

    // Retornar false para cancelar el evento de envío del formulario
    return false;
}*/

function limpiarFormulario() {
    document.getElementById("nombre").value = ''; // Limpiar el campo de nombre del paquete
}

function mostrarEsNecesario() {
    var esNecesario = document.getElementById("esNecesario");
    esNecesario.style.display = "block";
}

//Pedir Cotizacion

function mostrarFormularioDeContacto() {
    document.getElementById("modal").style.display = "block";
    document.body.classList.add("modal-open");
}
  
function cerrarFormulario() {
    document.getElementById("modal").style.display = "none";
    document.body.classList.remove("modal-open");
}
  
// Función para mostrar el formulario de contacto
function mostrarFormularioDeContacto() {
    document.getElementById("modal").style.display = "block";
    document.body.classList.add("modal-open");
}

// Función para agregar el evento al botón de contacto
document.getElementById("contactoBtn").addEventListener("click", function(event) {
    event.preventDefault(); // Para evitar el comportamiento predeterminado del enlace
    mostrarFormularioDeContacto();
});
  
// Función para enviar el formulario
function enviarFormulario() {
    console.log('Enviando formulario...');
    limpiarMarcasInvalidas();

    var nombre = document.getElementById('nombre');
    var telefono = document.getElementById('telefono');
    var correo = document.getElementById('correo');

    // Validación de nombre
    if (nombre.value.trim() === '') {
        marcarCampoInvalido(nombre, 'Nombre es obligatorio');
        console.log('Después de validaciones - Error: Nombre es obligatorio');
        return;
    }

    // Validación de teléfono
    if (telefono.value.trim() === '') {
        marcarCampoInvalido(telefono, 'Teléfono es obligatorio');
        console.log('Después de validaciones - Error: Teléfono es obligatorio');
        return;
    }

    if (telefono.value.trim().length !== 10) {
        marcarCampoInvalido(telefono, 'Ingrese un número de teléfono válido');
        console.log('Después de validaciones - Error: Teléfono inválido');
        return;
    }

    // Validación de correo
    if (correo.value.trim() === '' || !esCorreoValido(correo.value.trim())) {
        marcarCampoInvalido(correo, 'Ingrese un correo válido');
        console.log('Después de validaciones - Error: Correo inválido');
        return;
    }

    console.log('Después de validaciones - Sin errores');

    // Datos del formulario a enviar
    var datosFormulario = {
        nombre: nombre.value.trim(),
        telefono: telefono.value.trim(), // Corregido el nombre del campo "telefono"
        correo: correo.value.trim(),
        descripcion: document.getElementById('descripcion').value.trim() // Corregido el nombre del campo "mensaje"
    };

    // Aquí puedes hacer algo con los datos del formulario, como enviarlos a tu servidor o almacenarlos localmente
    console.log('Datos del formulario:', datosFormulario);

    // Puedes agregar aquí cualquier otra lógica que necesites realizar después de enviar el formulario
}

// Función para agregar el evento al botón de enviar
document.getElementById("enviarBtn").addEventListener("click", function(event) {
    event.preventDefault(); // Para evitar el comportamiento predeterminado del botón
    enviarFormulario();
});
