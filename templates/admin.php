<?php
session_start();
include_once '../config/db.php';

// Verificar rol de administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador') {
    echo "Acceso denegado.";
    exit;
}

// Funciones para gestionar roles y permisos (ejemplos)
function obtenerUsuarios($conn) {
    $sql = "SELECT * FROM usuarios";
    return $conn->query($sql);
}

function obtenerRoles($conn) {
    $sql = "SELECT * FROM roles";
    return $conn->query($sql);
}

function obtenerPermisos($conn) {
    $sql = "SELECT * FROM permisos";
    return $conn->query($sql);
}

function obtenerPermisosRol($conn, $id_rol) {
    $sql = "SELECT p.nombre_permiso FROM roles_permisos rp JOIN permisos p ON rp.id_permiso = p.id_permiso WHERE rp.id_rol = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_rol);
    $stmt->execute();
    return $stmt->get_result();
}

function asignarRolUsuario($conn, $id_usuario, $id_rol) {
    $sql = "UPDATE usuarios SET id_rol = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_rol, $id_usuario);
    return $stmt->execute();
}

function asignarPermisoRol($conn, $id_rol, $id_permiso) {
    $sql = "INSERT INTO roles_permisos (id_rol, id_permiso) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_rol, $id_permiso);
    return $stmt->execute();
}

// ... (Lógica para manejar formularios y acciones del administrador)

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel de Administración</title>
    </head>
<body>
    <h1>Panel de Administración</h1>

    <h2>Usuarios</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($usuario = obtenerUsuarios($conn)->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $usuario['id_usuario']; ?></td>
                    <td><?php echo $usuario['usuario']; ?></td>
                    <td>
                        <select name="rol_usuario_<?php echo $usuario['id_usuario']; ?>">
                            <?php while ($rol = obtenerRoles($conn)->fetch_assoc()) { ?>
                                <option value="<?php echo $rol['id_rol']; ?>" <?php if ($usuario['id_rol'] == $rol['id_rol']) echo 'selected'; ?>><?php echo $rol['nombre_rol']; ?></option>
                            <?php } ?>
                        </select>
                        <button onclick="asignarRolUsuario(<?php echo $usuario['id_usuario']; ?>, document.querySelector('select[name=rol_usuario_<?php echo $usuario['id_usuario']; ?>]').value)">Guardar</button>
                    </td>
                    <td>
                        </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Roles y Permisos</h2>
    <script>
        function asignarRolUsuario(id_usuario, id_rol) {
            fetch('../api/asignar_rol_usuario.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id_usuario=' + id_usuario + '&id_rol=' + id_rol
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Error al asignar rol.');
                }
            });
        }
    </script>
</body>
</html>