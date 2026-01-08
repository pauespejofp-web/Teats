<?php

include_once 'models/usuario/usuario.php';
include_once 'models/usuario/UsuarioDAO.php';

class UsuarioController
{

    public function registrarForm()
    {
        include_once 'vista/usuario/registrar.php';
    }

    public function loginForm()
    {
        include_once 'vista/usuario/login.php';
    }

    public function registrar()
    {
        if (!isset($_POST['email'], $_POST['contraseña'], $_POST['nombre'])) {
            echo "Faltan datos";
            return;
        }
        $usuario = new Usuario();
        $usuario->setNombre($_POST['nombre']);
        $usuario->setEmail($_POST['email']);
        $usuario->setcontraseña(password_hash($_POST['contraseña'], PASSWORD_BCRYPT));
        $resultado = UsuarioDao::insert($usuario);
        if ($resultado) {
            header("Location: /Modelo-Vista-Controlador/index.php?controller=usuario&action=loginForm&msg=registrado");
            exit;
        } else {
            echo "El email ya está registrado o ocurrió un error";
        }
    }


    public function login()
    {
        if (!isset($_POST['email'], $_POST['contraseña'])) {
            header("Location: index.php?controller=usuario&action=loginForm&error=empty");
            exit;
        }

        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'];

        $usuario = UsuarioDao::getByEmail($email);

        if (!$usuario) {
            header("Location: index.php?controller=usuario&action=loginForm&error=user");
            exit;
        }

        if (password_verify($contraseña, $usuario->getcontraseña())) {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['user_id'] = $usuario->getIdUsuario();
            $_SESSION['user_name'] = $usuario->getNombre();
            $_SESSION['user_rol'] = $usuario->getIdRol();



            header("Location: index.php");
            exit;
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        header("Location: /Modelo-Vista-Controlador/index.php");
    }

    public function actualizar()
    {
        if (!isset($_POST['id_usuario'], $_POST['nombre'], $_POST['email'])) {
            echo "Faltan datos para actualizar.";
            return;
        }

        $usuario = new Usuario();
        $usuario->setIdUsuario($_POST['id_usuario']);
        $usuario->setNombre($_POST['nombre']);
        $usuario->setEmail($_POST['email']);

        $nuevaPass = null;
        if (!empty($_POST['contraseña'])) {
            $nuevaPass = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
        }

        if ($nuevaPass) {
            $usuario->setcontraseña($nuevaPass);
            $resultado = UsuarioDao::editarConPass($usuario);
        } else {
            $resultado = UsuarioDao::editarSinPass($usuario);
        }

        if ($resultado) {
            header(
                "Location: index.php?controller=usuario&action=panel&msg=edit_ok&id="
                    . urlencode($usuario->getIdUsuario())
                    . "&nombre="
                    . urlencode($usuario->getNombre())
            );
            exit;
        } else {
            echo "Error al actualizar usuario.";
        }
    }
    public function editar()
    {
        if (!isset($_GET['id'])) {
            echo "ID no proporcionado";
            return;
        }

        $id = intval($_GET['id']);
        $usuario = UsuarioDao::getById($id);

        if (!$usuario) {
            echo "Usuario no encontrado";
            return;
        }

        include_once 'vista/usuario/editar_usuario.php';
    }
    public function panel()
    {
        $usuarios = UsuarioDao::getAll();

        $msg = isset($_GET['msg']) ? $_GET['msg'] : null;

        include_once 'vista/admin/Panel_administracion/panel_administracion.php';
    }
    public function eliminar()
    {
        if (!isset($_GET['id'])) {
            echo "No hay ID proporcionado";
            return;
        }

        $id = intval($_GET['id']);
        $usuario = UsuarioDao::getById($id);

        if (!$usuario) {
            echo "Usuario no encontrado";
            return;
        }

        $resultado = UsuarioDao::eliminar($usuario);

        if ($resultado) {
            header(
                "Location: index.php?controller=usuario&action=panel&msg=delete_ok&id="
                    . urlencode($usuario->getIdUsuario())
            );
            exit;
        } else {
            echo "Error al eliminar usuario.";
        }
    }
}
