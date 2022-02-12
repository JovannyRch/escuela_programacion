<?php

require 'PDO.php';


function hasLetters($pass)
{
    $validChars = "abcdefghijklmnopqrstuvwxyz";
    $passLower = strtolower($pass);
    for ($i = 0; $i < strlen($passLower); $i++) {
        if (str_contains($validChars, $passLower[$i])) {
            return true;
        }
    }
    return false;
}

function hasNumbers($pass)
{
    $validChars = "1234567890";
    for ($i = 0; $i < strlen($pass); $i++) {
        if (str_contains($validChars, $pass[$i])) {
            return true;
        }
    }
    return false;
}

function hasEspecialChars($pass)
{
    $validChars = "#$-_&%";
    $passLower = strtolower($pass);
    for ($i = 0; $i < strlen($passLower); $i++) {
        if (str_contains($validChars, $passLower[$i])) {
            return true;
        }
    }
    return false;
}

function validarCampos(&$message)
{
    if (sizeof($_POST) == 0) {
        return false;
    }

    if (!isset($_POST['pass'])) {
        $message = "Ingrese contraseña";
        return false;
    }

    if (!isset($_POST['pass2'])) {
        $message = "Ingrese confirmación de la contraseña";
        return false;
    }

    if (!isset($_POST['id'])) {
        $message = "Ingrese id del usuario";
        return false;
    }

    if (!isset($_POST['name'])) {
        $message = "Ingrese nombre del usuario";
        return false;
    }

    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $id = $_POST['id'];
    $name = $_POST['name'];

    if ($pass2 != $pass) { //Verificacion de contraseña y confirmación de contraseña iguales
        $message = "Las contraseñas no coinciden";
        return false;
    }

    if (strlen($pass) < 8) { //Verificacion contraseña de 8 carácteres al menos
        $message = "La contraseña debe de tener al menos 8 carácteres";
        return false;
    }

    if (!hasEspecialChars($pass) || !hasNumbers($pass) || !hasLetters($pass)) {
        $message = "La contraseña debe tener letras y números y al menos un carácter especial (#,$, -_,&,%)";
        return false;
    }


    return true;
}

$message = null;

if (validarCampos($message)) {
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $id = $_POST['id'];
    $name = $_POST['name'];

    $pdo = new CustomPDO();
    $idUserExists = !is_null($pdo->getUserById($id)); //Validar si el id del usuario existe
    if ($idUserExists) {
        $message = "El id del usuario ya se encuentra ocupado";
    } else {
        $pdo->registrarAlumno($id, $name, $pass); //Registro del alumno 
        $message = "Usuario registrado exitosamente";
    }
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
    <title>Registro de usuario</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="registro.php">Registrarse</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="login.php">Iniciar sesión</a>
                </li>

            </ul>

        </div>
    </nav>
    <div class="container pt-5" style="height: 70vh;display: flex; justify-content: center;">
        <div>
            <h4>Registro de usuario</h4>
            <form method="post" action="registro.php" class="mt-3" style="min-width: 30vw">
                <div class=" form-group">
                    <label for="id">Id Usuario</label>
                    <input type="text" name="id" class="form-control" placeholder="Ingresa el id del usuario">
                </div>
                <div class=" form-group">
                    <label for="name">Nombre del usuario</label>
                    <input type="text" name="name" class="form-control" placeholder="Ingresa nombre del usuario">
                </div>
                <div class=" form-group">
                    <label for="pass">Contraseña</label>
                    <input type="password" name="pass" class="form-control" placeholder="Ingresa la contraseña">
                </div>
                <div class=" form-group">
                    <label for="pass2">Confirmación de la contraseña</label>
                    <input type="password" name="pass2" class="form-control" placeholder="Ingresa nuevamente">
                </div>
                <button type="submit" class="btn btn-success">Registrarse</button>
            </form>
            <?php
            if (!is_null($message)) { ?>
                <br />
                <div class="alert alert-warning text-center" role="alert">
                    <strong> <?= $message ?></strong>
                </div>
            <?php } ?>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>

</html>