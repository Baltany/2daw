            $filas = $conex->affected_rows;
<?php
session_start();

if(!isset($_COOKIE['usuario_id']) || empty($_COOKIE['usuario_id'])){
    header("Location: login.php");
    exit();
}

require_once '../model/Usuario.php';
require_once '../controller/UsuarioController.php';

$usuario = UsuarioController::buscarPorId($_COOKIE['usuario_id']);

if(!$usuario || !$usuario->esAdmin()){
    header("Location: index.php");
    exit();
}

if(isset($_GET['eliminar'])){
    $id = intval($_GET['eliminar']);
    if($id != $usuario->id){
        if(UsuarioController::eliminar($id)){
            $mensaje = "<p style='color:green;'>Usuario eliminado correctamente</p>";
        } else {
            $mensaje = "<p style='color:red;'>Error al eliminar el usuario</p>";
        }
    } else {
        $mensaje = "<p style='color:red;'>No puedes eliminarte a ti mismo</p>";
    }
}

$usuarios = UsuarioController::obtenerTodos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
</head>
<body>
    <h1>Panel de Administración</h1>
    
    <p>Administrador: <?php echo $usuario->nombre . ' ' . $usuario->apellidos; ?></p>
    
    <a href="index.php">Volver al Panel</a> | 
    <a href="items.php">Gestionar Items</a> | 
    <a href="logout.php">Cerrar Sesión</a>
    
    <hr>
    
    <?php if(isset($mensaje)) echo $mensaje; ?>
    
    <h2>Lista de Usuarios Registrados</h2>
    
    <?php if($usuarios && count($usuarios) > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
            <?php foreach($usuarios as $u): ?>
                <tr>
                    <td><?php echo $u->id; ?></td>
                    <td><?php echo $u->dni; ?></td>
                    <td><?php echo $u->nombre; ?></td>
                    <td><?php echo $u->apellidos; ?></td>
                    <td><?php echo $u->email; ?></td>
                    <td><strong><?php echo $u->tipo; ?></strong></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($u->fecha_registro)); ?></td>
                    <td>
                        <?php if($u->id != $usuario->id): ?>
                            <a href="admin.php?eliminar=<?php echo $u->id; ?>">Eliminar</a>
                        <?php else: ?>
                            <em>Tu cuenta</em>
                        <?php endif; ?>
                        <a href="editar_usuario.php?id=<?php echo $u->id; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay usuarios registrados</p>
    <?php endif; ?>
</body>
</html>