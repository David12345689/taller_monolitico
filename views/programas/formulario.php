<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Programa</title>
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <h2><?= isset($programa) ? 'Editar Programa' : 'Nuevo Programa' ?></h2>

    <form method="POST">
        <label>Código:</label>
        <input type="text" name="codigo" value="<?= $programa['codigo'] ?? '' ?>" <?= isset($programa) ? 'readonly' : '' ?> required>

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $programa['nombre'] ?? '' ?>" required>

        <button type="submit">Guardar</button>
        <a href="index.php?controller=programas&action=index">⬅️ Volver</a>
    </form>
</body>
</html>
