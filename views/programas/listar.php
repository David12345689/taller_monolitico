<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Programas</title>
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <div class="top-menu">
        <a href="index.php"> Menú principal</a> |
        <a href="index.php?controller=programas&action=crear" class="btn">Nuevo Programa</a>
    </div>

    <h2 class="text-center">Listado de Programas</h2>
    <table>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($programas as $p): ?>
        <tr>
            <td><?= $p['codigo'] ?></td>
            <td><?= $p['nombre'] ?></td>
            <td>
                <a href="index.php?controller=programas&action=editar&codigo=<?= $p['codigo'] ?>"> Editar</a> |
                <a href="index.php?controller=programas&action=eliminar&codigo=<?= $p['codigo'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este programa?')">🗑️ Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>