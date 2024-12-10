<?php

include './config/db.php';

$color1Count = 0;
$color2Count = 0;  // Variable para contar los registros con color-2
$color3Count = 0;
$totalLotes = 0;
$tableRows = '';    // Variable para almacenar las filas de la tabla

$sql = 'EXEC dbo.GetProductosPorColor';
$query = sqlsrv_query($conn, $sql);

if (!$query) {
    die('Error en la consulta: ' . print_r(sqlsrv_errors(), true));
}

// Se ejecuta solo una vez la consulta
while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    // Verificar si la cantidad es igual a 0, en cuyo caso no mostrar la fila
    if ($row['Cantidad'] == 0) {
        continue;  // Saltar esta iteración del ciclo
    }

    // Asignar clase de color para las filas
    $colorClass = '';
    $alertIcon = '';

    $totalLotes++;

    if ($row['ColorCodigo'] == 2) {
        $alertIcon = '<i class="bi bi-exclamation-triangle text-danger"></i>';
       $color2Count++;  // Incrementar el contador para color-2
    }

    if ($row['ColorCodigo'] == 1) {
      //  $alertIcon = '<i class="bi bi-exclamation-triangle text-danger"></i>';
       $color1Count++;  // Incrementar el contador para color-2
    }

    if ($row['ColorCodigo'] == 3) {
        //  $alertIcon = '<i class="bi bi-exclamation-triangle text-danger"></i>';
         $color3Count++;  // Incrementar el contador para color-2
      }
  

    // Usar un array para los colores
    $colorClasses = [
        1 => 'color-1',
        2 => 'color-2',
        3 => 'color-3',
    ];

    $colorClass = isset($colorClasses[$row['ColorCodigo']]) ? $colorClasses[$row['ColorCodigo']] : 'color-0';

    // Convertir fechas de SQL Server a formato legible en PHP
    $fecha = $row['Fecha'] ? $row['Fecha']->format('Y-m-d') : '';
    $vence = $row['Vence'] ? $row['Vence']->format('Y-m-d') : '';

    // Generar las filas de la tabla
    $tableRows .= '<tr class="' . $colorClass . '">';
    $tableRows .= '<td class="alert-column">' . $alertIcon . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['Lote']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['CodigoProducto']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['Nombre']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($fecha) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($vence) . '</td>';
    //$tableRows .= '<td>' . htmlspecialchars($row['Dias']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['Cantidad']) . '</td>';
    $tableRows .= '</tr>';
}

sqlsrv_close($conn);

// Retornar la tabla y el número de lotes vencidos en formato JSON
echo json_encode([
    'color2Count' => $color2Count,
    'color1Count' => $color1Count,
    'color3Count' => $color3Count,
    'totalLotes' => $totalLotes, 
    'table' => $tableRows
]);


?>
