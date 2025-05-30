document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-usuario');
    const tbody = document.getElementById('tbody-usuarios');

    const cargarUsuarios = () => {
        fetch('../controller/UsuarioController.php')
            .then(res => res.json())
            .then(data => {
                tbody.innerHTML = '';
                data.forEach(u => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${u.id}</td>
                            <td>${u.user}</td>
                            <td>${u.rol}</td>
                            <td>
                                <button onclick="editar(${u.id}, '${u.user}', '${u.pass}', '${u.rol}')">Editar</button>
                                <button onclick="eliminar(${u.id})">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
            });
    };

    form.addEventListener('submit', e => {
        e.preventDefault();
        const data = new FormData(form);

        fetch('../controller/UsuarioController.php', {
            method: 'POST',
            body: data
        })
            .then(res => res.text())
            .then(msg => {
                if (msg === 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado correctamente',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    form.reset();
                    form.querySelector('[name=accion]').value = 'agregar';
                    cargarUsuarios();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al guardar',
                        text: msg
                    });
                }
            });
    });

    window.editar = (id, user, pass, rol) => {
        form.id.value = id;
        form.user.value = user;
        form.pass.value = pass;
        form.rol.value = rol;
        form.accion.value = 'editar';
    };

    window.eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const data = new FormData();
                data.append('accion', 'eliminar');
                data.append('id', id);

                fetch('../controller/UsuarioController.php', {
                    method: 'POST',
                    body: data
                })
                    .then(res => res.text())
                    .then(msg => {
                        if (msg === 'ok') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado correctamente',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            cargarUsuarios();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al eliminar',
                                text: msg
                            });
                        }
                    });
            }
        });
    };

    cargarUsuarios();
});

function togglePassword() {
    const input = document.getElementById('input-pass');
    input.type = input.type === 'password' ? 'text' : 'password';
}
