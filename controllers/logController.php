<?php
include_once 'models/Log/Log.php';
include_once 'models/Log/LogDao.php';

class LogController {

    public static function registrar($idUsuario, $accion, $descripcion) {
        $log = new Log();
        $log->setIdUsuario($idUsuario)
            ->setAccion($accion)
            ->setDescripcion($descripcion)
            ->setFechaHora(date('Y-m-d H:i:s'))
            ->setIp($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');

        LogDao::insert($log);
    }
}
?>
