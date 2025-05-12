<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Egresos</title>
    <link rel="stylesheet" href="../assets/css/generales.css">
    <link rel="stylesheet" href="../assets/css/loginAdmin.css">
</head>

<body>
    <header>
        <img src="../assets/img/logo.png" alt="">
        <a href="Registrar_Egreso.php">Registrar Egreso</a>
        <a href="Egresos.php">Egresos</a>
        <a class="a-estadisticas" href="Estadisticas.php">Estadísticas</a>
        <a href="Reporte.php">Reporte</a>
        <a class="a-login-admin" href="loginAdmin.php">Admin</a>
        <p class="derecho_reservado">© 2025 Aprode Perú - Todos los derechos reservados</p>
    </header>
    <main>
        <h1>Iniciar sesión</h1>

        <form id="form-login" method="POST" action="../controller/login_handler.php">
            <label>Usuario:
                <input type="text" name="user" required>
            </label>

            <label>Contraseña:
                <input type="password" name="pass" required>
            </label>

            <button type="submit">Iniciar sesión</button>
        </form>
    </main>

    <script>
        // Función para obtener parámetros de la URL
        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Función para eliminar el parámetro 'error' de la URL
        function removeUrlParameter() {
            const url = new URL(window.location.href);
            url.searchParams.delete('error');
            window.history.replaceState({}, '', url);
        }

        // Verifica si hay un parámetro 'error' en la URL
        const error = getUrlParameter('error');
        if (error) {
            if (error == '1') {
                alert('Usuario o contraseña incorrectos.');
            } else if (error == '2') {
                alert('Usuario no encontrado.');
            }

            // Después de mostrar la alerta, eliminamos el parámetro 'error' de la URL
            removeUrlParameter();
        }
    </script>

</body>

</html>