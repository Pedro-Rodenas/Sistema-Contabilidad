document.addEventListener('DOMContentLoaded', () => {
    cargarEstadisticas();
    document.getElementById('ano').addEventListener('change', cargarEstadisticas);
});

let grafico;
let donutChart;

function cargarEstadisticas() {
    const anoSeleccionado = document.getElementById('ano').value;

    fetch(`../controller/EstadisticasController.php?ano=${anoSeleccionado}`)
        .then(response => response.json())
        .then(data => {

            document.getElementById('mes-mas-gasto').textContent = data.mes_mas_gasto || '---';
            document.getElementById('producto-mas-caro').textContent = data.producto_mas_caro || '---';
            document.getElementById('mes-menos-gasto').textContent = data.mes_menos_gasto || '---';

            const meses = data.grafico_lineas.map(item => item.mes);
            const totales = data.grafico_lineas.map(item => item.total);

            const ctx = document.getElementById('graficoLineas').getContext('2d');
            if (grafico) grafico.destroy();

            grafico = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Total de Egresos por Mes',
                        data: totales,
                        borderColor: '#00b0ff',
                        backgroundColor: 'rgba(0, 176, 255, 0.1)',
                        pointBackgroundColor: '#00b0ff',
                        pointBorderColor: '#2c3e50',
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const valor = context.parsed.y;
                                    return `S/. ${Number(valor).toFixed(2)}`;
                                }
                            }
                        },
                        legend: {
                            labels: {
                                color: '#000000'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: '#000000' }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#000000' },
                            title: {
                                display: true,
                                text: 'Soles (S/.)',
                                color: '#000000'
                            }
                        }
                    },
                    animation: {
                        duration: 300,
                        easing: 'easeOutQuart'
                    }
                }
            });

            // Datos para el gráfico de dona
            const donutLabels = data.grafico_pastel.map(item => item.tipo);
            const donutDatos = data.grafico_pastel.map(item => parseFloat(item.total));

            // Crear degradados para el gráfico de dona
            const ctxDonut = document.getElementById('gráficoDonut').getContext('2d');
            if (donutChart) donutChart.destroy();

            // Degradados más serios y tecnológicos
            const gradient1 = ctxDonut.createLinearGradient(0, 0, 0, 200);
            gradient1.addColorStop(0, '#00b0ff');  // Verde agua
            gradient1.addColorStop(1, '#0052cc');  // Azul oscuro

            const gradient2 = ctxDonut.createLinearGradient(0, 0, 0, 200);
            gradient2.addColorStop(0, '#7f8c8d');  // Gris oscuro
            gradient2.addColorStop(1, '#95a5a6');  // Gris más claro

            const gradient3 = ctxDonut.createLinearGradient(0, 0, 0, 200);
            gradient3.addColorStop(0, '#16a085');  // Verde fuerte
            gradient3.addColorStop(1, '#1abc9c');  // Verde menta

            const gradient4 = ctxDonut.createLinearGradient(0, 0, 0, 200);
            gradient4.addColorStop(0, '#34495e');  // Azul oscuro
            gradient4.addColorStop(1, '#2c3e50');  // Azul grisáceo

            const gradient5 = ctxDonut.createLinearGradient(0, 0, 0, 200);
            gradient5.addColorStop(0, '#2980b9');  // Azul brillante
            gradient5.addColorStop(1, '#3498db');  // Azul más claro

            donutChart = new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: donutLabels,
                    datasets: [{
                        data: donutDatos,
                        backgroundColor: [gradient1, gradient2, gradient3, gradient4, gradient5],
                        borderWidth: 0,
                        cutout: '70%' // Crea el estilo de dona
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: S/. ${value.toFixed(2)}`;
                                }
                            }
                        },
                        legend: {
                            labels: {
                                color: '#000000'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Distribución de Egresos',
                            position: 'bottom',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            color: '#000000'
                        }
                    }
                }
            });

        })
        .catch(error => {
            console.error('Error al cargar estadísticas:', error);
        });
}
