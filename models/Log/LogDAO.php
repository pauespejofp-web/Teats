<?php
include_once __DIR__ . '/../models/Log.php';
include_once __DIR__ . '/../database/database.php';

class LogDao {

    public static function insert(Log $log) {
        $con = DataBase::connect();
        $stmt = $con->prepare(
            "INSERT INTO Log(id_usuario, accion, descripcion, ip) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "isss",
            $log->getIdUsuario(),
            $log->getAccion(),
            $log->getDescripcion(),
            $log->getIp()
        );
        $stmt->execute();
        $con->close();
    }

    public static function getByUser($id_usuario) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM Log WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        while ($l = $result->fetch_object('Log')) {
            $lista[] = $l;
        }
        $con->close();
        return $lista;
    }
}
?>
