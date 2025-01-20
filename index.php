<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/estilo.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
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
        let allLotes = [];
        let currentPage = 0;
        const rowsPerPage = 10;

        // Función para cargar los datos y dividirlos en grupos de 10
        function loadTableData() {
            fetch('data.php')
                .then(response => response.json())
                .then(data => {
                    allLotes = data.lotes;  // Guarda todos los lotes
                    currentPage = 0; // Reinicia la página

                    updateTable(); // Muestra los primeros 10 lotes
                    updateAlerts(data); // Actualiza las alertas
                })
                .catch(error => console.error('Error al cargar los datos:', error));
        }

        // Función para actualizar la tabla con los lotes correspondientes
        function updateTable() {
            const start = currentPage * rowsPerPage;
            const end = start + rowsPerPage;
            const currentLotes = allLotes.slice(start, end); // Muestra solo los lotes correspondientes a la página

            let tableRows = '';
            currentLotes.forEach((row, index) => {
                tableRows += `<tr class="${row.colorClass}">
                    <td class="alert-column">${row.alertIcon}</td>
                    <td>${row.lote}</td>
                    <td>${row.codigoProducto}</td>
                    <td>${row.nombre}</td>
                    <td>${row.fecha}</td>
                    <td>${row.vence}</td>
                    <td>${row.cantidad}</td>
                </tr>`;
            });

            document.getElementById('table-data').innerHTML = tableRows;
        }

        // Función para actualizar las alertas
        function updateAlerts(data) {
            document.getElementById('lotes-vencidos').textContent = data.color2Count;
            document.getElementById('vencen-hoy').textContent = data.color1Count;
            document.getElementById('proximo-a-vencer').textContent = data.color3Count;
            document.getElementById('total-lotes').textContent = data.totalLotes;
        }

        // Función para avanzar a la siguiente página de lotes
        function nextPage() {
            currentPage = (currentPage + 1) % Math.ceil(allLotes.length / rowsPerPage);
            updateTable();
        }

        // Cargar los datos inicialmente
        loadTableData();

        // Configurar el intervalo para cambiar la página cada 2 minutos
        setInterval(() => {
            nextPage();
        }, 20000); // 20000 ms = menos de 0.5 minutos

    </script>
</body>
</html>
