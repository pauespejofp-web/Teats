<?php

try {


  include_once __DIR__ . '/../../../models/Usuario/UsuarioDAO.php';
  $usuarios = UsuarioDao::getAll();
} catch (Throwable $e) {

  $usuarios = [];
  
}

?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Administración</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="/Modelo-Vista-Controlador/vista/admin/Panel_administracion/admin.css">
</head>

<body>

  <div class="admin-wrapper">

    <aside class="sidebar">
      <div class="brand">TEATS PANEL</div>

      <nav>
        <ul class="menu" role="menu">
          <li><button class="menu-btn active-btn" data-target="usuarios" aria-controls="usuarios" aria-expanded="true"> <i class="bi bi-people-fill"></i> Usuarios</button></li>
          <li><button class="menu-btn" data-target="pedidos" aria-controls="pedidos"> <i class="bi bi-basket-fill"></i> Pedidos</button></li>
          <li><button class="menu-btn" data-target="productos" aria-controls="productos"> <i class="bi bi-box-seam"></i> Productos</button></li>
          <li><button class="menu-btn" data-target="ofertas" aria-controls="ofertas"> <i class="bi bi-tag-fill"></i> Ofertas</button></li>
        </ul>
      </nav>

      <div class="mt-4 small-muted">
        <div>Usuario: <strong>admin@tesla.local</strong></div>
        <div class="mt-2">Versión: 1.0</div>
      </div>
    </aside>

    <main class="main-content">


      <section id="usuarios" class="content-section active-section" role="region" aria-labelledby="h-usuarios">
        <div class="section-header">
          <h4 id="h-usuarios">Usuarios</h4>
          <div class="small-muted">Listado de cuentas</div>
        </div>

        <div class="panel">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <?php if (isset($msg) && $msg === 'edit_ok' && isset($_GET['id'], $_GET['nombre'])): ?>
              <div class="alert alert-success">
                El usuario con ID <strong><?= htmlspecialchars($_GET['id']) ?></strong>
                ha sido cambiado de nombre a
                <strong><?= htmlspecialchars($_GET['nombre']) ?></strong>.
              </div>
            <?php endif; ?>
            <?php if (isset($msg) && $msg === 'delete_ok' && isset($_GET['id'])): ?>
              <div class="alert alert-danger">
                 El usuario con ID <strong><?= htmlspecialchars($_GET['id']) ?></strong> ha sido eliminado.
              </div>
            <?php endif; ?>




            <tbody>
              <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $u): ?>
                  <tr>
                    <td><?= htmlspecialchars($u->getIdUsuario()) ?></td>
                    <td><?= htmlspecialchars($u->getNombre()) ?></td>
                    <td><?= htmlspecialchars($u->getEmail()) ?></td>
                    <td>
                      <!-- Botón que abre modal y rellena datos vía API -->
                      <button type="button"
                              class="btn btn-sm btn-outline-primary btn-open-edit-modal"
                              data-id="<?= $u->getIdUsuario() ?>">
                        Editar
                      </button>
                       <a href="/Modelo-Vista-Controlador/index.php?controller=usuario&action=eliminar&id=<?= $u->getIdUsuario() ?>" class="btn btn-sm btn-outline-danger"
                         onclick="return confirm('¿Eliminar usuario <?= $u->getNombre() ?>?');">
                         Eliminar
                       </a>
                     </td>
                   </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-muted">No se encontraron usuarios.</td>
                </tr>
              <?php endif; ?>
            </tbody>

          </table>
        </div>
      </section>

      <section id="pedidos" class="content-section" role="region" aria-labelledby="h-pedidos">
        <div class="section-header">
          <h4 id="h-pedidos">Pedidos</h4>
          <div class="small-muted">Gestión de pedidos</div>
        </div>

        <div class="panel">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1001</td>
                <td>Juan Pérez</td>
                <td>29.50€</td>
                <td><span class="badge bg-warning text-dark">En preparación</span></td>
                <td>
                  <button class="btn btn-sm btn-outline-success">Cambiar estado</button>
                </td>
              </tr>
              <tr>
                <td><span class="badge bg-success">Enviado</span></td>
                <td>
                  <button class="btn btn-sm btn-outline-success">Cambiar estado</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <!-- PRODUCTOS -->
      <section id="productos" class="content-section" role="region" aria-labelledby="h-productos">
        <div class="section-header">
          <h4 id="h-productos">Productos</h4>
          <div class="small-muted">Ver, editar y eliminar</div>
        </div>

        <div class="panel">
          <div class="mb-3 d-flex justify-content-between">
            <div>
              <button class="btn btn-primary">+ Nuevo producto</button>
            </div>
            <div class="small-muted">Total: <strong>12</strong></div>
          </div>

          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Disponible</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <!-- Reemplazar por datos reales -->
              <tr>
                <td>1</td>
                <td>Tesla Burger</td>
                <td>8.50€</td>
                <td>Burgers</td>
                <td><input type="checkbox" checked disabled></td>
                <td>
                  <button class="btn btn-sm btn-outline-primary">Editar</button>
                  <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                </td>
              </tr>
              <tr>
                <td>14</td>
                <td>Steak Especial (ID 14)</td>
                <td>31.50€</td>
                <td>Carnes</td>
                <td><input type="checkbox" checked disabled></td>
                <td>
                  <button class="btn btn-sm btn-outline-primary">Editar</button>
                  <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <!-- OFERTAS -->
      <section id="ofertas" class="content-section" role="region" aria-labelledby="h-ofertas">
        <div class="section-header">
          <h4 id="h-ofertas">Ofertas</h4>
          <div class="small-muted">Promociones y descuentos</div>
        </div>

        <div class="panel">
          <p class="mb-3">Preparado para añadir nuevas ofertas. Rellena el formulario y pulsa "Agregar oferta".</p>

          <form class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Título</label>
              <input type="text" class="form-control" placeholder="Ej: 2x1 Tesla Burger">
            </div>
            <div class="col-md-6">
              <label class="form-label">Descuento (%)</label>
              <input type="number" class="form-control" min="0" max="100" value="20">
            </div>
            <div class="col-12">
              <label class="form-label">Descripción</label>
              <textarea class="form-control" rows="2"></textarea>
            </div>
            <div class="col-12">
              <button class="btn btn-success">Agregar oferta</button>
            </div>
          </form>
        </div>
      </section>

    </main>
  </div>

  <!-- Scripts -->
  <script src="/Modelo-Vista-Controlador/vista/admin/Panel_administracion/admin.js"></script>
  <!-- Bootstrap JS (opcional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>