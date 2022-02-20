<?php
require 'PDO.php';

$message = null;
session_start();
$pdo = new CustomPDO();

if (sizeof($_POST) > 0) {

    if (!isset($_POST['id'])) {
        $message = "Ingrese el id del usuario";
    } else if (!isset($_POST['pass'])) {
        $message = "Ingrese la contraseña";
    } else {
        $pass = $_POST['pass'];
        $id = $_POST['id'];
        
        $user = $pdo->getUser($id, $pass);
        print_r($user);
        
        if (is_null($user)) {
            $message = "ID o contraseña incorrecta";
        } else {
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre_usuario'] = $user['nombre_usuario'];
            $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
            header("Location: index.php");
        }
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
    <title>Login</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="registro.php">Registrarse</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="login.php">Iniciar sesión</a>
                </li>

            </ul>

        </div>
    </nav>

    <div class="container pt-5" style="height: 70vh;display: flex; justify-content: center;">
        <div>
            <h4>Inicio de sesión</h4>
            <form method="post" action="login.php" class="mt-3" style="min-width: 30vw">
                <div class=" form-group">
                    <label for="id">Id Usuario</label>
                    <input type="text" name="id" class="form-control" placeholder="Ingresa el id del usuario">
                </div>
                <div class=" form-group">
                    <label for="pass">Contraseña</label>
                    <input type="password" name="pass" class="form-control" placeholder="Ingresa la contraseña">
                </div>
                <button type="submit" class="btn btn-success">Iniciar sesión</button>
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