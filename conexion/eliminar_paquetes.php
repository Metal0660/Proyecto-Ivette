<?php
// Datos de conexión a la base de datos
$servername = "localhost"; // Cambia esto si tu servidor de base de datos tiene un nombre diferente
$username = "root"; // Tu nombre de usuario de MySQL
$password = ""; // Tu contraseña de MySQL
$dbname = "pepe"; // Nombre de tu base de datos MySQL

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si se recibe un nombre para eliminar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
    // Conectar a la base de datos
    $conn = new mysqli("localhost", "root", "", "pepe");

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Sanitizar el nombre del paquete
    $nombre = $conn->real_escape_string($_POST['nombre']);

    // Consulta SQL para eliminar el paquete por nombre
    $sql = "DELETE FROM paquetes WHERE nombre = '$nombre'";

    if ($conn->query($sql) === TRUE) {
        echo "Paquete eliminado correctamente.";
    } else {
        echo "Error al eliminar el paquete: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "No se proporcionó un nombre para eliminar.";
}
?>