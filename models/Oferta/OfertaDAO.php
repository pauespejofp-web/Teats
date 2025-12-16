<?php
include_once __DIR__ . '/../models/Oferta.php';
include_once __DIR__ . '/../database/database.php';

class OfertaDao {

    public static function getById($id) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM Ofertas WHERE id_oferta = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $oferta = $stmt->get_result()->fetch_object('Oferta');
        $con->close();
        return $oferta;
    }

    public static function getAll() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM Ofertas");
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        while ($o = $result->fetch_object('Oferta')) {
            $lista[] = $o;
        }
        $con->close();
        return $lista;
    }

    public static function insert(Oferta $o) {
        $con = DataBase::connect();
        $stmt = $con->prepare(
            "INSERT INTO Ofertas(nombre, descripcion, descuento_porcentaje, fecha_inicio, fecha_fin, activo)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssdssi",
            $o->getNombre(),
            $o->getDescripcion(),
            $o->getDescuentoPorcentaje(),
            $o->getFechaInicio(),
            $o->getFechaFin(),
            $o->getActivo()
        );
        $stmt->execute();
        $con->close();
    }
}
?>
