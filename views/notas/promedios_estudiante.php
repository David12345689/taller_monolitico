<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Promedios por Estudiante</title>
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/notas.css">
</head>
<body>
    <div class="top-menu">
        <a href="index.php"> Menú principal</a>
        |
        <a href="index.php?controller=notas&action=index"> Volver al listado de Notas</a>
    </div>
    
    <div class="text-center">
        <a href="index.php?controller=notas&action=index" class="btn">Volver al listado de Notas</a>
    </div>

    <h2 class="text-center">Promedios por Estudiante - <?= htmlspecialchars($materia['nombre']) ?></h2>

    <table class="table-full">
        <tr class="row-header">
            <th>Código Estudiante</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Promedio</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($promedios as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['codigo']) ?></td>
            <td><?= htmlspecialchars($p['nombre']) ?></td>
            <td><?= htmlspecialchars($p['email']) ?></td>
            <td><?= $p['promedio'] ?></td>
            <td>
                <a href="index.php?controller=notas&action=verDetalleNotas&estudiante=<?= $p['codigo'] ?>&materia=<?= $materia['codigo'] ?>">Ver Detalle</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>