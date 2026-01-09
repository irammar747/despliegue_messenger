<?php

session_start();

session_unset(); //Borramos el contenido

session_destroy(); //Borramos la sesión

header('Location:index.php'); //Redirigimos al login
exit;