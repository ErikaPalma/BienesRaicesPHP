<?php
//BBDD
require '../../includes/config/database.php';
$db = conectarDB();

//Consulta para obtener los vendedores

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

/* Inicializan vacías y cuando se le da a enviar se crean y toman sus valores
De este modo, si el usuario no rellena
todos los campos, se muestran en el formulario los que sí rellenó y
no tiene que escribir todo desde 0.
Además de esto, hay que meter cada variable en el value de cada campo para
que se muestren*/
$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorId = '';

//Array para mensajes de error
$errores = [];

//Ejecuta el código una vez que el usuario envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    var_dump($_POST['titulo']);
    echo "</pre>";

    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedorId = $_POST['vendedorId'];
    $creado = date('Y/m/d');

    if (!$titulo || is_numeric($titulo) || preg_match("/[0-9]/", $titulo)) {
        $errores[] = "Introduce un título válido";
    }

    if (!$precio) {
        $errores[] = "Introduce un precio válido";
    }

    if (!$descripcion) {
        $errores[] = "Introduce una descripción válida";
    }

    if (!$habitaciones) {
        $errores[] = "Introduce un nº de habitaciones válido";
    }

    if (!$wc) {
        $errores[] = "Introduce un nº de wc válido";
    }

    if (!$estacionamiento) {
        $errores[] = "Introduce un nº de estacionamientos válido";
    }

    if (!$vendedorId) {
        $errores[] = "Introduce un vendedor válido";
    }

    //Si no hay errores, se inserta en la BD
    if (empty($errores)) {
        //Insertar en la BD
        $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, creado, vendedorId) 
    VALUES('$titulo', $precio, '$descripcion', $habitaciones, $wc, $estacionamiento, '$creado', $vendedorId)";

        //Guardar resultado en la BD
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            //Si todo ok, redireccionar al usuario
            header('Location: /admin');
        }
    }
}
//archivo funciones
require '../../includes/funciones.php';
//include templates
incluirTemplate('header');
?>


<main class="contenedor seccion">
    <h1>Crear propiedad</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error"><?php echo $error ?></div>
    <?php endforeach; ?>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <form class="formulario" method="POST">

        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título:</label>
            <input type="text" placeholder="Título propiedad" id="titulo" name="titulo" value="<?php echo $titulo ?>">

            <label for="precio">Precio:</label>
            <input type="number" placeholder="Precio propiedad" id="precio" name="precio" value="<?php echo $precio ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información de la propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" placeholder="Ej: 3" id="habitaciones" name="habitaciones" value="<?php echo $habitaciones ?>">

            <label for="wc">WC:</label>
            <input type="number" placeholder="Ej: 1" min="1" max="9" id="wc" name="wc" value="<?php echo $wc ?>">

            <label for="estacionamiento">Estacionamientos:</label>
            <input type="number" placeholder="Ej: 2" min="1" max="9" id="estacionamiento" name="estacionamiento" value="<?php echo $estacionamiento ?>">

        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <select id="vendedorId" name="vendedorId">
                <option value="" disabled selected>--Seleccione un vendedor--</option>
                <?php while ($row = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $vendedorId === $row['id']  ? 'selected' : '' ?> value="<?php echo $row['id'] ?>"><?php echo $row['nombre'] . " " . $row['apellido'] ?></option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear propiedad" class="boton-verde">
    </form>
</main>



<?php incluirTemplate('footer'); ?>