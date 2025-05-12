document.addEventListener('DOMContentLoaded', () => {
    const botonMes = document.getElementById('sacar-reporte-mes');
    const botonAno = document.getElementById('sacar-reporte-ano');

    botonMes.addEventListener('click', () => {
        const mes = document.getElementById('mes').value;
        const ano = document.getElementById('ano').value;

        if (!mes || !ano) {
            alert("Por favor selecciona un mes y un año.");
            return;
        }

        // Redirige al PHP que genera el Excel por mes
        window.location.href = `../controller/ReporteController.php?accion=mes&mes=${mes}&ano=${ano}`;
    });

    botonAno.addEventListener('click', () => {
        const ano = document.getElementById('ano').value;

        if (!ano) {
            alert("Por favor selecciona un año.");
            return;
        }

        // Redirige al PHP que genera el Excel por año
        window.location.href = `../controller/ReporteController.php?accion=ano&ano=${ano}`;
    });
});
