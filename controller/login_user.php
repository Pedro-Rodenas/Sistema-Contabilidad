<?php
session_start();
require_once __DIR__ . '/../model/UsuarioModel.php';

$user = $_POST['user'];
$pass = $_POST['pass'];

$usuarioModel = new UsuarioModel();
$usuario = $usuarioModel->obtenerUsuarioPorNombre($user);

if ($usuario && $usuario['pass'] === $pass) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_rol'] = $usuario['rol'];

    if ($usuario['rol'] === 'admin') {
        header('Location: ../view/Registrar_Egreso.php');
    } elseif ($usuario['rol'] === 'usuario') {
        header('Location: ../view/Registrar_Egreso.php');
    } else {
        header('Location: ../index.php');
    }
    exit;
} else {
    header('Location: ../index.php?error=1');
    exit;
}
