<?php
$serverName = '10.1.11.99'; // Dirección del servidor SQL
$connectionOptions = array(
    'Database' => 'FridaysInventarios', // Nombre de la base de datos
    'Uid' => 'consultas',    // Usuario de SQL Server
    'PWD' => 'sistemas11'     // Contraseña
);

// Establece la conexión
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Verifica si la conexión fue exitosa
if (!$conn) {
    die('Conexión fallida: ' . print_r(sqlsrv_errors(), true));
}
?>
