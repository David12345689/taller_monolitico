<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Nota</title>
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/notas.css">
</head>
<body>
    <?php if (isset($nota)): ?>
        <h2>Editar Nota</h2>
    <?php else: ?>
        <h2>Nueva Nota</h2>
    <?php endif; ?>

    <form method="POST">
        <?php if (!isset($nota)): ?>
            <label>Estudiante:</label>
            <select name="estudiante" required>
                <option value="">Seleccione</option>
                    <?php foreach ($estudiantes as $est): ?>
                    <option value="<?php echo $est['codigo']; ?>">
                        <?php echo $est['nombre']; ?>
                    </option>
                    <?php endforeach; ?>
            </select>

            <label>Materia:</label>
            <select name="materia" required>
                <option value="">Seleccione</option>
                <?php foreach ($materias as $mat): ?>
                    <option value="<?php echo $mat['codigo']; ?>">
                        <?php echo $mat['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Actividad:</label>
            <select name="actividad" required>
                <option value="">Seleccione</option>
                <option value="Parcial 1">Parcial 1</option>
                <option value="Parcial 2">Parcial 2</option>
                <option value="Parcial 3">Parcial 3</option>
                <option value="Trabajo 1">Trabajo 1</option>
                <option value="Trabajo 2">Trabajo 2</option>
            </select>
        <?php else: ?>
            <!-- Editing: show read-only info and include id as hidden -->
            <p>Estudiante: <strong><?= htmlspecialchars($nota['estudiante']) ?> - <?= htmlspecialchars($nota['estudiante']) ? '' : '' ?></strong></p>
            <p>Materia: <strong><?= htmlspecialchars($nota['materia']) ?></strong></p>
            <p>Actividad: <strong><?= htmlspecialchars($nota['actividad']) ?></strong></p>
            <input type="hidden" name="id" value="<?= $nota['id'] ?>">
        <?php endif; ?>

        <label>Nota (0.0 - 5.0):</label>
        <input type="number" name="valor" step="0.1" min="0.0" max="5.0" required value="<?= isset($nota) ? htmlspecialchars($nota['nota']) : '' ?>">

        <button type="submit">Guardar</button>
        <a href="index.php?controller=notas&action=index">Volver</a>
    </form>
</body>
</html>
