<?php

include_once __DIR__ . '/Producto.php';
include_once __DIR__ . '/../../database/database.php';

class ProductoDAO
{

    public static function getAll()
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM producto");
        $stmt->execute();

        $result = $stmt->get_result();
        $lista = [];

        while ($p = $result->fetch_object('Producto')) {
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

        $producto = $stmt->get_result()->fetch_object("Producto");

        $con->close();
        return $producto;
    }

    public static function insert($producto)
    {
        $con = DataBase::connect();

        $nombre = $producto->getNombre();
        $precio = $producto->getPrecio();
        $descripcion = $producto->getDescripcion();

        $stmt = $con->prepare("INSERT INTO producto (nombre, precio, descripcion) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $nombre, $precio, $descripcion);

        $resultado = $stmt->execute();

        $stmt->close();
        $con->close();

        return $resultado;
    }

    public static function eliminarProducto($id)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM producto WHERE id_producto = ?");

        $id = $id->getIdProducto();
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();

        $stmt->close();
        $con->close();

        return $resultado;
    }
    public static function editarProducto(Producto $producto)
    {
        $con = DataBase::connect();

        $stmt = $con->prepare(
            "UPDATE producto 
         SET nombre = ?, 
             descripcion = ?, 
             precio = ?, 
             categoria_id = ?, 
             imagen_url = ?
         WHERE id_producto = ?"
        );
        $nombre = $producto->getNombre();
        $descripcion = $producto->getDescripcion();
        $precio = $producto->getPrecio();
        $categoria_id = $producto->getCategoriaId();
        $imagen_url = $producto->getImagenUrl();
        $id_producto = $producto->getIdProducto();

        $stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $categoria_id, $imagen_url, $id_producto);


        $resultado = $stmt->execute();

        $stmt->close();
        $con->close();

        return $resultado;
    }
}
