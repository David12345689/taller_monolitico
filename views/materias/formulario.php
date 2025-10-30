<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Materia</title>
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <h2><?= isset($materia) ? 'Editar Materia' : 'Nueva Materia' ?></h2>

    <form method="POST">
        <label>Código:</label>
        <input type="text" name="codigo" value="<?= $materia['codigo'] ?? '' ?>" <?= isset($materia) ? 'readonly' : '' ?> required>

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $materia['nombre'] ?? '' ?>" required>

        <label>Programa:</label>
        <select name="programa" required>
            <option value="">Seleccione</option>
            <?php foreach ($programas as $p): ?>
                <option value="<?= $p['codigo'] ?>" <?= isset($materia) && $materia['programa'] == $p['codigo'] ? 'selected' : '' ?>>
                    <?= $p['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Guardar</button>
        <a href="index.php?controller=materias&action=index">Volver</a>
    </form>
</body>
</html>