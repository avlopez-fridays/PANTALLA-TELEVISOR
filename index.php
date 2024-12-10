<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/estilo.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">     <!-- Estilo de las alertas -->
</head>
<body>
    <!-- Contenedor de Alertas -->
    <div class="alerts-container p-4">
        <!-- Alerta de Lotes Vencidos -->
        <div class="alert alert-danger" role="alert">
            <span>Lotes Vencidos:</span>
            <span class="badge bg-light text-dark" id="lotes-vencidos">0</span>
        </div>

        <!-- Alerta de Lotes que Vencen Hoy -->
        <div class="alert alert-warning" role="alert">
            <span>Vencen Hoy:</span>
            <span class="badge bg-light text-dark" id="vencen-hoy">0</span>
        </div>

        <!-- Alerta de Lotes Próximos a Vencer -->
        <div class="alert alert-warning" role="alert" style="background-color: #f1c40f;">
            <span>Próximo a Vencer:</span>
            <span class="badge bg-light text-dark" id="proximo-a-vencer">0</span>
        </div>

        <!-- Alerta de Total de Lotes -->
        <div class="alert alert-primary" role="alert">
            <span>Total de Lotes:</span>
            <span class="badge bg-light text-dark" id="total-lotes">0</span>
        </div>
    </div>

    <!-- Tabla de Datos -->
    <div class="container-fluid">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>LOTE</th>
                    <th>CÓDIGO PRODUCTO</th>
                    <th>NOMBRE</th>
                    <th>FECHA</th>
                    <th>VENCE</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            <tbody id="table-data">
                <!-- Los datos se cargarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function loadTableData() {
            fetch('data.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('table-data').innerHTML = data.table;

                    document.getElementById('lotes-vencidos').textContent = data.color2Count;
                    document.getElementById('vencen-hoy').textContent = data.color1Count;
                    document.getElementById('proximo-a-vencer').textContent = data.color3Count;
                    document.getElementById('total-lotes').textContent = data.totalLotes;
                })
                .catch(error => console.error('Error al cargar los datos:', error));
        }

        setInterval(loadTableData, 10000);
        loadTableData();
    </script>
</body>
</html>
