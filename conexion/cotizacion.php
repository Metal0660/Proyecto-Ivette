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
    $telefono = $_POST['telefono'];
    $email = $_POST['correo'];
    //$fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    // Query para insertar datos en la base de datos
    $sql = "INSERT INTO cotizaciones (nombre, telefono, correo, descripcion, fecha) VALUES ('$nombre', '$telefono', '$email', '$descripcion', '27/12/2003')";

    if ($conn->query($sql) === TRUE) {
        echo "Los datos se han insertado correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar conexión
$conn->close();
?>
