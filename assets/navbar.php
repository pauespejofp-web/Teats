<?php
// Asegura que la sesión esté iniciada cuando se incluye este navbar
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-white bg-white">
    <div class="container">


        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/logo.png" alt="Tesla Logo" width="150" class="me-2">
        </a>


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navTesla">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse justify-content-center" id="navTesla">
            <ul class="navbar-nav mb-2 mb-lg-0">

                <li class="nav-item mx-3">
                    <a class="nav-link active" href="index.php">Menú</a>
                </li>

                <li class="nav-item mx-3">
                    <a class="nav-link" href="carta.php">Carta</a>
                </li>

                <li class="nav-item mx-3">
                    <a class="nav-link" href="index.php?controller=productos&action=inicio">Productos</a>
                </li>

                <li class="nav-item mx-3">
                    <a class="nav-link" href="contacto.php">Contacto</a>
                </li>

            </ul>
        </div>

        <div class="d-flex align-items-center ms-auto">

            <div class="text-black me-3">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <p class="mb-0">Hola, <?= $_SESSION['usuario']->getNombre(); ?></p>
                <?php endif; ?>
            </div>

            <div class="d-flex align-items-center">
                <img src="assets/sga/interrogacion.svg" alt="Ayuda" class="me-2" width="24" height="24">
                <img src="assets/sga/internet.svg" alt="Internet" class="me-2" width="24" height="24">

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="index.php?controller=productos&action=inicio">
                    <?php else: ?>
                        <a href="index.php?controller=usuario&action=loginForm">
                        <?php endif; ?>
                        <img src="assets/sga/usuario.svg" alt="Usuario" class="me-2" width="38" height="38">
                        </a>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <span class="me-2">Hola, <?= htmlspecialchars($_SESSION['user_name']); ?></span>
                            <a href="index.php?controller=usuario&action=logout" class="btn btn-outline-danger ms-3">
                                Cerrar sesión
                            </a>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] == 1): ?>
                            <a href="/Modelo-Vista-Controlador/api/public/apihtml.html" class="btn btn-outline-primary">Admin API</a>
                        <?php endif; ?>


            </div>

</nav>