<?php

require 'includes/app.php';
$db = conectarDB();
incluirTemplate('header');

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /');
}

$query = "SELECT * FROM propiedades WHERE id = ${id}";
$resultado = mysqli_query($db, $query);

if (!$resultado->num_rows) {
    header('Location: /');
}
$row = mysqli_fetch_assoc($resultado)
?>

<main class="contenedor seccion contenido-centrado">

    <h1><?php echo $row['titulo']; ?></h1>
    <img loading="lazy" src="imagenes/<?php echo $row['imagen']; ?>" alt="imagen de la propiedad">

    <div class="resumen-propiedad">
        <p class="precio"><?php echo $row['precio']; ?></p>
        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                <p><?php echo $row['wc']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                <p><?php echo $row['estacionamiento']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                <p><?php echo $row['habitaciones']; ?></p>
            </li>
        </ul>

        <p><?php echo $row['descripcion']; ?></p>

    </div>

</main>

<?php
mysqli_close($db);

incluirTemplate('footer'); ?>