<?php
include_once __DIR__ . '/Log.php';
include_once __DIR__ . '/../../database/database.php';

class LogDao {

    public static function insert(Log $log) {
        $con = DataBase::connect();
        $stmt = $con->prepare(
            "INSERT INTO log(id_usuario, accion, descripcion, fecha_hora, ip) VALUES (?, ?, ?, ?, ?)"
        );

        $fecha = $log->getFechaHora() ?? date('Y-m-d H:i:s');
        $ip = $log->getIp() ?? ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');

        $stmt->bind_param(
            "issss",
            $log->getIdUsuario(),
            $log->getAccion(),
            $log->getDescripcion(),
            $fecha,
            $ip
        );

        $stmt->execute();
        $stmt->close();
        $con->close();
    }

    public static function getByUser($id_usuario) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM log WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        while ($l = $result->fetch_object('Log')) {
            $lista[] = $l;
        }
        $stmt->close();
        $con->close();
        return $lista;
    }
}
?>
