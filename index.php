<?php
session_start();

$tipoUsuario = null; //Invitado
$nombreUsuario = null;
if (sizeof($_SESSION) > 0) {
    $tipoUsuario = $_SESSION['tipo_usuario'] == "P" ? "Profesor" : "Alumno";
    $nombreUsuario = $_SESSION['nombre_usuario'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Inicio</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand" href="#">EdP</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Inicio </a>
                </li>


                <?php
                if (is_null($tipoUsuario)) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="registro.php">Registrarse</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="login.php">Iniciar sesión</a>
                    </li>
                <?php } ?>

                <?php
                if ($tipoUsuario == "Profesor") { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="registrar_calificacion.php">Registra calificación</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profesor_consultar.php">Consultar</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">Usuario <?= $tipoUsuario ?></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="logout.php">Cerrar sesión</a>
                    </li>

                <?php } ?>
                <?php
                if ($tipoUsuario == "Alumno") { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="estudiante_consulta.php">Consultar calificación</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">Usuario <?= $tipoUsuario ?></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="logout.php">Cerrar sesión</a>
                    </li>
                <?php } ?>

            </ul>

        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Escuela de programación</h1>

        <?php
        if (!is_null($tipoUsuario)) { ?>
            <br />
            <div class="alert alert-success bt-5" role="alert">
                "Bienvenido <strong><?= $nombreUsuario ?></strong>, has iniciado como <strong><?= $tipoUsuario ?>"</strong>
            </div>
        <?php } ?>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>

</html>