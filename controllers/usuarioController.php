<?php

include_once 'models/Usuario/Usuario.php';
include_once 'models/Usuario/UsuarioDAO.php';

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
        if (!isset($_POST['email'], $_POST['password'], $_POST['nombre'])) {
            echo "Faltan datos";
            return;
        }
        $usuario = new Usuario();
        $usuario->setNombre($_POST['nombre']);
        $usuario->setEmail($_POST['email']);
        $usuario->setContraseña(password_hash($_POST['password'], PASSWORD_BCRYPT));
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
        if (!isset($_POST['email'], $_POST['password'])) {
            header("Location: index.php?controller=usuario&action=loginForm&error=empty");
            exit;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $usuario = UsuarioDao::getByEmail($email);

        if (!$usuario) {
            header("Location: index.php?controller=usuario&action=loginForm&error=user");
            exit;
        }

        if (password_verify($password, $usuario->getContraseña())) {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['usuario'] = $usuario;
            header("Location: index.php");
            exit;
        } else {
            header("Location: index.php?controller=usuario&action=loginForm&error=pass");
            exit;
        }
    }


    //================================
    // LOGOUT
    //================================
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

        // si hay nueva contraseña → hashearla
        $nuevaPass = null;
        if (!empty($_POST['password'])) {
            $nuevaPass = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        // ejecutar actualización
        if ($nuevaPass) {
            $usuario->setContraseña($nuevaPass);
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
                    . urlencode($usuario->getIdUsuario()));
            exit;
        } else {
            echo "Error al eliminar usuario.";
        }
    }
}