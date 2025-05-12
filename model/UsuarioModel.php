<?php
require_once __DIR__ . '/../config/database.php';

class UsuarioModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function listarUsuarios()
    {
        $stmt = $this->conn->prepare("SELECT id, user, pass, rol FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function agregarUsuario($user, $pass, $rol)
    {
        // Aquí no usamos password_hash, la contraseña se guarda tal cual como texto plano
        $stmt = $this->conn->prepare("INSERT INTO usuarios (user, pass, rol) VALUES (:user, :pass, :rol)");
        return $stmt->execute([':user' => $user, ':pass' => $pass, ':rol' => $rol]);
    }

    public function actualizarUsuario($id, $user, $pass = null, $rol)
    {
        if ($pass) {
            // Aquí no usamos password_hash, se guarda la contraseña tal cual
            $stmt = $this->conn->prepare("UPDATE usuarios SET user = :user, pass = :pass, rol = :rol WHERE id = :id");
            return $stmt->execute([':user' => $user, ':pass' => $pass, ':rol' => $rol, ':id' => $id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE usuarios SET user = :user, rol = :rol WHERE id = :id");
            return $stmt->execute([':user' => $user, ':rol' => $rol, ':id' => $id]);
        }
    }

    public function eliminarUsuario($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function obtenerUsuarioPorNombre($user)
    {
        $stmt = $this->conn->prepare("SELECT id, user, pass, rol FROM usuarios WHERE user = :user");
        $stmt->execute([':user' => $user]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
}
