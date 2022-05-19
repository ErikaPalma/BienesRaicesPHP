<?php
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
</main>

<?php incluirTemplate('footer'); ?>