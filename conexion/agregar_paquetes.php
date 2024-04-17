<?php
// Datos de conexión a la base de datos
$servername = "localhost"; // Cambia esto si tu servidor de base de datos tiene un nombre diferente
$username = "root"; // Tu nombre de usuario de MySQL
$password = ""; // Tu contraseña de MySQL
$dbname = "pepe"; // Nombre de tu base de datos MySQL

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Procesar la imagen
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_temp = $_FILES['imagen']['tmp_name'];
    $imagen_tamaño = $_FILES['imagen']['size'];

    // Directorio donde se guardarán las imágenes
    $directorio_destino = "C:/Users/Maldo/Desktop/Foto2/img_paquetes/";

    // Mover la imagen al directorio de destino
    $ruta_imagen = $directorio_destino . $imagen_nombre;
    move_uploaded_file($imagen_temp, $ruta_imagen);

    // Query para insertar datos en la base de datos
    $sql = "INSERT INTO paquetes (imagen, nombre, descripcion) VALUES ('$ruta_imagen', '$nombre', '$descripcion')";

    if ($conn->query($sql) === TRUE) {
        // Mensaje de éxito para enviar al navegador
        echo "success";
    } else {
        // Mensaje de error para enviar al navegador
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar conexión
$conn->close();
?>