<?php
session_start();
//Se puede destruir la sesión o reiniciar el array de sesión como vacío.
session_destroy();
header('Location: /');
