<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Notas</title>
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="top-menu">
        <a href="index.php">🏠 Menú principal</a> |
        <a href="javascript:history.back()">⬅️ Volver</a>
    </div>

    <h2 class="text-center">Detalle de Notas - <?= htmlspecialchars($materia['nombre']) ?></h2>
    <h3 class="text-center">Estudiante: <?= htmlspecialchars($estudiante['nombre']) ?></h3>
    <p class="text-center">Promedio: <?= $promedio ?></p>

    <table class="table-full">
        <tr class="row-header">
            <th>Actividad</th>
            <th>Nota</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($notas as $n): ?>
        <tr>
            <td><?= htmlspecialchars($n['actividad']) ?></td>
            <td><?= $n['nota'] ?></td>
            <td>
                <a href="index.php?controller=notas&action=editar&materia=<?= $materia['codigo'] ?>&estudiante=<?= $estudiante['codigo'] ?>&actividad=<?= urlencode($n['actividad']) ?>">✏️ Editar</a> |
                <a href="index.php?controller=notas&action=eliminar&materia=<?= $materia['codigo'] ?>&estudiante=<?= $estudiante['codigo'] ?>&actividad=<?= urlencode($n['actividad']) ?>" onclick="return confirm('¿Eliminar esta nota?')">🗑️ Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="text-center" style="margin-top: 20px;">
        <a href="index.php?controller=notas&action=crear" class="btn">➕ Agregar Nueva Nota</a>
    </div>
</body>
</html>