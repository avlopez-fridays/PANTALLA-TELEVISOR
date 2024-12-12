<?php
include './config/db.php';

$color1Count = 0;
$color2Count = 0;
$color3Count = 0;
$totalLotes = 0;
$lotes = [];

$sql = 'EXEC dbo.GetProductosPorColor';
$query = sqlsrv_query($conn, $sql);

if (!$query) {
    die('Error en la consulta: ' . print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    if ($row['Cantidad'] == 0) {
        continue;  // Saltar esta iteración del ciclo si la cantidad es 0
    }

    $colorClass = '';
    $alertIcon = '';

    $totalLotes++;

    if ($row['ColorCodigo'] == 2) {
        $alertIcon = '<i class="bi bi-exclamation-triangle text-danger"></i>';
        $color2Count++;
    }

    if ($row['ColorCodigo'] == 1) {
        $color1Count++;
    }

    if ($row['ColorCodigo'] == 3) {
        $color3Count++;
    }

    $colorClasses = [
        1 => 'color-1',
        2 => 'color-2',
        3 => 'color-3',
    ];

    $colorClass = isset($colorClasses[$row['ColorCodigo']]) ? $colorClasses[$row['ColorCodigo']] : 'color-0';

    $fecha = $row['Fecha'] ? $row['Fecha']->format('Y-m-d') : '';
    $vence = $row['Vence'] ? $row['Vence']->format('Y-m-d') : '';

    $lotes[] = [
        'lote' => htmlspecialchars($row['Lote']),
        'codigoProducto' => htmlspecialchars($row['CodigoProducto']),
        'nombre' => htmlspecialchars($row['Nombre']),
        'fecha' => $fecha,
        'vence' => $vence,
        'cantidad' => htmlspecialchars($row['Cantidad']),
        'colorClass' => $colorClass,
        'alertIcon' => $alertIcon
    ];
}

sqlsrv_close($conn);

echo json_encode([
    'color2Count' => $color2Count,
    'color1Count' => $color1Count,
    'color3Count' => $color3Count,
    'totalLotes' => $totalLotes,
    'lotes' => $lotes
]);
?>
