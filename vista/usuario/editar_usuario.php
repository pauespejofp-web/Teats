<h2>Editar Usuario</h2>

<form action="index.php?controller=usuario&action=actualizar" method="POST">

    <input type="hidden" name="id_usuario" value="<?= $usuario->getIdUsuario() ?>">

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($usuario->getNombre()) ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($usuario->getEmail()) ?>" required>

    <label>Nueva contraseña (opcional):</label>
    <input type="password" name="password">

    <button type="submit">Guardar cambios</button>
</form>
