<?php
require_once __DIR__ . '/../model/UsuarioModel.php';

$usuarioModel = new UsuarioModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'agregar') {
        echo $usuarioModel->agregarUsuario($_POST['user'], $_POST['pass'], $_POST['rol']) ? 'ok' : 'error';
    }

    if ($accion === 'editar') {
        $pass = !empty($_POST['pass']) ? $_POST['pass'] : null;
        echo $usuarioModel->actualizarUsuario($_POST['id'], $_POST['user'], $pass, $_POST['rol']) ? 'ok' : 'error';
    }

    if ($accion === 'eliminar') {
        echo $usuarioModel->eliminarUsuario($_POST['id']) ? 'ok' : 'error';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode($usuarioModel->listarUsuarios());
}
