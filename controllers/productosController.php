<?php

class ProductosController
{
    public function inicio()
    {
        include_once 'models/Producto/ProductoDAO.php';

        $productos = ProductoDAO::getAll();

        if (!$productos) {
            $productos = [];
        }

        $masVendidos = array_slice($productos, 0, 3);
        $destacados  = array_slice($productos, 3, 3);

        $hero1 = 'assets/img/prod1.webp';
        $hero1_title = 'Productos Teats';

        include_once 'vista/producto/productos.php';
    }
}
