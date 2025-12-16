<?php

include_once __DIR__ . "/Producto.php";
include_once __DIR__ . "/../../database/database.php";

class ProductoDAO
{


    public static function getAll()
    {
        $con = DataBase::connect();

        $sql = "SELECT * FROM producto ORDER BY id_producto DESC";
        $result = $con->query($sql);

        $lista = [];
        while ($p = $result->fetch_object("Producto")) {
            $lista[] = $p;
        }

        $con->close();
        return $lista;
    }

    public static function getDestacados()
    {
        $con = DataBase::connect();

        $sql = "SELECT * FROM producto WHERE destacado = 1 LIMIT 3";
        $result = $con->query($sql);

        $lista = [];
        while ($p = $result->fetch_object("Producto")) {
            $lista[] = $p;
        }

        $con->close();
        return $lista;
    }


    public static function getMasVendidos()
    {
        $con = DataBase::connect();

        $sql = "SELECT * FROM producto ORDER BY ventas DESC LIMIT 3";
        $result = $con->query($sql);

        $lista = [];
        while ($p = $result->fetch_object("Producto")) {
            $lista[] = $p;
        }

        $con->close();
        return $lista;
    }


    public static function getById($id)
    {
        $con = DataBase::connect();

        $stmt = $con->prepare("SELECT * FROM producto WHERE id_producto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $producto = $result->fetch_object("Producto");

        $stmt->close();
        $con->close();

        return $producto;
    }

    
}
