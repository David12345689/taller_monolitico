<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Promedios por Materia</title>
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="top-menu">
        <a href="index.php"> Menú principal</a>
    </div>

    <h2 class="text-center">Promedios por Materia - <?= htmlspecialchars($estudiante['nombre']) ?></h2>

    <table class="table-full">
        <tr class="row-header">
            <th>Código Materia</th>
            <th>Nombre Materia</th>
            <th>Promedio</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($promedios as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['codigo']) ?></td>
            <td><?= htmlspecialchars($p['nombre']) ?></td>
            <td><?= $p['promedio'] ?></td>
            <td>
                <a href="index.php?controller=notas&action=verDetalleNotas&estudiante=<?= $estudiante['codigo'] ?>&materia=<?= $p['codigo'] ?>">📊 Ver Detalle</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>