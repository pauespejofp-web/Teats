<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../database/database.php';
include_once __DIR__ . '/../models/usuario/usuario.php';
include_once __DIR__ . '/../models/usuario/UsuarioDAO.php';


$metodo = $_SERVER['REQUEST_METHOD'];





switch ($metodo) {



    //GET:

    case 'GET':
        if (isset($_GET['id'])) {
            $usuario = UsuarioDao::getById(intval($_GET['id']));
            if ($usuario) {
                $data = [
                    'id_usuario' => $usuario->getIdUsuario(),
                    'nombre' => $usuario->getNombre(),
                    'email' => $usuario->getEmail()
                ];
                echo json_encode(['estado' => 'Exito', 'data' => $data]);
            } else {
                http_response_code(404);
                echo json_encode(['estado' => 'Fallido', 'data' => 'Usuario no encontrado']);
            }
        } else {
            $usuarios = UsuarioDao::getAll();
            $lista = [];
            foreach ($usuarios as $u) {
                $lista[] = [
                    'id_usuario' => $u->getIdUsuario(),
                    'nombre' => $u->getNombre(),
                    'email' => $u->getEmail()
                ];
            }
            echo json_encode(['estado' => 'Exito', 'data' => $lista]);
        }
        break;




    //POST:



    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['nombre'], $data['email'], $data['password'])) {
            $usuario = new Usuario();
            $usuario->setnombre($data['nombre']);
            $usuario->setEmail($data['email']);
            $usuario->setContraseña(password_hash($data['password'], PASSWORD_BCRYPT));

            $resultado = UsuarioDao::insert($usuario);

            if ($resultado) {

                echo json_encode(['estado' => 'Exito']);
            } else {

                echo json_encode(['estado' => 'Fallido']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['estado' => 'Fallido', 'data' => 'Faltan datos']);
        }
        break;




    //PUT:



    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id_usuario'], $data['nombre'], $data['email'])) {
            $usuario = UsuarioDao::getById(intval($data['id_usuario']));
            if ($usuario) {
                $usuario->setNombre($data['nombre']);
                $usuario->setEmail($data['email']);
                if (!empty($data['password'])) {
                    $usuario->setContraseña(password_hash($data['password'], PASSWORD_BCRYPT));
                }
                $resultado = UsuarioDao::editar($usuario);
                if ($resultado) {
                    echo json_encode(['estado' => 'Exito']);
                } else {
                    echo json_encode(['estado' => 'Fallido']);
                }
            } else {
                http_response_code(404);
                echo json_encode(['estado' => 'Fallido', 'data' => 'Usuario no encontrado']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['estado' => 'Fallido', 'data' => 'Faltan datos']);
        }
        break;










    //DELETE:


    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['id_usuario'])) {
            $usuario = UsuarioDao::getById(intval($data['id_usuario']));

            if ($usuario) {
                $resultado = UsuarioDao::eliminar($usuario);

                if ($resultado) {
                    echo json_encode(['estado' => 'Exito']);
                } else {
                    echo json_encode(['estado' => 'Fallido']);
                }
            } else {
                http_response_code(404);
                echo json_encode(['estado' => 'Fallido', 'data' => 'Usuario no encontrado']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['estado' => 'Fallido', 'data' => 'Falta id_usuario']);
        }
        break;
}
