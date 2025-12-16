<?php include "assets/navbar.php"; ?>

<div class="container mt-5">
    <h2 class="text-center"><?= $producto->getNombre() ?></h2>
    <hr>

    <p><strong>ID:</strong> <?= $producto->getId_producto() ?></p>
    <p><strong>Precio:</strong> <?= number_format($producto->getPrecio(), 2) ?> €</p>
    <p><strong>Descripción:</strong> <?= $producto->getDescripcion() ?></p>

    <a href="index.php?controller=productos&action=productos" class="btn btn-secondary mt-3">
        Volver atrás
    </a>
</div>
