<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Materias</title>
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="top-menu">
        <a href="index.php"> Menú principal</a> |
        <a href="index.php?controller=materias&action=crear" class="btn">Nueva Materia</a>
    </div>

    <h2 class="text-center">Listado de Materias</h2>
    <table>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Programa</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($materias as $m): ?>
        <tr>
            <td><?= $m['codigo'] ?></td>
            <td><?= $m['nombre'] ?></td>
            <td><?= $m['nombrePrograma'] ?></td>
            <td>
                <a href="index.php?controller=materias&action=editar&codigo=<?= $m['codigo'] ?>">✏️ Editar</a> |
                <a href="index.php?controller=materias&action=eliminar&codigo=<?= $m['codigo'] ?>" onclick="return confirm('¿Eliminar materia?')">🗑️ Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>