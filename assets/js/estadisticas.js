document.addEventListener('DOMContentLoaded', () => {
    cargarEstadisticas();
    document.getElementById('ano').addEventListener('change', cargarEstadisticas);
});

let grafico;
let graficoPastel;
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
                        borderColor: '#00ffcc',
                        backgroundColor: 'rgba(0, 255, 204, 0.1)',
                        pointBackgroundColor: '#00ffcc',
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


            const pastelLabels = data.grafico_pastel.map(item => item.tipo);
            const pastelDatos = data.grafico_pastel.map(item => parseFloat(item.total));

            const ctxPastel = document.getElementById('graficoPastel').getContext('2d');
            if (graficoPastel) graficoPastel.destroy();

            graficoPastel = new Chart(ctxPastel, {
                type: 'pie',
                data: {
                    labels: pastelLabels,
                    datasets: [{
                        data: pastelDatos,
                        backgroundColor: ['#00ffcc', '#0077b6', '#90e0ef', '#caf0f8'],
                        borderColor: '#1e1e1e',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    return `${label}: S/. ${value.toFixed(2)}`;
                                }
                            }
                        },
                        legend: {
                            labels: {
                                color: '#000000'
                            }
                        }
                    }
                }
            });


            const { actual, anterior } = data.comparacion_anual;

            const variacion = anterior > 0 ? ((actual - anterior) / anterior) * 100 : 0;
            const aumento = variacion >= 0;

            const ctxDonut = document.getElementById('gráficoDonut').getContext('2d');
            if (donutChart) donutChart.destroy();

            donutChart = new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [Math.abs(variacion), 100 - Math.abs(variacion)],
                        backgroundColor: [
                            aumento ? '#00ffcc' : '#ff4d4d',
                            '#d8d8d8'
                        ],
                        borderWidth: 0,
                        cutout: '70%'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function () {
                                    return `${aumento ? '+' : '-'}${Math.abs(variacion).toFixed(1)}% respecto al ${parseInt(anoSeleccionado) - 1}`;
                                }
                            }
                        },
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: `${aumento ? '+' : '-'}${Math.abs(variacion).toFixed(1)}% ${aumento ? 'más' : 'menos'} que en ${parseInt(anoSeleccionado) - 1}`,
                            position: 'bottom',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            color: aumento ? '#00ffcc' : '#ff4d4d'
                        }
                    }
                }
            });

        })
        .catch(error => {
            console.error('Error al cargar estadísticas:', error);
        });
}
