<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tesla Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

    <?php include "assets/navbar.php"; ?>

    <div class="home-background">
        <h1 class="text-center">Bienvenido a Tesla Restaurant</h1>
        <p class="text-center">Innovación y gastronomía eléctrica </p>
    </div>

</body>

</html>