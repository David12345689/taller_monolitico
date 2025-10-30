<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Programa</title>
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/programas.css">
</head>
<body>
    <h2><?= isset($programa) ? 'Editar Programa' : 'Nuevo Programa' ?></h2>

    <form method="POST">
    <label>Código:</label>
    <input type="number" name="codigo" value="<?= $programa['codigo'] ?? '' ?>" <?= isset($programa) ? 'readonly' : '' ?> required min="1" step="1" pattern="[0-9]+" title="Solo números">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $programa['nombre'] ?? '' ?>" required>

    <button type="submit">Guardar</button>
    <a href="index.php?controller=programas&action=index"> Volver</a>
    <a href="index.php?controller=notas&action=index"> Volver a Notas</a>
    </form>
</body>
</html>
