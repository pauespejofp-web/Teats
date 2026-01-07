<?php
include_once 'models/Oferta.php';
include_once 'models/OfertaDao.php';

class OfertaController {

    public function listar() {
        $ofertas = OfertaDao::getAll();
        include_once 'vista/oferta/listar_ofertas.php';
    }

    public function crearForm() {
        include_once 'vista/oferta/crear_oferta.php';
    }

    public function crear() {
        if (!isset($_POST['nombre'], $_POST['descuento_porcentaje'], $_POST['fecha_inicio'], $_POST['fecha_fin'])) {
            echo "Faltan datos";
            return;
        }
        $oferta = new Oferta();
        $oferta->setNombre($_POST['nombre'])
               ->setDescripcion($_POST['descripcion'] ?? null)
               ->setDescuentoPorcentaje($_POST['descuento_porcentaje'])
               ->setFechaInicio($_POST['fecha_inicio'])
               ->setFechaFin($_POST['fecha_fin'])
               ->setActivo(isset($_POST['activo']) ? 1 : 0);

        $res = OfertaDao::insert($oferta);
        if ($res) {
            header("Location: index.php?controller=oferta&action=listar&msg=creado");
        } else {
            echo "Error al crear la oferta";
        }
    }

    public function editarForm() {
        if (!isset($_GET['id'])) {
            echo "ID no proporcionado";
            return;
        }
        $id = intval($_GET['id']);
        $oferta = OfertaDao::getById($id);
        if (!$oferta) {
            echo "Oferta no encontrada";
            return;
        }
        include_once 'vista/oferta/editar_oferta.php';
    }

    public function editar() {
        if (!isset($_POST['id_oferta'], $_POST['nombre'], $_POST['descuento_porcentaje'], $_POST['fecha_inicio'], $_POST['fecha_fin'])) {
            echo "Faltan datos";
            return;
        }
        $oferta = new Oferta();
        $oferta->setIdOferta($_POST['id_oferta'])
               ->setNombre($_POST['nombre'])
               ->setDescripcion($_POST['descripcion'] ?? null)
               ->setDescuentoPorcentaje($_POST['descuento_porcentaje'])
               ->setFechaInicio($_POST['fecha_inicio'])
               ->setFechaFin($_POST['fecha_fin'])
               ->setActivo(isset($_POST['activo']) ? 1 : 0);

        $res = OfertaDao::update($oferta);
        if ($res) {
            header("Location: index.php?controller=oferta&action=listar&msg=editado");
        } else {
            echo "Error al actualizar la oferta";
        }
    }

    public function eliminar() {
        if (!isset($_GET['id'])) {
            echo "ID no proporcionado";
            return;
        }
        $id = intval($_GET['id']);
        $res = OfertaDao::delete($id);
        if ($res) {
            header("Location: index.php?controller=oferta&action=listar&msg=eliminado");
        } else {
            echo "Error al eliminar la oferta";
        }
    }

    // Aplicar descuento a un importe
    public static function aplicarDescuento($importe, $id_oferta) {
        $oferta = OfertaDao::getById($id_oferta);
        if ($oferta && $oferta->getActivo()) {
            $descuento = ($importe * $oferta->getDescuentoPorcentaje()) / 100;
            return round($importe - $descuento, 2);
        }
        return $importe;
    }
}
?>
