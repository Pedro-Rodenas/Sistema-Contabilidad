<?php
session_start();
require_once __DIR__ . '/../model/UsuarioModel.php';

// Obtén los datos enviados por POST
$user = $_POST['user'];
$pass = $_POST['pass'];

// Verificamos si el usuario existe y obtenemos los datos
$usuarioModel = new UsuarioModel();
$usuario = $usuarioModel->obtenerUsuarioPorNombre($user);

if ($usuario) {
    // Comparamos las contraseñas
    if ($usuario['rol'] === 'admin' && $usuario['pass'] === $pass) {
        // Si el usuario es admin y la contraseña es correcta, iniciar sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_rol'] = $usuario['rol'];

        // Redirigir a la página de administración o panel principal
        header('Location: ../view/usuarios.php');
        exit;
    } else {
        // Si el usuario no tiene rol de admin o la contraseña es incorrecta
        header('Location: ../view/loginAdmin.php?error=1');
        exit;
    }
} else {
    // Si el usuario no existe
    header('Location: ../view/loginAdmin.php?error=2');
    exit;
}
