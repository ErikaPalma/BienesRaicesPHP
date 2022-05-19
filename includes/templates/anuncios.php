<?php
//Importar conexión (la ruta es relativa al index.php)
require 'includes/config/database.php';
$db = conectarDB();

//Consultar
$query = "SELECT * FROM propiedades LIMIT ${limite}";

//Obtener resultados
$resultado = mysqli_query($db, $query);
?>

<div class="contenedor-anuncios">
    <?php while ($row = mysqli_fetch_assoc($resultado)) : ?>

        <div class="anuncio">

            <img loading="lazy" src="imagenes/<?php echo $row['imagen']; ?>" alt="anuncio">

            <div class="contenido-anuncio">
                <h3><?php echo $row['titulo']; ?></h3>
                <p><?php echo $row['descripcion']; ?></p>
                <p class="precio"><?php echo $row['precio']; ?>€</p>

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

                <a href="anuncio.php?id=<?php echo $row['id'] ?>" class="boton-amarillo-block">
                    Ver Propiedad
                </a>
            </div>
            <!--.contenido-anuncio-->
        </div>
    <?php endwhile; ?>
    <!--anuncio-->



</div>
<!--.contenedor-anuncios-->

<?php mysqli_close($db); ?>