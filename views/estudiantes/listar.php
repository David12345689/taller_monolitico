<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Estudiantes</title>
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="top-menu">
        <a href="index.php">🏠 Menú principal</a> |
        <a href="index.php?controller=estudiantes&action=crear" class="btn">➕ Nuevo Estudiante</a>
    </div>

    <h2 class="text-center">Listado de Estudiantes</h2>
    <table>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Programa</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($estudiantes as $e): ?>
        <tr>
            <td><?= $e['codigo'] ?></td>
            <td><?= $e['nombre'] ?></td>
            <td><?= $e['email'] ?></td>
            <td><?= $e['programa'] ?></td>
            <td>
                <a href="index.php?controller=estudiantes&action=editar&codigo=<?= $e['codigo'] ?>">✏️ Editar</a> |
                <a href="index.php?controller=estudiantes&action=eliminar&codigo=<?= $e['codigo'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este estudiante?')">🗑️ Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>