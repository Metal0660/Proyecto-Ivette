<?php
// Datos de conexión a la base de datos
$servername = "localhost"; // Cambia esto por la dirección del servidor de tu base de datos
$username = "root"; // Nombre de usuario de la base de datos (en este caso, root)
$password = ""; // Contraseña de la base de datos (en este caso, vacía)
$dbname = "pepe"; // Nombre de la base de datos

// Obtener datos del formulario
$nombre_paquete = $_POST['nombre_paquete'];
$descripcion = $_POST['descripcion'];

// Procesar la imagen
$imagen = $_FILES['imagen']['name'];
$imagen_temporal = $_FILES['imagen']['tmp_name'];
$ruta_imagen = "C:/Users/sergi/Desktop/Proyectos/Ivette/Foto2/images/uploads/" . $imagen; // Ruta donde quieres almacenar la imagen

// Mover la imagen a la carpeta de almacenamiento
move_uploaded_file($imagen_temporal, $ruta_imagen);

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Preparar la consulta SQL
$sql = "INSERT INTO paquetes (imagen, nombre_paquete, descripcion) VALUES ('$ruta_imagen', '$nombre_paquete', '$descripcion')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    $response = array("exito" => true, "mensaje" => "Datos insertados correctamente.");
    echo json_encode($response);
} else {
    $response = array("exito" => false, "mensaje" => "Error al insertar datos: " . $conn->error);
    echo json_encode($response);
}

// Cerrar conexión
$conn->close();
?>
