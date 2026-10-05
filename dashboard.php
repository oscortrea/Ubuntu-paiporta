<?php
require_once 'config.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Estadísticas : PaiportArbolado</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Importar Chart.js desde CDN oficial -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }
        .chart-card {
            background: var(--bg-card);
            padding: 25px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid #e2e8f0;
        }
        .chart-card h3 {
            margin-top: 0;
            color: var(--text-main);
            font-size: 1.1rem;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Dashboard de Estadísticas</h1>
    <p>Panel analítico de la vegetación urbana de Paiporta | <a href="index.php">Volver al Listado</a></p>

    <div class="dashboard-container">
        <!-- Gráfico 1: Árboles por Especie -->
        <div class="chart-card">
            <h3>Distribución por Especie</h3>
            <canvas id="graficoEspecies"></canvas>
        </div>

        <!-- Gráfico 2: Árboles por Estado -->
        <div class="chart-card">
            <h3>Estado Fitosanitario / Conservación</h3>
            <canvas id="graficoEstados"></canvas>
        </div>
    </div>

    <!-- Script que consume la API REST y pinta los gráficos -->
    <script>
    document.addEventListener("DOMContentLoaded", async () => {
        try {
            // Consumimos nuestra propia API REST con fetch
            const response = await fetch('api/arboles.php');
            const result = await response.json();

            if (result.status !== 'success') return;
            const arboles = result.data;

            // Procesar datos para Especies
            const conteoEspecies = {};
            // Procesar datos para Estados
            const conteoEstados = {};

            arboles.forEach(arbol => {
                // Especies
                conteoEspecies[arbol.especie] = (conteoEspecies[arbol.especie] || 0) + 1;
                // Estados
                conteoEstados[arbol.estado] = (conteoEstados[arbol.estado] || 0) + 1;
            });

            // 1. Renderizar Gráfico de Especies (Gráfico de barras)
            const ctxEspecie = document.getElementById('graficoEspecies').getContext('2d');
            new Chart(ctxEspecie, {
                type: 'bar',
                data: {
                    labels: Object.keys(conteoEspecies),
                    datasets: [{
                        label: 'Nº de Árboles',
                        data: Object.values(conteoEspecies),
                        backgroundColor: '#4f46e5',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });

            // 2. Renderizar Gráfico de Estados (Gráfico de Rosca / Doughnut)
            const ctxEstado = document.getElementById('graficoEstados').getContext('2d');
            new Chart(ctxEstado, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(conteoEstados),
                    datasets: [{
                        data: Object.values(conteoEstados),
                        backgroundColor: ['#059669', '#3b82f6', '#f59e0b', '#e11d48', '#8b5cf6'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

        } catch (error) {
            console.error("Error al cargar los datos de la API para el dashboard:", error);
        }
    });
    </script>
</body>
</html>
<?php 
$conn->close(); 
?>
