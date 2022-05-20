<?php
//archivo funciones
require '../includes/funciones.php';

$auth = estaAutenticado();
if (!$auth) {
    //Si no está autenticado
    header('Location: /');
}

//Importar conexión
require '../includes/config/database.php';
$db = conectarDB();
//Query
$query = "SELECT * FROM propiedades;";
//Consultar BD
$consulta = mysqli_query($db, $query);

//si el valor resultado no existe, le asigna null. Similar a isset
$resultado = $_GET['resultado'] ?? null;

//Eliminar propiedad

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        //Elimina el archivo
        $query = "SELECT imagen FROM propiedades WHERE id = ${id}";
        $resultado = mysqli_query($db, $query);
        $propiedad = mysqli_fetch_assoc(($resultado));
        unlink('../imagenes/' . $propiedad['imagen']);
        //Elimina la propiedad
        $query = "DELETE FROM propiedades WHERE id = ${id}";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('location: /admin?resultado=3');
        }
    }
}

incluirTemplate('header');
?>


<main class="contenedor seccion">
    <h1>Administrador de Bienes Raíces</h1>
    <?php if ($resultado == 1) : ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php elseif ($resultado == 2) :  ?>
        <p class="alerta exito">Anuncio actualizado correctamente</p>
    <?php elseif ($resultado == 3) :  ?>
        <p class="alerta exito">Anuncio eliminado correctamente</p>

    <?php endif; ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Mostrar resultados -->
            <?php
            while ($row = mysqli_fetch_assoc($consulta)) : ?>
                <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['titulo'] ?></td>
                    <td><img src="/imagenes/<?php echo $row['imagen'] ?>" alt="imagen propiedad" class="imagen-tabla"> </td>
                    <td><?php echo $row['precio'] ?></td>
                    <td>
                        <!-- El botón eliminar se mete dentro de un formulario -->
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <!--Añado el id en la url para que coja el de cada una al hacer clic sobre ella -->
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $row['id'] ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php
//Cerrar conexión
mysqli_close($db);
incluirTemplate('footer'); ?>