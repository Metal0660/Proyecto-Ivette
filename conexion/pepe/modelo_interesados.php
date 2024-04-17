<?php
// Establecer el número de registros por página para la tabla de consultas
$records_per_page_table = 10;

// Calcular el offset para la consulta SQL
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual
$offset_table = ($page - 1) * $records_per_page_table;

// Definir las columnas permitidas para ordenar
$sortable_columns = array("nombre", "correo_electronico", "fecha", "numero_telefonico", "descripcion");

// Obtener la columna de ordenación y el tipo de orden (ascendente o descendente)
$sort_column = 'nombre'; // Columna predeterminada para ordenar
$sort_order = 'asc'; // Orden predeterminado
if (isset($_GET['sort']) && in_array($_GET['sort'], $sortable_columns)) {
    $sort_column = $_GET['sort'];
}
if (isset($_GET['order']) && $_GET['order'] === 'desc') {
    $sort_order = 'desc';
}

// Consulta SQL con la cláusula ORDER BY
$sql = "SELECT * FROM cotizaciones ORDER BY $sort_column $sort_order LIMIT $offset_table, $records_per_page_table";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Mostrar datos en la tabla de consultas
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["nombre"] . "</td>";
            echo "<td>" . $row["correo_electronico"] . "</td>";
            echo "<td>" . $row["fecha"] . "</td>";
            echo "<td>" . $row["numero_telefonico"] . "</td>";
            echo "<td>" . $row["descripcion"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No hay datos disponibles.</td></tr>";
    }
    $result->free(); // Liberar los resultados de la memoria
} else {
    echo "<tr><td colspan='5'>Error al ejecutar la consulta.</td></tr>";
}

$conn->close(); // Cerrar la conexión a la base de datos
?>
