<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "usuario", "contraseña", "base_de_datos");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener todos los datos de la tabla cotizaciones
$sql = "SELECT * FROM cotizaciones";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Crear un nuevo objeto Excel
    $excel = new COM("Excel.Application") or die("No se puede iniciar Excel");
    $excel->Visible = 1;
    $excel->DisplayAlerts = 0;

    // Agregar una nueva hoja de trabajo
    $workbook = $excel->Workbooks->Add();

    // Seleccionar la primera hoja de trabajo
    $sheet = $workbook->Worksheets(1);
    $sheet->Activate();

    // Definir el encabezado de la tabla
    $sheet->Cells(1, 1)->Value = "Nombre";
    $sheet->Cells(1, 2)->Value = "Correo electrónico";
    $sheet->Cells(1, 3)->Value = "Fecha";
    $sheet->Cells(1, 4)->Value = "Número telefónico";
    $sheet->Cells(1, 5)->Value = "Descripción";

    // Iterar sobre los resultados de la consulta y escribir los datos en el archivo Excel
    $row = 2; // Comenzar en la segunda fila
    while($data = $result->fetch_assoc()) {
        $sheet->Cells($row, 1)->Value = $data["nombre"];
        $sheet->Cells($row, 2)->Value = $data["correo_electronico"];
        $sheet->Cells($row, 3)->Value = $data["fecha"];
        $sheet->Cells($row, 4)->Value = $data["numero_telefonico"];
        $sheet->Cells($row, 5)->Value = $data["descripcion"];
        $row++;
    }

    // Guardar el archivo Excel
    $filename = "cotizaciones.xlsx";
    $workbook->SaveAs($filename);

    // Cerrar el archivo Excel
    $workbook->Close(false);

    // Terminar la aplicación Excel
    $excel->Quit();
    $excel = null;

    // Descargar el archivo Excel generado
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    readfile($filename);

    // Eliminar el archivo Excel temporal
    unlink($filename);
} else {
    echo "No hay datos disponibles para exportar.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>