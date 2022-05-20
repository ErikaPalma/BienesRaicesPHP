<?php
//archivo funciones
require '../../includes/funciones.php';

$auth = estaAutenticado();
if (!$auth) {
    //Si no está autenticado
    header('Location: /');
}

$id = $_GET['id'];
//validar que es un número
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}

//BBDD
require '../../includes/config/database.php';
$db = conectarDB();

//Consulta para obtener los datos de la propiedad según ID
$consulta = "SELECT * FROM propiedades WHERE id = ${id}";
$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_assoc($resultado);
var_dump($propiedad);

//Consulta para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

/* Inicializan vacías y cuando se le da a enviar se crean y toman sus valores
De este modo, si el usuario no rellena
todos los campos, se muestran en el formulario los que sí rellenó y
no tiene que escribir todo desde 0.
Además de esto, hay que meter cada variable en el value de cada campo para
que se muestren*/
$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedorId = $propiedad['vendedorId'];
$imagenPropiedad = $propiedad['imagen'];

//Array para mensajes de error
$errores = [];

//Ejecuta el código una vez que el usuario envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    //Sanitizar entrada de datos
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string($db, $_POST['vendedorId']);
    $creado = date('Y/m/d');
    //Asignar files a una variable
    $imagen = $_FILES['imagen'];


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

    //Validar imagen por tamaño (100kb máx)
    $medida = 1000 * 1000;
    if ($imagen['size'] > $medida) {
        $errores[] = "La imagen es demasiado grande";
    }

    //Si no hay errores, se inserta en la BD
    if (empty($errores)) {

        /* *SUBIDA DE ARCHIVOS */
        //Crear carpeta en la raíz del proyecto
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        if ($imagen['name']) {
            //Si hay nueva imagen, eliminar imagen previa
            unlink($carpetaImagenes . $propiedad['imagen']);
            //Generar nombre único para imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            //Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        } else {
            //Si no actualizamos la imagen
            $nombreImagen = $propiedad['imagen'];
        }

        //Insertar en la BD
        $query = "UPDATE propiedades SET titulo = '${titulo}', precio = ${precio}, imagen = '${nombreImagen}', descripcion = '${descripcion}',
                                                habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento},
                                                vendedorId = ${vendedorId} WHERE id = ${id}";


        //Guardar resultado en la BD
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            //Si todo ok, redireccionar al usuario utilizando query string
            header('Location: /admin?resultado=2');
        }
    }
}

//include templates
incluirTemplate('header');
?>


<main class="contenedor seccion">
    <h1>Actualizar propiedad</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error"><?php echo $error ?></div>
    <?php endforeach; ?>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <form class="formulario" method="POST" enctype="multipart/form-data">

        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título:</label>
            <input type="text" placeholder="Título propiedad" id="titulo" name="titulo" value="<?php echo $titulo ?>">

            <label for="precio">Precio:</label>
            <input type="number" placeholder="Precio propiedad" id="precio" name="precio" value="<?php echo $precio ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            <img src="/imagenes/<?php echo $imagenPropiedad ?>" class="imagen-small">

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

        <input type="submit" value="Actualizar" class="boton-verde">
    </form>
</main>



<?php incluirTemplate('footer'); ?>