<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Contabilidad</title>
    <link rel="stylesheet" href="assets/css/index.css">
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
                    <input type="text" name="user" required>

                    <label>Contraseña:</label>
                    <input type="password" name="pass" required>

                    <button type="submit">Iniciar sesión</button>
                </form>
            </div>
        </div>
    </main>
</body>


</html>