<?php
include_once __DIR__ . 'models/Oferta.php';
include_once __DIR__ . '/../../database/database.php';

class OfertaDao {

    public static function getAll() {
        $con = DataBase::connect();
        $result = $con->query("SELECT * FROM oferta ORDER BY id_oferta DESC");
        $lista = [];
        while ($row = $result->fetch_assoc()) {
            $oferta = new Oferta();
            $oferta->setIdOferta($row['id_oferta'])
                   ->setNombre($row['nombre'])
                   ->setDescripcion($row['descripcion'])
                   ->setDescuentoPorcentaje($row['descuento_porcentaje'])
                   ->setFechaInicio($row['fecha_inicio'])
                   ->setFechaFin($row['fecha_fin'])
                   ->setActivo($row['activo']);
            $lista[] = $oferta;
        }
        $con->close();
        return $lista;
    }

    public static function getById($id) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM oferta WHERE id_oferta = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $oferta = null;
        if ($row = $result->fetch_assoc()) {
            $oferta = new Oferta();
            $oferta->setIdOferta($row['id_oferta'])
                   ->setNombre($row['nombre'])
                   ->setDescripcion($row['descripcion'])
                   ->setDescuentoPorcentaje($row['descuento_porcentaje'])
                   ->setFechaInicio($row['fecha_inicio'])
                   ->setFechaFin($row['fecha_fin'])
                   ->setActivo($row['activo']);
        }
        $con->close();
        return $oferta;
    }

    public static function insert(Oferta $oferta) {
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO oferta(nombre, descripcion, descuento_porcentaje, fecha_inicio, fecha_fin, activo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssdssi",
            $oferta->getNombre(),
            $oferta->getDescripcion(),
            $oferta->getDescuentoPorcentaje(),
            $oferta->getFechaInicio(),
            $oferta->getFechaFin(),
            $oferta->getActivo()
        );
        $res = $stmt->execute();
        $con->close();
        return $res;
    }

    public static function update(Oferta $oferta) {
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE oferta SET nombre=?, descripcion=?, descuento_porcentaje=?, fecha_inicio=?, fecha_fin=?, activo=? WHERE id_oferta=?");
        $stmt->bind_param(
            "ssdssii",
            $oferta->getNombre(),
            $oferta->getDescripcion(),
            $oferta->getDescuentoPorcentaje(),
            $oferta->getFechaInicio(),
            $oferta->getFechaFin(),
            $oferta->getActivo(),
            $oferta->getIdOferta()
        );
        $res = $stmt->execute();
        $con->close();
        return $res;
    }

    public static function delete($id) {
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM oferta WHERE id_oferta = ?");
        $stmt->bind_param("i", $id);
        $res = $stmt->execute();
        $con->close();
        return $res;
    }

    public static function getActiveOffers() {
        $today = date("Y-m-d");
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM oferta WHERE activo = 1 AND fecha_inicio <= ? AND fecha_fin >= ?");
        $stmt->bind_param("ss", $today, $today);
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        while ($row = $result->fetch_assoc()) {
            $oferta = new Oferta();
            $oferta->setIdOferta($row['id_oferta'])
                   ->setNombre($row['nombre'])
                   ->setDescripcion($row['descripcion'])
                   ->setDescuentoPorcentaje($row['descuento_porcentaje'])
                   ->setFechaInicio($row['fecha_inicio'])
                   ->setFechaFin($row['fecha_fin'])
                   ->setActivo($row['activo']);
            $lista[] = $oferta;
        }
        $con->close();
        return $lista;
    }
}
?>
