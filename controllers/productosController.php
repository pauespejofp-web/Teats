<?php

require_once 'models/producto/ProductoDAO.php';

class ProductosController
{
    public function inicio()
    {
        $productos = ProductoDAO::getAll();
        $masVendidos = array_slice($productos, 0, 3);
        $platosPequenos = array_slice($productos, 0, 2);

        $hero1 = 'assets/img/prod1.webp';
        $hero1_title = 'Nuestros Productos';

        require_once 'vista/producto/productos.php';
    }
}
