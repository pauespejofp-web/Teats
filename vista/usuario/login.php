<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Iniciar sesión</h3>

                        <form action="/Modelo-Vista-Controlador/index.php?controller=usuario&action=login" method="POST">

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <input type="password" name="contraseña" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Entrar</button>

                        </form>
                        <?php if (isset($_GET['error'])): ?>

                            <?php if ($_GET['error'] == 'user'): ?>
                                <p class="text-danger mt-2">El usuario no existe.</p>

                            <?php elseif ($_GET['error'] == 'pass'): ?>
                                <p class="text-danger mt-2">Contraseña incorrecta.</p>

                            <?php elseif ($_GET['error'] == 'empty'): ?>
                                <p class="text-danger mt-2">Rellena todos los campos.</p>
                            <?php endif; ?>

                        <?php endif; ?>

                        <div class="text-center mt-3">
                            ¿No tienes cuenta?
                            <a href="index.php?controller=usuario&action=registrarForm">Regístrate</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>