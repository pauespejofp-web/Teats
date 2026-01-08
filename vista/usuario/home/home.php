

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>TEATS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/home.css">
</head>

<body>

<?php include "assets/navbar.php"; ?>
<section class="hero-slider-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/Fondo/Fondo-Web2.png" class="d-block w-100 hero-img" alt="Interior del restaurante">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                    <h1 class="carousel-title">TEATS</h1>
                    <p class="carousel-subtitle">Tu mejor restaurante</p>
                    <p class="carousel-text">Desde 9,99€ el menú</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="index.php?controller=productos&action=inicio" class="btn btn-primary btn-lg">Pedir ahora</a>
                        <a href="#" class="btn btn-secondary btn-lg">Reservar</a>
                    </div>
                </div>
            </div>
            <!-- Puedes añadir más carousel-item aquí para más slides si tienes más imágenes de héroe -->
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- DESTACADOS -->
<section class="container-fluid my-5 featured-dishes px-4">
    <div class="row g-4">

        <?php foreach ($masVendidos as $p): ?>
        <div class="col-md-6">
            <div class="card card-feature position-relative">
                <img src="<?= $p->getImagenUrl() ?>" class="card-img-top" alt="<?= $p->getNombre() ?>">
                <div class="card-overlay p-4">
                    <h4 class="card-title text-white"><?= $p->getNombre() ?></h4>
                    <div class="d-flex gap-2">
                        <a href="index.php?controller=productos&action=inicio" class="btn btn-primary btn-sm">Pedir ahora</a>
                        <a href="index.php?controller=productos&action=inicio" class="btn btn-outline-light btn-sm">Añadir al carrito</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- PLATOS PEQUEÑOS -->
<section class="container-fluid my-5 small-dishes px-4">
    <div class="row g-4">
        <?php foreach ($platosPequenos as $p): ?>
        <div class="col-md-6">
            <div class="card card-mini d-flex flex-row">
                <div class="card-body p-3">
                    <h6 class="card-title"><?= $p->getNombre() ?></h6>
                    <p class="card-text text-muted small"><?= $p->getDescripcion() ?></p>
                    <a href="index.php?controller=productos&action=inicio" class="btn btn-dark btn-sm mt-2">Pedir ahora</a>
                </div>
                <img src="<?= $p->getImagenUrl() ?>" class="card-img-end" alt="<?= $p->getNombre() ?>">
            </div>
        </div>
        <?php endforeach; ?>
        
    </div>
</section>

<!-- MAPA -->
<div class="container-fluid my-5 px-4">
    <section class="map-section position-relative">
        <div class="map-placeholder">
            <img src="assets/img/mapa.webp" alt="Mapa de restaurantes" class="img-fluid w-100">
        </div>
        <div class="map-info-container container">
            <div class="map-info p-4">
                <h2 class="mb-3">Find Your Restaurant</h2>
                <p class="mb-4">View the network of Tesla Superchargers and Destination Chargers available near you.</p>
                <div class="d-flex gap-3 mb-4">
                    <button class="btn btn-dark btn-find-restaurant">Find Restaurant</button>
                    <button class="btn btn-outline-dark btn-learn-more">Learn More</button>
                </div>
                <div class="stats d-flex align-items-center">
                    <div class="me-4 d-flex align-items-center">
                        <span class="icon-heart me-2">❤️</span>
                        <strong>130</strong>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="icon-star me-2">⭐</span>
                        <strong>40</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
<footer class="site-footer bg-white text-black py-4">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5>Teats © 2026</h5>
            </div>
            <div class="col-md-8">
                <ul class="footer-links list-unstyled d-flex flex-wrap gap-3 mb-0">
                    <li><a href="#" class="text-white">Privacidad y legal</a></li>
                    <li><a href="#" class="text-white">Contacto</a></li>
                    <li><a href="#" class="text-white">Noticias</a></li>
                    <li><a href="#" class="text-white">Seguir informado</a></li>
                    <li><a href="#" class="text-white">Localización de tiendas</a></li>
                    <li><a href="#" class="text-white">Saber más</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>