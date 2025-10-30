<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas</title>
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/notas_listar.css">
</head>
<body>
    <div class="top-menu">
        <a href="index.php"> Menú principal</a> |
        <a href="index.php?controller=notas&action=crear" class="btn"> Nueva Nota</a>
    </div>
    <h2 class="text-center">Listado de Notas</h2>

    <div class="text-center top-menu">
        <a href="#" onclick="mostrarPromedios('estudiantes')" class="btn"> Ver Promedios por Estudiante</a>
        <a href="#" onclick="mostrarPromedios('materias')" class="btn"> Ver Promedios por Materia</a>
    </div>

    <!-- Modal para seleccionar estudiante o materia -->
    <div id="modalSeleccion">
        <div class="modal-content">
            <h3 class="text-center">Seleccionar para ver promedios</h3>
            <select id="seleccionId" class="form-control">
                <!-- Opciones se cargarán dinámicamente -->
            </select>
            <div class="text-center">
                <button onclick="verPromedios()" class="btn">Ver Promedios</button>
                <button onclick="cerrarModal()" class="btn btn-cancelar">Cancelar</button>
            </div>
        </div>
    </div>

    <table border="1" cellpadding="8" cellspacing="0" class="table-full text-center">
        <tr class="row-header">
            <th>Materia</th>
            <th>Estudiante</th>
            <th>Actividad</th>
            <th>Nota</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($notas as $n): ?>
            <tr>
                <td><?= htmlspecialchars($n['materia_nombre']) ?></td>
                <td><?= htmlspecialchars($n['estudiante_nombre']) ?></td>
                <td><?= htmlspecialchars($n['actividad']) ?></td>
                <td><?= htmlspecialchars($n['nota']) ?></td>
                <td>
                    <a href="index.php?controller=notas&action=editar&id=<?= urlencode($n['id']) ?>">Editar</a> |
                    <a href="index.php?controller=notas&action=eliminar&id=<?= urlencode($n['id']) ?>" onclick="return confirm('¿Eliminar esta nota?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <script>
    let tipo = '';
    let estudiantes = <?= json_encode($estudiantes ?? []) ?>;
    let materias = <?= json_encode($materias ?? []) ?>;

    function mostrarPromedios(tipoDatos) {
        tipo = tipoDatos;
        const modal = document.getElementById('modalSeleccion');
        const select = document.getElementById('seleccionId');
        select.innerHTML = ''; // Limpiar opciones anteriores
        
        if (tipoDatos === 'estudiantes') {
            estudiantes.forEach(est => {
                const option = document.createElement('option');
                option.value = est.codigo;
                option.textContent = est.nombre;
                select.appendChild(option);
            });
        } else {
            materias.forEach(mat => {
                const option = document.createElement('option');
                option.value = mat.codigo;
                option.textContent = mat.nombre;
                select.appendChild(option);
            });
        }
        
        modal.style.display = 'block';
    }

    function cerrarModal() {
        document.getElementById('modalSeleccion').style.display = 'none';
    }

    function verPromedios() {
        const id = document.getElementById('seleccionId').value;
        if (tipo === 'estudiantes') {
            window.location.href = `index.php?controller=notas&action=verPromedios&estudiante=${id}`;
        } else {
            window.location.href = `index.php?controller=notas&action=verPromediosPorMateria&materia=${id}`;
        }
    }
    </script>
</body>
</html>