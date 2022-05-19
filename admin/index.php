<?php

//Importar conexión
require '../includes/config/database.php';
$db = conectarDB();
//Query
$query = "SELECT * FROM propiedades;";
//Consultar BD
$consulta = mysqli_query($db, $query);

//si el valor resultado no existe, le asigna null. Similar a isset
$resultado = $_GET['resultado'] ?? null;

require '../includes/funciones.php';
incluirTemplate('header');
?>


<main class="contenedor seccion">
    <h1>Administrador de Bienes Raíces</h1>
    <?php if ($resultado == 1) : ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
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
                        <a href="#" class="boton-rojo-block">Eliminar</a>
                        <a href="#" class="boton-amarillo-block">Actualizar</a>
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