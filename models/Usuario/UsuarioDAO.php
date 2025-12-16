<?php
include_once __DIR__ . '/Usuario.php';
include_once __DIR__ . '/../../database/database.php';


class UsuarioDao
{

    public static function getById($id)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $usuario = $stmt->get_result()->fetch_object('Usuario');
        $con->close();
        return $usuario;
    }

    public static function getAll()
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario");
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        while ($u = $result->fetch_object('Usuario')) {
            $lista[] = $u;
        }
        $con->close();
        return $lista;
    }


    public static function insert($usuario)
    {

        $existe = self::getByEmail($usuario->getEmail());
        if ($existe) {
            return false;
        }

        $con = DataBase::connect();

        $nombre = $usuario->getNombre();
        $email = $usuario->getEmail();
        $pass = $usuario->getContraseña();

        $stmt = $con->prepare("INSERT INTO usuario (nombre, email, contraseña) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $pass);
        $resultado = $stmt->execute();

        $stmt->close();
        $con->close();
        return $resultado;
    }

    public static function getByEmail($email)
    {
        $con = DataBase::connect();

        $stmt = $con->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        $usuario = $result->fetch_object('Usuario');

        $con->close();
        return $usuario;
    }
    public static function editarSinPass(Usuario $usuario)
    {
        $con = DataBase::connect();

        $stmt = $con->prepare(
            "UPDATE usuario SET nombre = ?, email = ?
         WHERE id_usuario = ?"
        );

        $stmt->bind_param(
            "ssi",
            $usuario->getNombre(),
            $usuario->getEmail(),
            $usuario->getIdUsuario()
        );

        $resultado = $stmt->execute();
        $stmt->close();
        $con->close();
        return $resultado;
    }
    public static function editarConPass(Usuario $usuario)
    {
        $con = DataBase::connect();

        $stmt = $con->prepare(
            "UPDATE usuario SET nombre = ?, email = ?, contraseña = ?
         WHERE id_usuario = ?"
        );

        $stmt->bind_param(
            "sssi",
            $usuario->getNombre(),
            $usuario->getEmail(),
            $usuario->getContraseña(),
            $usuario->getIdUsuario()
        );

        $resultado = $stmt->execute();
        $stmt->close();
        $con->close();
        return $resultado;
    }
    public static function editar(Usuario $usuario)
    {
        $con = DataBase::connect();

        $stmt = $con->prepare(
            "UPDATE usuario 
         SET nombre = ?, email = ?, contraseña = ?
         WHERE id_usuario = ?"
        );

        $nombre = $usuario->getNombre();
        $email = $usuario->getEmail();
        $contraseña = $usuario->getContraseña();
        $id_usuario = $usuario->getIdUsuario();

        $stmt->bind_param("sssi", $nombre, $email, $contraseña, $id_usuario);


        $resultado = $stmt->execute();

        $stmt->close();
        $con->close();

        return $resultado;
    }
    public static function eliminar(Usuario $usuario)
    {
        $con = DataBase::connect();

        $stmt = $con->prepare(
            "DELETE FROM usuario WHERE id_usuario = ?"
        );

        $id = $usuario->getIdUsuario();
        $stmt->bind_param("i", $id);


        $resultado = $stmt->execute();

        $stmt->close();
        $con->close();

        return $resultado;
    }
}
