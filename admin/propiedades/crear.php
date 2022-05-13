<?php

require '../../includes/funciones.php';
incluirTemplate('header');
?>


<main class="contenedor seccion">
    <h1>Crear propiedad</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <form class="formulario">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título:</label>
            <input type="text" placeholder="Título propiedad" id="titulo">

            <label for="precio">Precio:</label>
            <input type="number" placeholder="Precio propiedad" id="precio">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion"></textarea>
        </fieldset>

        <fieldset>
            <legend>Información de la propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" placeholder="Ej: 3" id="habitaciones">

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" placeholder="Ej: 3" min="1" max="9" id="habitaciones">

            <label for="wc">WC:</label>
            <input type="number" placeholder="Ej: 1" min="1" max="9" id="wc">

            <label for="aparcamiento">Aparcamientos:</label>
            <input type="number" placeholder="Ej: 2" min="1" max="9" id="aparcamiento">

        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <select id="opciones">
                <option value="" disabled selected>--Seleccione un vendedor--</option>
                <option value="1">Ana Márquez</option>
                <option value="2">Antonio Gómez</option>
            </select>
        </fieldset>

        <input type="submit" value="Crear propiedad" class="boton-verde">
    </form>
</main>



<?php incluirTemplate('footer'); ?>