<?php

session_start();


unset($_SESSION['id_usuario']);
unset($_SESSION['tipo_usuario']);
unset($_SESSION['nombre_usuario']);
header("Location: login.php");
