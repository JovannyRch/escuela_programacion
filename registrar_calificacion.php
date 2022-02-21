<?php
require 'PDO.php';
session_start();



$estudiantes = array();
$message = null;
if (sizeof($_SESSION) > 0 && $_SESSION['tipo_usuario'] == "P") { //solo el usuario de tipo p podra registrar calificaciones
    $pdo = new CustomPDO();

    $materias = $pdo->getMaterias();
    $estudiantes = $pdo->getEstudiantes();

    if(sizeof($_POST) > 0 && isset($_POST['calificacion']) && isset($_POST['estudiante']) && isset($_POST['materia'])){

        $calificacion = $_POST['calificacion'];
        $id_estudiante = $_POST['estudiante'];
        $id_materia = $_POST['materia'];

        $id_calificacion = $pdo->registrarCalificacion($id_estudiante, $id_materia, $calificacion);

        if(is_null($id_estudiante)){
            $message = "Error al registrar la calificación";
        }else{
            $message = "Calificación registrada correctamente";
        }
    }

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
    <title>Registro de calificaciones</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand" href="#">EdP</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio </a>
                </li>


                <li class="nav-item active">
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

            </ul>

        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Registro de calificaciones</h1>

        <form class="form" method="post" actio="registrar_calificacion.php">
            <div class="form-group">
                <label for="estudiante">Seleccione un estudiante</label>
                <select class="form-control" name="estudiante" id="estudiante">

                    <?php
                    foreach ($estudiantes as $alumno) {
                    ?>
                        <option value="<?= $alumno['id_usuario'] ?>">
                        <?= $alumno['id_usuario'] ?> - <?= $alumno['nombre'] ?> <?= $alumno['paterno'] ?> <?= $alumno['materno'] ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="materia">Seleccione una materia</label>
                <select class="form-control" name="materia" id="materia">

                    <?php
                    foreach ($materias as $materia) {
                    ?>
                        <option value="<?= $materia['id_materia'] ?>">
                            <?= $materia['nombre'] ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="calificacion">Calificación</label>
                <input required type="number" class="form-control" name="calificacion" id="calificacion" placeholder="Ingrese calificación del alumno (0-100)">
            </div>
            <button class="btn btn-success">
                Registrar
            </button>
        </form>


        <?php
            if (!is_null($message)) { ?>
                <br />
                <div class="alert alert-warning text-center" role="alert">
                    <strong> <?= $message ?></strong>
                </div>
            <?php } ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>

</html>