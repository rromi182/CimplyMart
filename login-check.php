<?php

require_once "config/database.php";
$url_base = "//" . $_SERVER['HTTP_HOST'] . ":" . $_SERVER['SERVER_PORT'] . "/CimplyMart";

$username = mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['username']))))); //validacion de datos

$password = md5(mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['password'])))))); //validacion de datos

if (!ctype_alnum($username) or !ctype_alnum($password)) {
    header("Location: index.php?alert=1");
} else {
    $query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE username = '$username' AND password='$password' AND status = 'activo'")
        or die('error' . mysqli_error($mysqli));
    $rows = mysqli_num_rows($query); //verificar si hay algun usuario
    if ($rows > 0) {
        // Inicio de sesión exitoso, reiniciar el contador
        mysqli_query($mysqli, "UPDATE usuarios SET intentos = 0 WHERE username = '$username'");
        $data = mysqli_fetch_assoc($query);

        session_start();
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['password'] = $data['password'];
        $_SESSION['name_user'] = $data['name_user'];
        $_SESSION['permisos_acceso'] = $data['permisos_acceso'];

        //echo"Bienvenido al sistema, ";
        header("Location: modules/start/view.php");

    } else {
        // Credenciales incorrectas, incrementar el contador de intentos
        mysqli_query($mysqli, "UPDATE usuarios SET intentos = intentos + 1 WHERE username = '$username'");

        // Verificar si se superó el límite de intentos
        $result = mysqli_query($mysqli, "SELECT intentos FROM usuarios WHERE username = '$username'");
        $data = mysqli_fetch_assoc($result);
        $intentos = $data['intentos'];

        if ($intentos >= 3) {
            // Bloquear la cuenta
            mysqli_query($mysqli, "UPDATE usuarios SET status = 'bloqueado' WHERE username = '$username'");
            header("Location: index.php?alert=7"); // Mensaje de cuenta bloqueada
        } else {
            // Credenciales incorrectas, redirigir con mensaje de error según el número de intentos
            switch ($intentos) {
                case 1:
                    header("Location: index.php?alert=5"); // Primer intento fallido
                    break;
                case 2:
                    header("Location: index.php?alert=6"); // Segundo intento fallido
                    break;
                default:
                    header("Location: index.php?alert=1"); // Otros intentos fallidos
            }
        }
    }
}
