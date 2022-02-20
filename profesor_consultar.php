<?php
require 'PDO.php';
session_start();



$estudiantes = array();
$message = null;
if (sizeof($_SESSION) > 0 && $_SESSION['tipo_usuario'] == "P") { //solo el usuario de tipo p podra registrar calificaciones
    $pdo = new CustomPDO();

    $usuario = $pdo->getDatosUsuario($_SESSION['id_usuario']);
    $registrosCalificaciones = $pdo->registrosCalificaciones();
    $materias = $registrosCalificaciones['materias'];
    $resultados = $registrosCalificaciones['consulta'];
} else {
    header("Location: login.php");
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
    <title>Consulta de calificaciones</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand" href="#">EdP</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item ">
                    <a class="nav-link" href="index.php">Inicio </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="registrar_calificacion.php">Registra calificación</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="profesor_consultar.php">Consultar</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="#">Usuario <?= $tipoUsuario ?></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="logout.php">Cerrar sesión</a>
                </li>

            </ul>

        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Consulta de calificaciones</h1>

        <br />
        <div class="alert alert-success bt-5" role="alert">
            Matrícula: <strong><?= $usuario['id_usuario'] ?></strong>
            Nombre: <strong><?= $usuario['nombre'] ?> <?= $usuario['paterno'] ?> <?= $usuario['materno'] ?></strong>
        </div>

        <br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <?php
                    foreach ($materias as $materia) {
                    ?>
                        <th><?= $materia['nombre'] ?></th>
                    <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody>


                <?php
                foreach ($resultados as $alumno) {
                ?>
                    <tr>
                        <td><?= $alumno['id_usuario'] ?></td>
                        <?php
                        foreach ($materias as $materia) {
                        ?>
                            <td><?= $alumno['calificaciones'][$materia['id_materia']] ?></td>
                        <?php
                        }
                        ?>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>

</html>