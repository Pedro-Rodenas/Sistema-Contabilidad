document.addEventListener('DOMContentLoaded', () => {
    const añoSelect = document.getElementById('year');
    const mesSelect = document.getElementById('month');
    const tablaBody = document.getElementById('tabla-body');
    const formEditar = document.getElementById('form-editar');
    const modal = document.getElementById('modal');

    const mostrarMensaje = (texto, tipo = 'success') => {
        const toast = document.createElement('div');
        toast.textContent = texto;
        toast.className = `toast toast-${tipo}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    };

    const cargarEgresos = () => {
        const year = añoSelect.value;
        const mes = mesSelect.value;
        if (!year || !mes) return;

        fetch('../controller/TablaEgresosController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `year=${year}&mes=${mes}`
        })
            .then(res => res.ok ? res.json() : Promise.reject('Error al cargar los egresos'))
            .then(data => {
                tablaBody.innerHTML = '';
                if (!data.length) {
                    tablaBody.innerHTML = '<tr><td colspan="8">No hay egresos en este mes.</td></tr>';
                    document.querySelector('.totales-egresos').style.display = 'block';
                    return;
                }


                data.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));
                const fragment = document.createDocumentFragment();
                let totalPrecio = 0;
                let totalIGV = 0;
                let totalConIGV = 0;

                data.forEach(row => {
                    const tr = document.createElement('tr');
                    if (row.estado === 'anulado') tr.classList.add('fila-inactiva');
                    const precio = parseFloat(row.precio) || 0;
                    const igv = parseFloat(row.igv) || 0;
                    const subtotal = precio + igv;
                    const descuentoPorcentaje = parseFloat(row.descuento) || 0;
                    const montoDescuento = subtotal * (descuentoPorcentaje / 100);
                    const descuento = parseFloat(row.descuento) || 0;
                    const total = subtotal - montoDescuento;

                    totalPrecio += precio;
                    totalIGV += igv;
                    totalConIGV += total;

                    tr.innerHTML = `
                        <td>${row.fecha}</td>
                        <td>${row.tipo_factura}</td>
                        <td>${row.tipo_egreso}</td>
                        <td>${row.nombre}</td>
                        <td>${row.cantidad ?? 'N/A'}</td>
                        <td>S/. ${precio.toFixed(2)}</td>
                        <td>S/. ${igv.toFixed(2)}</td>
                        <td>${descuentoPorcentaje.toFixed(2)}%</td>
                        <td><strong>S/. ${total.toFixed(2)}</strong></td>
                        <td>
                            <button class="btn-editar" onclick='abrirModal(${JSON.stringify(row)})'>Editar</button>
                            <button class="btn-eliminar" data-id="${row.id}" data-tipo="${row.tipo_egreso}">Eliminar</button>
                        </td>
                    `;

                    fragment.appendChild(tr);
                });

                tablaBody.appendChild(fragment);
                document.getElementById('total-precio').textContent = `S/. ${totalPrecio.toFixed(2)}`;
                document.getElementById('total-igv').textContent = `S/. ${totalIGV.toFixed(2)}`;
                document.getElementById('total-con-igv').textContent = `S/. ${totalConIGV.toFixed(2)}`;
                agregarListenersEliminar();
            })
            .catch(err => console.error('Error al cargar los egresos:', err));
    };

    const agregarListenersEliminar = () => {
        tablaBody.querySelectorAll('.btn-eliminar').forEach(btn => {
            btn.addEventListener('click', () => {
                const { id, tipo } = btn.dataset;

                if (!confirm('¿Deseas eliminar este egreso? Esta acción no se puede deshacer.')) return;

                fetch('../controller/EliminarEgresoController.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${id}&tipo=${tipo}`
                })
                    .then(res => res.text())
                    .then(msg => {
                        if (msg.includes('correctamente')) {
                            cargarEgresos();
                        } else {
                            mostrarMensaje('No se pudo eliminar: ' + msg, 'error');
                        }
                    })
                    .catch(err => {
                        console.error('Error al eliminar:', err);
                        mostrarMensaje('Error al eliminar el egreso.', 'error');
                    });
            });
        });
    };
    const EditarOpcionesMeses = () => {
        const selectedYear = parseInt(añoSelect.value);
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth() + 1;

        Array.from(mesSelect.options).forEach((option, index) => {
            option.disabled = selectedYear === currentYear ? index + 1 > currentMonth : false;
        });
    };

    /* Modal para editar egreso */
    window.abrirModal = (egreso) => {
        document.getElementById('editar-id').value = egreso.id;
        document.getElementById('editar-nombre').value = egreso.nombre;
        document.getElementById('editar-cantidad').value = egreso.cantidad ?? '';
        document.getElementById('editar-precio').value = egreso.precio;
        document.getElementById('editar-igv').value = egreso.igv ?? '';
        document.getElementById('editar-origen').value = egreso.tipo_egreso;
        modal.style.display = 'block';
    };

    /* Modal para cerrar el editar egreso */
    window.cerrarModal = () => modal.style.display = 'none';

    if (formEditar) {
        formEditar.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(formEditar);

            fetch('../controller/EditarEgresoController.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.text())
                .then(msg => {
                    mostrarMensaje(msg);
                    cerrarModal();
                    cargarEgresos();
                })
                .catch(err => console.error('Error al editar:', err));
        });
    }

    añoSelect.addEventListener('change', () => {
        EditarOpcionesMeses();
        cargarEgresos();
    });

    mesSelect.addEventListener('change', cargarEgresos);

    EditarOpcionesMeses();
    cargarEgresos();
});
