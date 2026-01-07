<?php
include_once __DIR__ . '/Pedido.php';
include_once __DIR__ . '/../../database/database.php';

class PedidoDao {

    public static function getById($id) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM Pedido WHERE id_pedido = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $pedido = $stmt->get_result()->fetch_object('Pedido');
        $con->close();
        return $pedido;
    }

    public static function getAll() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM Pedido");
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        while ($p = $result->fetch_object('Pedido')) {
            $lista[] = $p;
        }
        $con->close();
        return $lista;
    }

    public static function insert(Pedido $p) {
        $con = DataBase::connect();
        $stmt = $con->prepare(
            "INSERT INTO Pedido(id_usuario, fecha_pedido, hora_pedido, importe, estado)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "issds",
            $p->getIdUsuario(),
            $p->getFechaPedido(),
            $p->getHoraPedido(),
            $p->getImporte(),
            $p->getEstado()
        );
        $stmt->execute();
        $inserted = $stmt->affected_rows > 0;
        $stmt->close();
        $con->close();
        return $inserted;
    }

    public static function editarPedido(Pedido $p) {
        $con = DataBase::connect();
        $stmt = $con->prepare(
            "UPDATE Pedido SET id_usuario = ?, fecha_pedido = ?, hora_pedido = ?, importe = ?, estado = ? WHERE id_pedido = ?"
        );
        $idUsuario = $p->getIdUsuario();
        $fecha = $p->getFechaPedido();
        $hora = $p->getHoraPedido();
        $importe = $p->getImporte();
        $estado = $p->getEstado();
        $idPedido = $p->getIdPedido();
        $stmt->bind_param("issdsi", $idUsuario, $fecha, $hora, $importe, $estado, $idPedido);
        $stmt->execute();
        $updated = $stmt->affected_rows > 0;
        $stmt->close();
        $con->close();
        return $updated;
    }

    public static function eliminarPedido($pedido) {
        $id = is_object($pedido) ? $pedido->getIdPedido() : intval($pedido);
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM Pedido WHERE id_pedido = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $deleted = $stmt->affected_rows > 0;
        $stmt->close();
        $con->close();
        return $deleted;
    }
}
?>
