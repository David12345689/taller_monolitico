<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Estudiante</title>
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/estudiantes.css">
</head>
<body>
    <h2><?= isset($estudiante) ? 'Editar Estudiante' : 'Nuevo Estudiante' ?></h2>

    <form method="POST">
    <label>Código:</label>
    <input type="number" name="codigo" value="<?= $estudiante['codigo'] ?? '' ?>" <?= isset($estudiante) ? 'readonly' : '' ?> required min="1" step="1" pattern="[0-9]+" title="Solo números">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $estudiante['nombre'] ?? '' ?>" pattern="[A-Za-zÁÉÍÓÚáéíóú\s]+" title="Solo letras y espacios" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= $estudiante['email'] ?? '' ?>" required>

        <label>Programa:</label>
        <select name="programa" required>
            <option value="">Seleccione</option>
            <?php foreach ($programas as $p): ?>
                <option value="<?= $p['codigo'] ?>" <?= isset($estudiante) && $estudiante['programa'] == $p['codigo'] ? 'selected' : '' ?>>
                    <?= $p['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Guardar</button>
        <a href="index.php?controller=estudiantes&action=index"> Volver</a>
    </form>
</body>
</html>