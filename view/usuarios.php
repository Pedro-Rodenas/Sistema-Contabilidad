<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: Registrar_Egreso.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios del Sistema</title>
    <link rel="stylesheet" href="../assets/css/generales.css">
    <link rel="stylesheet" href="../assets/css/usuarios.css">
</head>

<body>
    <header>
        <div class="logo-container">
            <img src="../assets/img/logo.png" alt="Logo Aprode Perú">
        </div>

        <nav class="nav-links">
            <a href="Registrar_Egreso.php">Registrar Egreso</a>
            <a href="Egresos.php">Egresos</a>
            <a href="Estadisticas.php">Estadísticas</a>
            <a href="Reporte.php">Reporte</a>
            <a href="usuarios.php">Administración</a>
        </nav>

        <div class="footer-section">
            <p class="derecho_reservado">© 2025 Aprode Perú<br>Todos los derechos reservados</p>
            <a class="logout-button" href="../controller/logout.php">Cerrar sesión</a>
        </div>
    </header>

    <main>
        <h1>Usuarios del Sistema</h1>

        <form id="form-usuario">
            <input type="hidden" name="accion" value="agregar">
            <input type="hidden" name="id" id="id">

            <label>Usuario:
                <input autocomplete="off" type="text" name="user" required>
            </label>

            <label>Contraseña:
                <div class="input-password">
                    <input autocomplete="off" type="password" name="pass" id="input-pass" autocomplete="new-password" required>
                    <span class="toggle-pass" onclick="togglePassword()">👁️</span>
                </div>
            </label>

            <label>Rol:
                <select name="rol">
                    <option value="admin">Admin</option>
                    <option value="usuario">Usuario</option>
                </select>
            </label>

            <button type="submit">Guardar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbody-usuarios"></tbody>
        </table>
    </main>

    <script src="../assets/js/usuarios.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>