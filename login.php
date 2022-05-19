<?php
require 'includes/config/database.php';
$db = conectarDB();
//Autenticar usuario
$errores = [];
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Sanitizar y filtro para validar email
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    //Validación
    if (!$email) {
        $errores[] = "El email es obligatorio";
    }
    if (!$password) {
        $errores[] = "La contraseña es obligatoria";
    }

    if (empty($errores)) {
    }
}

//Incluye header
require 'includes/funciones.php';
incluirTemplate('header');
?>


<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error"><?php echo $error; ?></div>
    <?php endforeach; ?>
    <form method="POST" class="formulario">
        <fieldset>
            <legend>Email y Contraseña</legend>

            <label for="email">E-mail</label>
            <input type="email" placeholder="Tu Email" id="email" name="email" value="<?php echo $email ?>" required>

            <label for="password">Contraseña</label>
            <input type="password" placeholder="Tu Contraseña" id="password" name="password" required>
        </fieldset>
        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer'); ?>