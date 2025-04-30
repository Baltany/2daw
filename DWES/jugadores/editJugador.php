<?php
require_once "funciones.php";
$jugadores = getJugador();
$posiciones = getPosiciones();
$editarId = isset($_GET['editar']) ? $_GET['editar'] : null;
?>

<table border="1">
    <tr>
        <th>Nombre</th>
        <th>DNI</th>
        <th>Dorsal</th>
        <th>Posicion</th>
        <th>Equipo</th>
        <th>Goles</th>
        <th>Accion</th>
    </tr>
    
    <?php foreach ($jugadores as $jugador): ?>
    <tr>
        <?php if ($jugador->id == $editarId): ?>
            <form method="POST" action="editar_jugador.php">
                <input type="hidden" name="id" value="<?= $jugador->id ?>">
                <td><input type="text" name="nombre" value="<?= $jugador->nombre ?>" required></td>
                <td><input type="text" name="dni" value="<?= $jugador->dni ?>" required></td>
                <td><input type="number" name="dorsal" value="<?= $jugador->dorsal ?>" min="1" max="11"></td>
                <td>
                    <select name="posicion">
                    <select type="text" name="posicion" >
                        <?php
                            while($row = $posiciones->fetch_object()){
                        ?>
                        <option value="<?php echo $row->posicion; ?>"> <?php echo $row->posicion; ?></option>    
                        <?php
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" name="equipo" value="<?= $jugador->equipo ?>" required></td>
                <td><input type="number" name="goles" value="<?= $jugador->goles ?>" required></td>
                <td>
                    <input type="submit" value="Guardar">
                    <a href="editJugador.php">Cancelar</a>
                </td>
            </form>
        <?php else: ?>
            <td><?= $jugador->nombre ?></td>
            <td><?= $jugador->dni ?></td>
            <td><?= $jugador->dorsal ?></td>
            <td><?= $jugador->posicion ?></td>
            <td><?= $jugador->equipo ?></td>
            <td><?= $jugador->goles ?></td>
            <td><a href="?editar=<?= $jugador->id ?>">Editar</a></td>
        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
</table>

<br><br>
<a href="index.html">Volver</a>
