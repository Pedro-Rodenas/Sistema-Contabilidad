<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Contabilidad</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="manifest" href="manifest.json">
</head>

<body>
    <main class="login-container">
        <div class="login-box">
            <div class="login-image">
                <img src="assets/img/img-login.jpg" alt="Logo de la empresa">
            </div>
            <div class="login-form">
                <h2>Iniciar sesión</h2>
                <form id="form-login" method="POST" action="controller/login_user.php">
                    <label>Usuario:</label>
                    <input autocomplete="off" type="text" name="user" required>
                    <div class="error-message" id="user-error"></div>

                    <label>Contraseña:</label>
                    <input autocomplete="off" type="password" name="pass" required>
                    <div class="error-message" id="pass-error"></div>

                    <div class="error-message" id="login-error"></div>

                    <button type="submit">Iniciar sesión</button>
                </form>
            </div>
        </div>
    </main>
    <script>
        const loginErrorFlag = <?= isset($_GET['error']) && $_GET['error'] == 1 ? 'true' : 'false' ?>;
    </script>
    <script src="assets/js/validacion_index.js"></script>
</body>


</html>