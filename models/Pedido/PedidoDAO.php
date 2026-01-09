<?php

require_once __DIR__ . '/Pedido.php';
require_once __DIR__ . '/../../database/database.php';

class PedidoDao
{
    public static function getById(int $id)
    {
        $con = DataBase::connect();

        $stmt = $con->prepare(
            "SELECT * FROM pedido WHERE id_pedido = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $pedido = $stmt->get_result()->fetch_object('Pedido');

        $stmt->close();
        $con->close();

        return $pedido;
    }

    public static function getAll(): array
    {
        $con = DataBase::connect();

        $stmt = $con->prepare(
            "SELECT * FROM pedido ORDER BY fecha_pedido DESC, hora_pedido DESC"
        );
        $stmt->execute();

        $result = $stmt->get_result();
        $lista = [];

        while ($p = $result->fetch_object('Pedido')) {
            $lista[] = $p;
        }

        $stmt->close();
        $con->close();

        return $lista;
    }

    public static function insert(Pedido $p): bool
    {
        $con = DataBase::connect();

        $stmt = $con->prepare(
            "INSERT INTO pedido (id_usuario, fecha_pedido, hora_pedido, importe, estado)
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

        $ok = $stmt->execute();

        if ($ok) {
            $p->setIdPedido($con->insert_id);
        }

        $stmt->close();
        $con->close();

        return $ok;
    }

    public static function editarPedido(Pedido $p)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare(
            "UPDATE pedido SET id_usuario = ?, fecha_pedido = ?, hora_pedido = ?, importe = ?, estado = ? WHERE id_pedido = ?"
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

    public static function eliminarPedido(Pedido $pedido): bool
{
    $con = DataBase::connect();

    $stmt = $con->prepare("DELETE FROM pedido WHERE id_pedido = ?");
    $id = $pedido->getIdPedido();
    $stmt->bind_param("i", $id);

    $ok = $stmt->execute();

    $stmt->close();
    $con->close();

    return $ok;
}


}
